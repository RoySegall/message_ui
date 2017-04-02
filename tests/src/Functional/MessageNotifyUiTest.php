<?php

/**
 * @file
 * Definition of Drupal\message_ui\Tests\MessageUiPermissions.
 */

namespace Drupal\Tests\message_ui\Functional;

use Drupal\user\Entity\Role;
use Drupal\user\RoleInterface;

/**
 * Testing the message notify button.
 *
 * @group Message UI
 */
class MessageNotifyUiTest extends AbstractTestMessageUi {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['message', 'message_ui', 'message_notify_ui', 'views'];

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    $this->account = $this->drupalCreateUser(array(
      'send message through the ui',
      'overview messages',
    ));

    // Load 'authenticated' user role.
    $this->rid = Role::load(RoleInterface::AUTHENTICATED_ID)->id();

    // Create Message template foo.
    $this->createMessageTemplate('foo', 'Dummy test', 'Example text.', array('Dummy message'));
  }

  /**
   * Testing the displaying of the preview.
   */
  public function testMessageUiPreviewDisplaying() {

    // User login.
    $this->drupalLogin($this->account);

    // Create a message.
    $message = $this->container->get('entity_type.manager')->getStorage('message')->create([
      'template' => 'foo',
    ]);
    $message->save();

    // Check the contextual link.
    $this->drupalGet('admin/content/messages');
    if (!$this->getSession()->getPage()->find('xpath', "//td[contains(@class, 'views-field-message-ui-contextual-links')]//li//a[@class='notify']")) {
      $this->fail('The notify contextual link was not found on the page');
    }

    // Go to the page of notify page.
    $edit = [
      'use_custom' => TRUE,
      'email' => 'foo@gmail.com',
    ];
    $this->drupalPostForm('message/' . $message->id() . '/notify', $edit, t('Notify'));
    $this->assertSession()->pageTextContains('The email sent successfully.');
  }

}
