<?php
/**
 * @file
 * integration with the views module.
 */

/**
 * Implements hook_views_data().
 */
function message_ui_views_data() {
  $data['message']['delete'] = array(
    'title' => t('Delete message'),
    'help' => t('Link to delete the message instance.'),
    'field' => array(
      'handler' => 'message_ui_delete_button',
    ),
  );
  $data['message']['edit'] = array(
    'title' => t('Edit message'),
    'help' => t('Link to edit the message instance.'),
    'field' => array(
      'handler' => 'message_ui_edit_button',
    ),
  );
  $data['message']['view'] = array(
    'title' => t('View message'),
    'help' => t('Link to view the message instance.'),
    'field' => array(
      'handler' => 'message_ui_view_button',
    ),
  );
  return $data;
}

/**
 * Implements hook_views_default_views_alter().
 */
function message_ui_views_default_views_alter(&$views) {
  if (!in_array('message', array_keys($views))) {
    return;
  }

  $handler =& $views['message']->display['default']->handler;

  $handler->display->display_options['style_options']['columns'] += array(
    'timestamp' => 'timestamp',
    'message_render' => 'message_render',
    'name' => 'name',
    'view' => 'view',
    'edit' => 'view',
    'delete' => 'view',
  );

  $handler->display->display_options['style_options']['info'] += array(
    'timestamp' => array(
      'sortable' => 1,
      'default_sort_order' => 'asc',
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'message_render' => array(
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'name' => array(
      'sortable' => 1,
      'default_sort_order' => 'asc',
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'view' => array(
      'align' => '',
      'separator' => ' ',
      'empty_column' => 0,
    ),
    'edit' => array(
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'delete' => array(
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
  );

  /* Field: Message: View message */
  $handler->display->display_options['fields']['view']['id'] = 'view';
  $handler->display->display_options['fields']['view']['table'] = 'message';
  $handler->display->display_options['fields']['view']['field'] = 'view';
  $handler->display->display_options['fields']['view']['label'] = 'Operations';
  $handler->display->display_options['fields']['view']['element_label_colon'] = FALSE;

  /* Field: Message: Edit message */
  $handler->display->display_options['fields']['edit']['id'] = 'edit';
  $handler->display->display_options['fields']['edit']['table'] = 'message';
  $handler->display->display_options['fields']['edit']['field'] = 'edit';
  $handler->display->display_options['fields']['view']['label'] = 'Operations';
  $handler->display->display_options['fields']['edit']['element_label_colon'] = FALSE;
  /* Field: Message: Delete message */
  $handler->display->display_options['fields']['delete']['id'] = 'delete';
  $handler->display->display_options['fields']['delete']['table'] = 'message';
  $handler->display->display_options['fields']['delete']['field'] = 'delete';
  $handler->display->display_options['fields']['view']['label'] = 'Operations';
  $handler->display->display_options['fields']['delete']['element_label_colon'] = FALSE;
}
