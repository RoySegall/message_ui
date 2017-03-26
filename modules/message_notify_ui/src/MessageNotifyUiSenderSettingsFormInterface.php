<?php

namespace Drupal\message_notify_ui\Plugin;

use Drupal\Component\Plugin\PluginInspectionInterface;

/**
 * Defines an interface for Message notify ui sender settings form plugins.
 */
interface MessageNotifyUiSenderSettingsFormInterface extends PluginInspectionInterface {

  /**
   * The form settings for the plugin.
   *
   * @return array
   *   The form with the setting of the plugin.
   */
  public function form();

  /**
   * Implementing logic for sender which relate to the plugin.
   *
   * Each plugin of this type provide UI for a notifier plugin. After the form
   * is submitted this function will be invoked.
   */
  public function submit();

}
