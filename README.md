# シンプルおしらせ (Simple Oshirase)

ショートコードひとつで、投稿・固定ページ・ウィジェットにおしらせ一覧を表示するシンプルなWordPressプラグインです。

---

> *Dear What's New Generator,*
> *あなたが灯した火は、ここで燃え続けています。*
> — このプラグインは [What's New Generator](http://residentbird.main.jp/bizplugin/) へのオマージュとして生まれました。

---

## 特徴

- ショートコード `[shirase]` を貼り付けるだけでおしらせ一覧を表示
- NEW! マークの期間指定・最新記事への自動付与
- 表示コンテンツを「投稿」「固定ページ」「投稿＋固定ページ」から選択
- 表示順序：公開日順 / 更新日順
- カテゴリのスラッグ指定で絞り込み表示（投稿のみ）
- 「前へ / 次へ」ページネーション（ON/OFF切替）
- 旧互換ショートコード `[showwhatsnew]` への切り替えと競合警告
- 管理画面でリアルタイムプレビュー

## インストール

1. このリポジトリを ZIP でダウンロードします
2. `whats-new-genarator` フォルダごと `/wp-content/plugins/` にアップロードします
3. WordPress 管理画面の「プラグイン」メニューから **シンプルおしらせ** を有効化します
4. 「設定」→「シンプルおしらせ 設定」で設定します
5. おしらせを表示したいページ本文に `[shirase]` を貼り付けます

## 使い方

```
[shirase]
```

固定ページや投稿の本文、またはテキストウィジェットに貼り付けるだけで使えます。

## 動作環境

| 項目 | バージョン |
|---|---|
| WordPress | 5.3 以上 |
| PHP | 7.0 以上 |
| テスト済み | WordPress 6.8 |

## What's New Generator との互換性

本プラグインは What's New Generator とは**独立したプラグイン**です。設定は引き継がれません。

`[showwhatsnew]` 互換モードを使う場合は、**必ず What's New Generator を先に無効化**してください。

## ライセンス

[GPLv2 or later](./LICENSE)

## 製作者

- [sato32](https://github.com/recolon32)
- Claude (Anthropic)
