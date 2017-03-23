<?php

namespace Drupal\message_ui\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\message\MessageInterface;
use Drupal\message\MessageTemplateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManager;

/**
 * Class MessageMultipleDeleteForm.
 *
 * @package Drupal\message_ui\Form
 */
class MessageMultipleDeleteForm extends FormBase {

  /**
   * Drupal\Core\Entity\EntityTypeManager definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * Constructor.
   *
   * @param EntityTypeManager $entity_type_manager
   *   The entity type manager service.
   */
  public function __construct(EntityTypeManager $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'message_multiple_delete_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /** @var MessageTemplateInterface $templates */
    $templates = $this->entityTypeManager->getStorage('message_template')->loadMultiple();
    $options = [];
    foreach ($templates as $template) {
      $options[$template->id()] = $template->label();
    }

    $form['message_templates'] = [
      '#type' => 'select',
      '#title' => $this->t('Message types'),
      '#description' => $this->t('Select which message templates you to delete at once'),
      '#options' => $options,
      '#size' => 5,
      '#multiple' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
    * {@inheritdoc}
    */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $templates = $form_state->getValue('message_templates');
    $messages = $this->entityTypeManager->getStorage('message')->getQuery()
      ->condition('template', $templates, 'IN')
      ->execute();

    $chunks = array_chunk($messages, 250);
    $operations = array();
    foreach ($chunks as $chunk) {
      $operations[] = array(
        '\Drupal\message_ui\Form\MessageMultipleDeleteForm::deleteMessages',
        array($this->entityTypeManager->getStorage('message')->loadMultiple($chunk))
      );
    }

    // Set the batch.
    $batch = array(
      'operations' => $operations,
      'title' => t('Updating the messages arguments.'),
      'init_message' => t('Start process messages.'),
      'progress_message' => t('Processed @current out of @total.'),
      'error_message' => t('Example Batch has encountered an error.'),
    );
    batch_set($batch);
    batch_process('admin/content/messages');
  }

  /**
   * Delete multiple messages.
   *
   * @param MessageInterface[] $messages
   *   The message objects.
   */
  static public function deleteMessages($messages) {
    \Drupal::entityTypeManager()->getStorage('message')->delete($messages);
  }

}
