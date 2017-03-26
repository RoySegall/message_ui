<?php

/**
 * @file
 * Contains \Drupal\message_ui\Form\MessageDeleteForm.
 */

namespace Drupal\message_notify_ui\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\message_notify\MessageNotifier;
use Drupal\message_notify_ui\Plugin\MessageNotifyUiSenderSettingsFormInterface;
use Drupal\message_notify_ui\Plugin\MessageNotifyUiSenderSettingsFormManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Component\Datetime\TimeInterface;
use Drupal\message_notify\Plugin\Notifier\Manager;

/**
 * Provides a form for send a message entity.
 *
 * @ingroup message_notify_ui
 */
class MessageNotifyForm extends EntityForm {

  /**
   * The entity manager.
   *
   * @var \Drupal\Core\Entity\EntityManagerInterface
   */
  protected $entityManager;

  /**
   * The entity being used by this form.
   *
   * @var \Drupal\Core\Entity\ContentEntityInterface|\Drupal\Core\Entity\RevisionLogInterface
   */
  protected $entity;

  /**
   * The entity type bundle info service.
   *
   * @var \Drupal\Core\Entity\EntityTypeBundleInfoInterface
   */
  protected $entityTypeBundleInfo;

  /**
   * The time service.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $time;

  /**
   * The message notifier service.
   *
   * @var \Drupal\message_notify\MessageNotifier
   */
  protected $messageNotifier;

  /**
   * Message notifier manager service.
   *
   * @var \Drupal\message_notify\Plugin\Notifier\Manager
   */
  protected $messageNotifierManager;

  /**
   * Message notify UI sender settings form manager.
   *
   * @var \Drupal\message_notify_ui\Plugin\MessageNotifyUiSenderSettingsFormInterface
   */
  protected $messageNotifyUiSenderSettingsForm;

  /**
   * Constructs a ContentEntityForm object.
   *
   * @param \Drupal\Core\Entity\EntityManagerInterface $entity_manager
   *   The entity manager.
   * @param \Drupal\Core\Entity\EntityTypeBundleInfoInterface $entity_type_bundle_info
   *   The entity type bundle service.
   * @param \Drupal\Component\Datetime\TimeInterface $time
   *   The time service.
   * @param MessageNotifier $message_notifier
   *   The message notifier service.
   * @param \Drupal\message_notify\Plugin\Notifier\Manager $message_notify_manager
   *   Message notifier manager service.
   * @param \Drupal\message_notify_ui\Plugin\MessageNotifyUiSenderSettingsFormManager $message_notify_ui_setting_form_manager
   *   The message notify UI sender settings form manager.
   *
   */
  public function __construct(
    EntityManagerInterface $entity_manager,
    EntityTypeBundleInfoInterface $entity_type_bundle_info = NULL,
    TimeInterface $time = NULL,
    MessageNotifier $message_notifier,
    Manager $message_notify_manager,
    MessageNotifyUiSenderSettingsFormManager $message_notify_ui_setting_form_manager)
  {
    $this->entityManager = $entity_manager;

    $this->entityTypeBundleInfo = $entity_type_bundle_info ?: \Drupal::service('entity_type.bundle.info');
    $this->time = $time ?: \Drupal::service('datetime.time');
    $this->messageNotifier = $message_notifier;
    $this->messageNotifierManager = $message_notify_manager;
    $this->messageNotifyUiSenderSettingsForm = $message_notify_ui_setting_form_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.manager'),
      $container->get('entity_type.bundle.info'),
      $container->get('datetime.time'),
      $container->get('message_notify.sender'),
      $container->get('plugin.message_notify.notifier.manager'),
      $container->get('plugin.manager.message_notify_ui_sender_settings_form')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['actions'] = parent::buildForm($form, $form_state)['actions'];

    $senders = [];
    foreach ($this->messageNotifierManager->getDefinitions() as $definition) {
      $senders[$definition['id']] = $definition['title'];
    }

    $form['senders'] = [
      '#type' => 'radios',
      '#title' => $this->t('Select a notifier handler'),
      '#options' => $senders,
    ];

    dpm($this->messageNotifyUiSenderSettingsForm->getDefinitions());

    return $form;
  }
}
