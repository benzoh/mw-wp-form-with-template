# mw-wp-form-with-template

Enable management of MW WP Form email body with template.

## usues

```php:function.php
//
// activate
//
$form_id = 9; // user form id

add_filter( 'mwform_admin_mail_mw-wp-form-' . $form_id, function($Mail, $values, $Data) {
  $mw_wp_form_with_template = new MW_WP_Form_With_Template();

  $mw_wp_form_with_template->set_values($Data->gets());
  $res = $mw_wp_form_with_template->fetch_template();
  $Mail->body = $res;

  return $Mail;
}, 10, 3 );
```
