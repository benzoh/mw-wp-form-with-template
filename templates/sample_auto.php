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
