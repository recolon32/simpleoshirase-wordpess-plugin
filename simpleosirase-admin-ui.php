<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class OSHIIC_Admin_UI {
	public $file_path;

	public function __construct( $path ) {
		$this->file_path = $path;
		$this->setUi();
	}

	public function setUi() {
		register_setting( OSHIIC::OPTIONS, OSHIIC::OPTIONS, array($this, 'validate') );
		add_settings_section('main_section', '表示設定', array($this, 'section_text_fn'), $this->file_path);
		add_settings_field('sos_title',         'タイトル',                     array($this, 'setting_title'),         $this->file_path, 'main_section');
		add_settings_field('sos_title_tag',     'タイトルのタグ',               array($this, 'setting_title_tag'),     $this->file_path, 'main_section');
		add_settings_field('sos_content_type',  '表示するコンテンツ',           array($this, 'setting_content_type'),  $this->file_path, 'main_section');
		add_settings_field('sos_category_name', 'カテゴリーのスラッグ',         array($this, 'setting_category_name'), $this->file_path, 'main_section');
		add_settings_field('sos_orderby',       '表示順序',                     array($this, 'setting_orderby'),       $this->file_path, 'main_section');
		add_settings_field('sos_number',        '表示件数（1〜30）',            array($this, 'setting_number'),        $this->file_path, 'main_section');
		add_settings_field('sos_newmark',       'NEW!マーク表示期間（0〜30日）',array($this, 'setting_newmark'),       $this->file_path, 'main_section');
		add_settings_field('sos_latest_new',    '最新記事にNEW!マークをつける', array($this, 'setting_latest_new'),    $this->file_path, 'main_section');
		add_settings_field('sos_pagination',    'ページネーション',             array($this, 'setting_pagination'),    $this->file_path, 'main_section');
		add_settings_field('sos_shortcode',     '使用するショートコード',       array($this, 'setting_shortcode'),     $this->file_path, 'main_section');
	}

	public function show_admin_page() {
		if ( ! current_user_can('manage_options') ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'simple-oshirase' ) );
		}
		$file        = $this->file_path;
		$option_name = OSHIIC::OPTIONS;
		$options     = OSHIIC::get_option();
		$shortcode   = '[' . OSHIIC::get_active_shortcode() . ']';
		$compat_mode = ( isset($options['sos_shortcode']) && $options['sos_shortcode'] === OSHIIC::SHORTCODE_COMPAT );
		include_once( dirname(__FILE__) . '/simpleosirase-admin-view.php' );
		$info = new OSHIIC_Info();
		include( dirname(__FILE__) . '/simpleosirase-view.php' );
	}

	public function validate( $input ) {
		$output = array();

		$output['sos_number'] = ( isset($input['sos_number']) && is_numeric($input['sos_number'])
			&& $input['sos_number'] >= 1 && $input['sos_number'] <= 30 )
			? absint($input['sos_number']) : 10;

		$output['sos_newmark'] = ( isset($input['sos_newmark']) && is_numeric($input['sos_newmark'])
			&& $input['sos_newmark'] >= 0 && $input['sos_newmark'] <= 30 )
			? absint($input['sos_newmark']) : 0;

		$output['sos_title']         = isset($input['sos_title'])         ? sanitize_text_field($input['sos_title'])         : '';
		$output['sos_category_name'] = isset($input['sos_category_name']) ? sanitize_text_field($input['sos_category_name']) : '';

		$allowed_tags = array('h1', 'h2', 'h3', 'h4', 'p');
		$output['sos_title_tag'] = ( isset($input['sos_title_tag']) && in_array($input['sos_title_tag'], $allowed_tags, true) )
			? $input['sos_title_tag'] : 'h2';

		$allowed_content_types = array('投稿', '固定ページ', '投稿＋固定ページ');
		$output['sos_content_type'] = ( isset($input['sos_content_type']) && in_array($input['sos_content_type'], $allowed_content_types, true) )
			? $input['sos_content_type'] : '投稿';

		$allowed_orderby = array('公開日順', '更新日順');
		$output['sos_orderby'] = ( isset($input['sos_orderby']) && in_array($input['sos_orderby'], $allowed_orderby, true) )
			? $input['sos_orderby'] : '公開日順';

		$output['sos_latest_new'] = ! empty($input['sos_latest_new']);
		$output['sos_pagination'] = ! empty($input['sos_pagination']);

		$output['sos_shortcode'] = ( isset($input['sos_shortcode']) && $input['sos_shortcode'] === OSHIIC::SHORTCODE_COMPAT )
			? OSHIIC::SHORTCODE_COMPAT : OSHIIC::SHORTCODE_NEW;

		return $output;
	}

	public function section_text_fn() {}

	public function setting_title() {
		$options = OSHIIC::get_option();
		$value   = isset($options['sos_title']) ? $options['sos_title'] : 'お知らせ';
		echo '<input id="sos_title" name="oshiic_options[sos_title]" size="40" type="text" value="' . esc_attr($value) . '" />';
	}

	public function setting_title_tag() {
		$options = OSHIIC::get_option();
		$current = isset($options['sos_title_tag']) ? $options['sos_title_tag'] : 'h2';
		$items   = array('h1', 'h2', 'h3', 'h4', 'p');
		echo '<select id="sos_title_tag" name="oshiic_options[sos_title_tag]">';
		foreach ( $items as $item ) {
			echo '<option value="' . esc_attr($item) . '"' . selected($current, $item, false) . '>' . esc_html($item) . '</option>';
		}
		echo '</select>';
	}

	public function setting_content_type() {
		$options = OSHIIC::get_option();
		$current = isset($options['sos_content_type']) ? $options['sos_content_type'] : '投稿';
		$items   = array('投稿', '固定ページ', '投稿＋固定ページ');
		foreach ( $items as $item ) {
			echo '<label><input' . checked($current, $item, false) . ' value="' . esc_attr($item) . '" name="oshiic_options[sos_content_type]" type="radio" /> ' . esc_html($item) . '</label><br />';
		}
	}

	public function setting_category_name() {
		$options = OSHIIC::get_option();
		$value   = isset($options['sos_category_name']) ? $options['sos_category_name'] : '';
		echo '<input id="sos_category_name" name="oshiic_options[sos_category_name]" size="40" type="text" value="' . esc_attr($value) . '" />';
	}

	public function setting_orderby() {
		$options = OSHIIC::get_option();
		$current = isset($options['sos_orderby']) ? $options['sos_orderby'] : '公開日順';
		$items   = array('公開日順', '更新日順');
		foreach ( $items as $item ) {
			echo '<label><input' . checked($current, $item, false) . ' value="' . esc_attr($item) . '" name="oshiic_options[sos_orderby]" type="radio" /> ' . esc_html($item) . '</label><br />';
		}
	}

	public function setting_number() {
		$options = OSHIIC::get_option();
		$value   = isset($options['sos_number']) ? absint($options['sos_number']) : 10;
		echo '<input id="sos_number" name="oshiic_options[sos_number]" size="2" type="number" min="1" max="30" value="' . esc_attr($value) . '" />件';
	}

	public function setting_newmark() {
		$options = OSHIIC::get_option();
		$value   = isset($options['sos_newmark']) ? absint($options['sos_newmark']) : 7;
		echo '<input id="sos_newmark" name="oshiic_options[sos_newmark]" size="2" type="number" min="0" max="30" value="' . esc_attr($value) . '" />日間';
	}

	public function setting_latest_new() {
		$options = OSHIIC::get_option();
		echo '<input id="sos_latest_new" name="oshiic_options[sos_latest_new]" type="checkbox" value="1"' . checked( ! empty($options['sos_latest_new']), true, false ) . ' />';
		echo '<label for="sos_latest_new"> 最新の1件にNEW!マークをつける</label>';
	}

	public function setting_pagination() {
		$options = OSHIIC::get_option();
		echo '<input id="sos_pagination" name="oshiic_options[sos_pagination]" type="checkbox" value="1"' . checked( ! empty($options['sos_pagination']), true, false ) . ' />';
		echo '<label for="sos_pagination"> 「前へ / 次へ」ボタンを表示する</label>';
	}

	public function setting_shortcode() {
		$options = OSHIIC::get_option();
		$current = isset($options['sos_shortcode']) ? $options['sos_shortcode'] : OSHIIC::SHORTCODE_NEW;

		echo '<label><input' . checked($current, OSHIIC::SHORTCODE_NEW, false) . ' value="' . esc_attr(OSHIIC::SHORTCODE_NEW) . '" name="oshiic_options[sos_shortcode]" type="radio" /> <code>[shirase]</code>（推奨）</label><br />';
		echo '<label><input' . checked($current, OSHIIC::SHORTCODE_COMPAT, false) . ' value="' . esc_attr(OSHIIC::SHORTCODE_COMPAT) . '" name="oshiic_options[sos_shortcode]" type="radio" /> <code>[showwhatsnew]</code>（旧互換）</label>';

		if ( $current === OSHIIC::SHORTCODE_COMPAT ) {
			echo '<div class="sos-compat-warning" style="margin-top:8px; padding:10px 14px; background:#fff3cd; border-left:4px solid #f0ad4e; border-radius:2px;">';
			echo '<strong>⚠️ 注意：</strong>「What\'s New Generator」プラグインが有効になっていると <code>[showwhatsnew]</code> が衝突します。<br>';
			echo '<strong>必ずそちらを先に無効化してから</strong>、このショートコードを使用してください。';
			echo '</div>';
		}
	}
}
