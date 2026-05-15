=== シンプルおしらせ (Simple Oshirase) ===
Contributors: sato32, claude-ai
Plugin URI: https://github.com/recolon32
Tags: oshirase, what's new, shortcode, news, 新着情報
Requires at least: 5.3
Tested up to: 6.8
Requires PHP: 7.0
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

ショートコードひとつで、投稿・固定ページ・ウィジェットにおしらせ一覧を表示するシンプルなプラグインです。

== Description ==

シンプルおしらせは、What's New Generator へのオマージュとして生まれたプラグインです。

あのプラグインが大切にしたシンプルさを受け継ぎながら、現代のWordPressの作法（セキュリティ・コーディング規約）に合わせて書き直しました。

おしらせの日付とタイトルは自動的に表示され、タイトルをクリックすると該当の記事が開きます。

= 特徴 =

* ショートコード `[shirase]` を貼り付けるだけで、どのページにもおしらせ一覧を表示できます
* 期間を指定してタイトルに NEW! マークを表示できます
* 最新記事だけに NEW! マークをつける機能があります
* 表示するコンテンツを「投稿」「固定ページ」「投稿＋固定ページ」から選べます
* 表示順序は公開日順・更新日順から選択できます
* カテゴリのスラッグを指定して、特定カテゴリの記事だけを表示できます（投稿のみ）
* 「前へ / 次へ」ページネーションのON/OFFが設定できます
* 旧プラグイン（What's New Generator）との互換ショートコード `[showwhatsnew]` に切り替えられます
* 管理画面でプレビューを確認しながら設定できます

= What's New Generator との互換性について =

本プラグインは What's New Generator とは独立したプラグインです。
設定（オプション）はリセットされ、新規インストール扱いになります。

`[showwhatsnew]` ショートコードの互換モードを利用する場合は、
**必ず What's New Generator プラグインを先に無効化**してください。
同時に有効にするとショートコードが衝突します。

== Installation ==

1. `shirase` フォルダごと `/wp-content/plugins/` にアップロードします
2. WordPress 管理画面の「プラグイン」メニューから「シンプルおしらせ」を有効化します
3. 「設定」→「シンプルおしらせ 設定」で各項目を設定します
4. おしらせを表示したい固定ページや投稿の本文に `[shirase]` を貼り付けます

== Frequently Asked Questions ==

= 旧プラグインの設定を引き継げますか？ =

引き継ぎません。シンプルおしらせは独自の設定（`simple_oshirase_options`）を使用します。
有効化後、設定画面で改めてご設定ください。

= `[showwhatsnew]` のまま使い続けたい =

設定画面の「使用するショートコード」で `[showwhatsnew]`（旧互換）を選択できます。
ただし What's New Generator を先に無効化してください。

= ウィジェットでも使えますか？ =

はい。テキストウィジェットに `[shirase]` を貼り付けることで表示できます。

== Screenshots ==

1. おしらせ一覧の表示例
2. 管理画面の設定ページ

== Changelog ==

= 1.0.0 =
* 初版リリース
* What's New Generator（v2.0.2）へのオマージュとして全面書き直し
* セキュリティアップデート：全出力に esc_html / esc_attr / esc_url を適用
* 入力値の許可リストバリデーションを追加
* 権限チェックを manage_options に変更
* get_posts() から WP_Query に移行
* date() を WordPress 標準の wp_date() に変更
* 「前へ / 次へ」ページネーション機能を追加（ON/OFF切替）
* 互換ショートコード [showwhatsnew] の選択機能と競合警告を追加
* PHP 4 時代の var キーワード・参照渡しコールバックを廃止

== Upgrade Notice ==

= 1.0.0 =
What's New Generator からの移行の場合、設定の自動引き継ぎはありません。有効化後に設定画面から再設定してください。
