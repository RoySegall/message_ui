<?php

namespace Drupal\Tests\message_ui\Functional;
use Drupal\message_ui\MessagePermissions;

/**
 * Testing the message permission generator..
 *
 * @group Message UI
 */
class MessageUiPermissionsTest extends AbstractTestMessageUi {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['message_example', 'message_ui'];

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
  }

  /**
   * Testing the displaying of the preview.
   */
  public function testMessageUiPermissions() {
    $class = new MessagePermissions();
    $this->assertEquals(count($class->messageTemplatePermissions()) * 4, count($this->container->get('entity_type.manager')->getStorage('message_template')->loadMultiple()));
  }

}
