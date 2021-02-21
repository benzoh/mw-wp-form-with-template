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

include_once( plugin_dir_path( __FILE__ ) . 'lib/tinyTemplate.php' );
class MW_WP_Form_With_Template {

  public $tpl;
  public $form_id;
  public $mail_type;
  public $data;
  public $admin_template;
  public $auto_template;

  public function __construct($data, $mail_type) {
    $this->tpl = new tinyTemplate();
    $this->form_id = $data->get('mw-wp-form-form-id');
    $this->mail_type = $mail_type;
    $this->data = $data;

    $this->default_admin_template = plugin_dir_path( __FILE__ ) . 'templates/default/admin.txt';
    $this->default_auto_template = plugin_dir_path( __FILE__ ) . 'templates/default/auto.txt';
  }

  public function combine() {
    $this->set_template_data();
    $this->set_values($this->data->gets());

    return $this->fetch_template();
  }

  public function set_template_data() {
    $this->admin_template = plugin_dir_path( __FILE__ ) . 'templates/'.$this->form_id.'/admin.txt';
    $this->auto_template = plugin_dir_path( __FILE__ ) . 'templates/'.$this->form_id.'/auto.txt';
  }

  public function set_values($values) {
    foreach ($values as $key => $value) {
      $value = $this->rebuild_array_data($value);
      $this->tpl->set($key, $value);
    }
  }

  public function fetch_template() {
    if ($this->mail_type === 'auto') {
      if (file_exists($this->auto_template)) {
        return $this->tpl->fetch($this->auto_template);
      }
      return $this->tpl->fetch($this->default_auto_template);
    }

    if (file_exists($this->admin_template)) {
      return $this->tpl->fetch($this->admin_template);
    }
    return $this->tpl->fetch($this->default_admin_template);
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