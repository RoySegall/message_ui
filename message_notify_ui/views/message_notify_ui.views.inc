<?php
/**
 * @file
 * integration with the views module.
 */

/**
 * Implements hook_views_data().
 */
function message_notify_ui_views_data() {
  $data['message']['notify'] = array(
    'title' => t('Notify message'),
    'help' => t('Send the message using a notifier.'),
    'field' => array(
      'handler' => 'message_notify_ui_notify_button',
    ),
  );
  return $data;
}

/**
 * Implements hook_views_default_views_alter().
 */
function message_notify_ui_views_default_views_alter(&$views) {
  if (!in_array('message', array_keys($views))) {
    return;
  }

  $handler =& $views['message']->display['default']->handler;

  $handler->display->display_options['style_options']['columns'] += array(
    'notify' => 'view',
  );

  $handler->display->display_options['style_options']['info'] += array(
    'notify' => array(
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
  );

  /* Field: Message: Notify message */
  $handler->display->display_options['fields']['notify']['id'] = 'notify';
  $handler->display->display_options['fields']['notify']['table'] = 'message';
  $handler->display->display_options['fields']['notify']['field'] = 'notify';
  $handler->display->display_options['fields']['notify']['label'] = 'Notify message';
  $handler->display->display_options['fields']['notify']['element_label_colon'] = FALSE;

  /* Field: Bulk operations: Message */
  $handler->display->display_options['fields']['views_bulk_operations']['id'] = 'views_bulk_operations';
  $handler->display->display_options['fields']['views_bulk_operations']['table'] = 'message';
  $handler->display->display_options['fields']['views_bulk_operations']['field'] = 'views_bulk_operations';
  $handler->display->display_options['fields']['views_bulk_operations']['vbo_settings']['display_type'] = '0';
  $handler->display->display_options['fields']['views_bulk_operations']['vbo_settings']['enable_select_all_pages'] = 1;
  $handler->display->display_options['fields']['views_bulk_operations']['vbo_settings']['force_single'] = 0;
  $handler->display->display_options['fields']['views_bulk_operations']['vbo_settings']['entity_load_capacity'] = '10';
  $handler->display->display_options['fields']['views_bulk_operations']['vbo_operations'] = array(
    'action::message_notify_send_email_vbo' => array(
      'selected' => 1,
      'postpone_processing' => 0,
      'skip_confirmation' => 0,
      'override_label' => 0,
      'label' => '',
    ),
  );
}
