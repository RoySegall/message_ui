<?php

/**
 * @file
 * Post update functions for Message UI.
 */

use Drupal\message\Entity\MessageTemplate;

/**
 * Set the templates 'enabled' flag.
 */
function message_ui_post_update_enable_templates() {
  // For existing sites we preserve the actual behavior, which is to expose in
  // UI all messages, regardless of their template. Site builder will have to
  // explicitly disable the flag for the message templates that should not have
  // UI exposure.
  foreach (MessageTemplate::loadMultiple() as $id => $template) {
    /** @var \Drupal\message\MessageTemplateInterface $template */
    $template->setThirdPartySetting('message_ui', 'enabled', TRUE)->save();
  }
}
