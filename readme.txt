=== Oshirase Ichiran ===
Contributors: sato32
Plugin URI: https://github.com/recolon32/simpleoshirase-wordpess-plugin
Tags: shortcode, news, widget, posts
Requires at least: 5.3
Tested up to: 7.0
Requires PHP: 7.0
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display a news/notice list anywhere on your site using a simple shortcode. Designed for Japanese WordPress sites.

== Description ==

**Oshirase Ichiran** (おしらせ一覧) displays a list of recent posts or pages anywhere on your WordPress site using a single shortcode.

お知らせを一覧でシンプルに並べるプラグインです。`[shirase]` をページや投稿に貼り付けるだけで新着情報を自動表示します。

This plugin is an homage to the original "What's New Generator" by Hideki Tanaka, rewritten for modern WordPress with security updates and new features.

= Features =

* Display a news list anywhere with the `[shirase]` shortcode
* Show a NEW! badge for recent posts (customizable time period)
* Optionally mark the latest post with a NEW! badge automatically
* Choose content type: Posts, Pages, or both
* Sort by published date or last modified date
* Filter by category slug (Posts only)
* Optional "Prev / Next" pagination (on/off toggle)
* Compatible shortcode `[showwhatsnew]` for migration from What's New Generator
* Live preview in the admin settings page

---

シンプルおしらせは、ショートコードひとつでサイトのどこにでもおしらせ一覧を表示できるプラグインです。

= 特徴 =

* `[shirase]` を貼り付けるだけでおしらせ一覧を表示
* NEW! マークの期間指定・最新記事への自動付与
* 表示コンテンツを「投稿」「固定ページ」「投稿＋固定ページ」から選択
* 表示順序：公開日順 / 更新日順
* カテゴリのスラッグ指定で絞り込み（投稿のみ）
* 「前へ / 次へ」ページネーション（ON/OFF）
* What's New Generator からの移行用互換ショートコード `[showwhatsnew]`
* 管理画面でリアルタイムプレビュー

= What's New Generator との互換性 =

本プラグインは What's New Generator とは独立したプラグインです。設定は引き継がれません。

`[showwhatsnew]` 互換モードを使う場合は、**必ず What's New Generator を先に無効化**してください。同時に有効にするとショートコードが衝突します。

== Installation ==

1. Upload the `simpleoshirase-wordpess-plugin` folder to `/wp-content/plugins/`
2. Activate the plugin from the WordPress admin "Plugins" menu
3. Go to "Settings" → "シンプルおしらせ 設定" to configure
4. Add `[shirase]` to any page or post where you want to display the notice list

== Frequently Asked Questions ==

= Can I migrate settings from What's New Generator? =

No. Simple Oshirase uses its own option key (`simple_oshirase_options`). Please reconfigure after activation.

= Can I keep using `[showwhatsnew]`? =

Yes. In the settings page, switch the shortcode to `[showwhatsnew]` (legacy mode). Make sure to deactivate What's New Generator first to avoid conflicts.

= Does it work in widgets? =

Yes. Paste `[shirase]` into a Text widget and it will display correctly.

= What languages is the admin UI in? =

The admin settings page is currently in Japanese only. English localization is planned for a future release.

== Changelog ==

= 1.0.0 =
* Initial release
* Homage to What's New Generator (v2.0.2) by Hideki Tanaka — fully rewritten for modern WordPress
* Security: applied esc_html / esc_attr / esc_url to all output
* Security: added allowlist validation for all settings
* Security: changed capability check to manage_options
* Replaced get_posts() with WP_Query for better pagination support
* Replaced date() with WordPress-native wp_date()
* Added "Prev / Next" pagination with on/off toggle
* Added legacy shortcode [showwhatsnew] selector with conflict warning
* Removed PHP 4-era var keyword and pass-by-reference callbacks
* Added uninstall.php for clean database removal

== Upgrade Notice ==

= 1.0.0 =
Initial release. If migrating from What's New Generator, settings will not be carried over — please reconfigure after activation.
