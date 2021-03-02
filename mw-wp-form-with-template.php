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
  }

  public function combine() {
    $this->set_rows($this->data->gets());

    return $this->fetch_template();
  }

  public function set_rows($values) {
    include_once $this->tpl;
    // var_dump($template);
    $this->rows = array();

    foreach ( $template as $key => $value ) {
      $this->rows[] = array(
        'label' => $value,
        'value' => $this->rebuild_array_data($values[$key])
      );
    }
    // var_dump($rows);
  }

  public function create_body_from_rows() {
    // TODO: ここから
    return 'body';
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