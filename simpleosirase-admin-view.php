<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<div class="wrap">
	<h1>Oshirase Ichiran 設定</h1>

	<?php if ( $compat_mode ) : ?>
	<div class="notice notice-warning">
		<p>
			<strong>⚠️ 互換モード有効：</strong>
			ショートコード <code>[showwhatsnew]</code> を使用中です。
			「What's New Generator」プラグインが同時に有効になっていると競合します。
			<strong>必ず先に無効化してください。</strong>
		</p>
	</div>
	<?php endif; ?>

	<h2>ショートコード</h2>
	<p>以下のコードをコピーして、おしらせを表示したい固定ページや投稿の本文に貼り付けてください。</p>
	<p>
		<input type="text" value="<?php echo esc_attr($shortcode); ?>" readonly style="width:200px; font-family:monospace;" />
	</p>

	<form action="options.php" method="post">
		<?php settings_fields( $option_name ); ?>
		<?php do_settings_sections( $file ); ?>
		<p class="submit">
			<input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'oshirase-ichiran' ); ?>" />
		</p>
	</form>

	<h2>プレビュー</h2>
</div>
