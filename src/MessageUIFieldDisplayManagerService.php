<?php

namespace Drupal\message_ui;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Class MessageUIFieldDisplayManagerService.
 *
 * @package Drupal\message_ui
 */
class MessageUIFieldDisplayManagerService implements MessageUIFieldDisplayManagerServiceInterface {

  /**
   * The entity storage manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   */
  function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public function SetFieldsDisplay($template) {
    /** @var \Drupal\Core\Entity\Display\EntityDisplayInterface $form_display */
    $form_display = $this->entityTypeManager->getStorage('entity_form_display')->load("message.{$template}.default");

    foreach (array_keys($form_display->get('hidden')) as $hidden) {
      $form_display->setComponent($hidden, ['field_name' => $hidden]);
      $form_display->save();
    }
  }

}
