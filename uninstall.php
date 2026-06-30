<?php
// WordPress のアンインストール経由でない直接アクセスを防ぐ
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'oshiic_options' );
