<?php

namespace Drupal\message_notify_ui\Plugin\MessageNotifyUiSenderSettingsForm;

use Drupal\message_notify_ui\Plugin\MessageNotifyUiSenderSettingsFormBase;
use Drupal\message_notify_ui\Plugin\MessageNotifyUiSenderSettingsFormInterface;

/**
 * @MessageNotifyUiSenderSettingsForm(
 *  id = "message_notify_ui_sender_settings_form",
 *  label = @Translation("The plugin ID."),
 *  plugin = "email"
 * )
 */
class MessageNotifyUiSenderMailSettingsForm extends MessageNotifyUiSenderSettingsFormBase implements MessageNotifyUiSenderSettingsFormInterface {

  /**
   * {@inheritdoc}
   */
  public function form() {
  }

  /**
   * {@inheritdoc}
   */
  public function submit() {
  }

}
