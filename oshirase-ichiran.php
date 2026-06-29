<?php
/*
 * Dear What's New Generator,
 *
 * あなたのことを、はじめて見たときのことを覚えています。
 * ショートコードひとつで、WordPressのどのページにも
 * 「新着情報」を届けられる。ただそれだけのことが、
 * どれほど多くの人の助けになったことか。
 *
 * 難しいことは何もしなかった。それが、あなたの美しさでした。
 *
 * このプラグインは、あなたへの敬意から生まれました。
 * 「シンプルおしらせ」という名前で、
 * あなたが大切にしたシンプルさを受け継ぎながら、
 * 現代のWordPressの作法をまとって、静かに歩き出します。
 *
 * あなたが灯した火は、ここで燃え続けています。
 *
 *                        — Simple Oshirase, 2026
 */

/*
 Plugin Name: Oshirase Ichiran
 Plugin URI: https://github.com/recolon32/simpleoshirase-wordpess-plugin
 Description: お知らせを一覧でシンプルに並べるプラグインです。ショートコードで固定ページや投稿に新着情報を表示します。What's New Generator (v2.0.2 by Hideki Tanaka) へのオマージュとして書き直しました。
 Version: 1.0.0
 Author: sato32, Claude (Anthropic)
 Author URI: https://github.com/recolon32
 License: GPLv2 or later
 License URI: https://www.gnu.org/licenses/gpl-2.0.html
 Text Domain: oshirase-ichiran
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

include_once( dirname(__FILE__) . '/simpleosirase-admin-ui.php' );
new SimpleOshirase();

class SOS {
	const VERSION          = '1.0.0';
	const OPTIONS          = 'simple_oshirase_options';
	const PAGE_SLUG        = 'oshirase-ichiran';
	const SHORTCODE_NEW    = 'shirase';
	const SHORTCODE_COMPAT = 'showwhatsnew';

	public static function get_option() {
		$options = get_option( self::OPTIONS );
		return is_array($options) ? $options : array();
	}

	public static function update_option( $options ) {
		if ( empty($options) ) {
			return;
		}
		update_option( self::OPTIONS, $options );
	}

	public static function enqueue_css_js() {
		wp_enqueue_style( 'simple-oshirase-style', plugins_url('simpleosirase.css', __FILE__), array(), self::VERSION );
	}

	public static function enqueue_admin_css_js() {
		wp_enqueue_style( 'simple-oshirase-style', plugins_url('simpleosirase.css', __FILE__), array(), self::VERSION );
	}

	public static function get_active_shortcode() {
		$options = self::get_option();
		return ( isset($options['sos_shortcode']) && $options['sos_shortcode'] === self::SHORTCODE_COMPAT )
			? self::SHORTCODE_COMPAT
			: self::SHORTCODE_NEW;
	}
}

class SimpleOshirase {

	public $adminUi;

	public function __construct() {
		register_activation_hook( __FILE__, array($this, 'on_activation') );
		add_action( 'admin_init',             array($this, 'on_admin_init') );
		add_action( 'admin_menu',             array($this, 'on_admin_menu') );
		add_action( 'admin_enqueue_scripts',  array($this, 'on_admin_enqueue_css_js') );
		add_action( 'wp_enqueue_scripts',     array($this, 'on_enqueue_css_js') );
		add_shortcode( SOS::get_active_shortcode(), array($this, 'show_shortcode') );
		add_filter( 'widget_text', 'do_shortcode' );
	}

	public function on_activation() {
		$options = SOS::get_option();
		if ( empty($options) ) {
			$options = array();
		}
		$defaults = array(
			'sos_title'         => 'お知らせ',
			'sos_content_type'  => '投稿',
			'sos_orderby'       => '公開日順',
			'sos_category_name' => '',
			'sos_title_tag'     => 'h2',
			'sos_newmark'       => '7',
			'sos_number'        => '10',
			'sos_latest_new'    => false,
			'sos_pagination'    => false,
			'sos_shortcode'     => SOS::SHORTCODE_NEW,
		);
		foreach ( $defaults as $key => $value ) {
			if ( ! isset($options[$key]) ) {
				$options[$key] = $value;
			}
		}
		SOS::update_option( $options );
	}

	public function on_admin_init() {
		$this->adminUi = new SOSAdminUi( SOS::PAGE_SLUG );
	}

	public function on_admin_enqueue_css_js( $hook ) {
		if ( 'settings_page_' . SOS::PAGE_SLUG !== $hook ) {
			return;
		}
		SOS::enqueue_admin_css_js();
	}

	public function on_admin_menu() {
		add_options_page(
			'Oshirase Ichiran 設定',
			'Oshirase Ichiran 設定',
			'manage_options',
			SOS::PAGE_SLUG,
			array($this, 'dispatch_admin_page')
		);
	}

	public function dispatch_admin_page() {
		$this->adminUi->show_admin_page();
	}

	public function on_enqueue_css_js() {
		if ( is_admin() ) {
			return;
		}
		SOS::enqueue_css_js();
	}

	public function show_oshirase() {
		$info = new OshiraseInfo();
		include( dirname(__FILE__) . '/simpleosirase-view.php' );
	}

	public function show_shortcode() {
		ob_start();
		$this->show_oshirase();
		$contents = ob_get_contents();
		ob_end_clean();
		return $contents;
	}
}

class OshiraseInfo {
	public $title;
	public $title_tag;
	public $items          = array();
	public $current_page   = 1;
	public $total_pages    = 1;
	public $pagination_enabled = false;

	private static $allowed_title_tags    = array('h1', 'h2', 'h3', 'h4', 'p');
	private static $allowed_content_types = array('投稿', '固定ページ', '投稿＋固定ページ');
	private static $allowed_orderby       = array('公開日順', '更新日順');

	public function __construct() {
		$options = SOS::get_option();

		$this->title = esc_html( $options['sos_title'] ?? 'お知らせ' );

		$title_tag       = isset($options['sos_title_tag']) ? $options['sos_title_tag'] : 'h2';
		$this->title_tag = in_array($title_tag, self::$allowed_title_tags, true) ? $title_tag : 'h2';

		$content_type = ( isset($options['sos_content_type']) && in_array($options['sos_content_type'], self::$allowed_content_types, true) )
			? $options['sos_content_type'] : '投稿';

		if ( $content_type === '投稿' ) {
			$post_type = 'post';
		} elseif ( $content_type === '固定ページ' ) {
			$post_type = 'page';
		} else {
			$post_type = array('post', 'page');
		}

		$orderby_opt = ( isset($options['sos_orderby']) && in_array($options['sos_orderby'], self::$allowed_orderby, true) )
			? $options['sos_orderby'] : '公開日順';
		$orderby = ( $orderby_opt === '公開日順' ) ? 'date' : 'modified';

		$per_page              = absint($options['sos_number'] ?? 10);
		$this->pagination_enabled = ! empty($options['sos_pagination']);

		if ( $this->pagination_enabled ) {
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$this->current_page = max(1, absint($_GET['sos_page'] ?? 1));
		}

		$args = array(
			'post_type'      => $post_type,
			'posts_per_page' => $per_page,
			'paged'          => $this->current_page,
			'order'          => 'DESC',
			'orderby'        => $orderby,
			'category_name'  => sanitize_text_field($options['sos_category_name'] ?? ''),
			'post_status'    => 'publish',
		);

		$query = new WP_Query( $args );
		$this->total_pages = $this->pagination_enabled ? (int) $query->max_num_pages : 1;

		foreach ( $query->posts as $i => $post ) {
			$this->items[] = new OshiraseItem($post, $i, $options);
		}
		wp_reset_postdata();
	}
}

class OshiraseItem {
	public $date;
	public $raw_date;
	public $title;
	public $url;
	public $newmark;

	public function __construct( $post, $index, $options ) {
		$orderby        = isset($options['sos_orderby']) ? $options['sos_orderby'] : '公開日順';
		$this->raw_date = ( $orderby === '公開日順' ) ? $post->post_date : $post->post_modified;
		$this->date     = wp_date( get_option('date_format'), strtotime($this->raw_date) );
		$this->title    = esc_html( $post->post_title );
		$this->url      = get_permalink( $post->ID );
		$this->newmark  = $this->is_new($index, $options);
	}

	private function is_new( $index, $options ) {
		if ( ! empty($options['sos_latest_new']) && $index === 0 ) {
			return true;
		}
		$term = isset($options['sos_newmark']) ? absint($options['sos_newmark']) : 0;
		if ( $term === 0 ) {
			return false;
		}
		$today     = (int) date_i18n('U');
		$post_date = (int) strtotime($this->raw_date);
		$diff      = ( $today - $post_date ) / ( 24 * 60 * 60 );
		return ( $term > $diff );
	}
}
