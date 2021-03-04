# mw-wp-form-with-template

Enable management of MW WP Form email body with template.

## usues

### WP MW FORMの本文の設定

テンプレートから出力する箇所に `__body_template__` を記述する。

```
{name} 様

ヘッダー

ーーーーーーーー

__body_template__

ーーーーーーーー

フッター
```

### function.phpに追記

```php:function.php
//
// activate
//
$form_id = 9; // user form id

// 管理者宛メール
add_filter( 'mwform_admin_mail_mw-wp-form-' . $form_id, function($Mail, $values, $Data) {
  $mwfwt = new MW_WP_Form_With_Template($Data, 'admin');
  $Mail->body = $mwfwt->combine();

  return $Mail;
}, 10, 3 );

// 自動返信メール
add_filter( 'mwform_auto_mail_mw-wp-form-' . $form_id, function($Mail, $values, $Data) {
  $mwfwt = new MW_WP_Form_With_Template($Data, 'auto');
  $Mail->body = $mwfwt->combine();

  return $Mail;
}, 10, 3 );
```

### テンプレートファイルを作成

- `/plugins/mw-wp-form-with-template/templates/` 内に、`<フォームID>_admin.php` / `<フォームID>_auto.php` の規則でファイルを作成
- 配列にテンプレになるデータを設置。例↓

```php
<?php

// NOTE: parantを設定してparentが存在しない場合出力されない
// NOTE: conditionsに出力条件を設定する
// NOTE: prepend, appendで前後に出力するテキストを設定する

if (!isset($template)) {
  $template = array(
    'name' => [
      'label' => '名前',
    ],
    'email' => [
      'label' => 'メールアドレス'
    ],
    'tel' => [
      'label' => '電話番号'
    ],
    'checkbox' => [
      'label' => 'チェックボックス',
      'append' => "\n",
    ],
    'has_child' => array(
      'label' => '子データあり',
      'prepend' => "■ プリペンド\n",
    ),
    'child1' => array(
      'label' => '子データ1',
      'parent' => 'has_child'
    ),
    'child2' => array(
      'label' => '子データ2',
      'parent' => 'has_child_dummy'
    ),
    'conditions' => array(
      'label' => 'マッチ条件',
      'conditions' => array(
        'key' => 'checkbox',
        'value' => 'one',
      )
    ),
    'conditions2' => array(
      'label' => 'マッチ条件2',
      'conditions' => array(
        'key' => 'checkbox',
        'value' => 'two',
      )
    )
  );
}
```

> NOTE: MW WP FORMの仕様上、メール本文の設定が空だとメールが送信されないので何か書いておく。

## 免責事項

当システムをご利用、もしくはご利用になれないことにより生じるいかなるトラブルや損害には、当方は一切の責任を負いません。
