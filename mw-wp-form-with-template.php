<?php
/**
 * Plugin Name: MW WP Form With Template
 * Plugin URI: https://github.com/hippohack/mw-wp-form-with-template
 * Description: Enable management of MW WP Form email body with template.
 * Version: 0.0.1
 * Author: @hippohack
 * Author URI: https://twitter.com/hippohack
 * Text Domain:
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package
 * @author hippohack
 * @license GPL-2.0+
 */

class MW_WP_Form_With_Template {

  public $tpl;
  public $form_id;
  public $mail;
  public $data;
  public $rows;

  public function __construct($mail, $data) {
    $this->form_id = $data->get('mw-wp-form-form-id');
    $this->mail = $mail;
    $this->data = $data;
    $this->tpl = plugin_dir_path( __FILE__ ) . 'templates/'.$this->form_id.'_admin.php';
    $this->rows = array();
  }

  public function combine() {
    $this->set_rows($this->data->gets());

    return str_replace( '__body_template__', $this->create_body_from_rows() , $this->mail->body );
  }

  public function set_rows($values) {
    include $this->tpl;
    // var_dump($template);

    foreach ( $template as $key => $value ) {
      // parentのチェックしてなかったらスキップ
      if ($value['parent'] && !$values[$value['parent']]) {
        continue;
      }

      $this->rows[] = array(
        'label' => $value['label'],
        'value' => $values[$key]
        // 'value' => $this->rebuild_array_data($values[$key])
      );
    }
    // var_dump($rows);
  }

  public function create_body_from_rows() {
    $body = '';
    foreach($this->rows as $key => $row) {
      $value = $this->pick_form_array_data($row['value']);

      if ($key === array_key_last($this->rows)) {
        $body .= $row['label'] . '：' . $value;
        break;
      }

      $body .= $row['label'] . '：' . $value . "\n";
    }

    return $body;
  }

  private function pick_form_array_data($value) {
    if (!is_array($value)) {
      return $value;
    }

    return str_replace( ',', ', ' , $value['data'] );
  }

  // チェックボックスなどの値が直接配列に入らないので整形する
  private function rebuild_array_data($value) {
    if (!is_array($value)) {
      return $value;
    }

    if (!isset($value['data']) || !isset($value['separator'])) {
      return $value;
    }

    $res = explode($value['separator'], $value['data']);
    return $res;
  }

}