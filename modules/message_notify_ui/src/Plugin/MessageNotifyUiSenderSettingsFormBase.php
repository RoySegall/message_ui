<?php

namespace Drupal\message_notify_ui\Plugin;

use Drupal\Component\Plugin\PluginBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Base class for Message notify ui sender settings form plugins.
 */
abstract class MessageNotifyUiSenderSettingsFormBase extends PluginBase implements MessageNotifyUiSenderSettingsFormInterface {

  /**
   * The form settings.
   *
   * @var array
   */
  protected $form;

  /**
   * The form state interface.
   *
   * @var FormStateInterface
   */
  protected $formState;

  /**
   * Setter for the form variable.
   *
   * @param array $form
   *   The form API.
   *
   * @return $this
   */
  public function setForm(array $form) {
    $this->form = $form;

    return $this;
  }

  /**
   * Get the form API element.
   *
   * @return array
   *   The form API variable.
   */
  public function getForm() {
    return $this->form;
  }

  /**
   * Return the form state object.
   *
   * @return FormStateInterface
   *   The form state object.
   */
  public function getFormState() {
    return $this->formState;
  }

  /**
   * Set the form state.
   *
   * @param FormStateInterface $formState
   *   The form state object.
   *
   * @return $this
   */
  public function setFormState($formState) {
    $this->formState = $formState;
    return $this;
  }

}
