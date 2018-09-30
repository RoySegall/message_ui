<?php

namespace Drupal\message_ui\ParamConverter;

use Drupal\Core\ParamConverter\EntityConverter;

/**
 * Provides a param converter for {message_template}.
 */
class MessageUiConverter extends EntityConverter {

  /**
   * {@inheritdoc}
   */
  public function convert($value, $definition, $name, array $defaults) {
    if ($entity = parent::convert($value, $definition, $name, $defaults)) {
      // Allow creating messages via UI only for templates with UI enabled.
      if ($name === 'message_template' && $defaults['_route'] === 'message_ui.add' && !$entity->getThirdPartySetting('message_ui', 'enabled', FALSE)) {
        return NULL;
      }
      // Allow accessing messages via UI only for templates with UI enabled.
      $routes = ['entity.message.canonical', 'entity.message.edit_form', 'entity.message.delete_form'];
      if ($name === 'message' && in_array($defaults['_route'], $routes) && !$entity->template->entity->getThirdPartySetting('message_ui', 'enabled', FALSE)) {
        return NULL;
      }
    }
    return $entity;
  }

}
