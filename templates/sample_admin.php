<?php

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
      'label' => 'チェックボックス'
    ],
    'has_child' => array(
      'label' => '子データあり',
    ),
    'child1' => array(
      'label' => '子データ1',
      'parent' => 'has_child'
    ),
    'child2' => array(
      'label' => '子データ2',
      'parent' => 'has_child_dummy'
    ),
  );
}
