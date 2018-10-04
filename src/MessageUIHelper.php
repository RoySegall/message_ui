<?php

namespace Drupal\message_ui;

use Drupal\Core\Entity\Entity\EntityFormDisplay;

/**
 * Provide reusable methods.
 */
class MessageUIHelper {

  /**
   * Adds a new entity form display if it doesn't exist.
   *
   * @param string $template
   *   The message template ID.
   */
  public static function addEntityFormDisplay($template) {
    if (!EntityFormDisplay::load("message.{$template}.default")) {
      EntityFormDisplay::create([
        'targetEntityType' => 'message',
        'bundle' => $template,
        'mode' => 'default',
        'status' => TRUE,
      ])->save();
    }
  }

}
