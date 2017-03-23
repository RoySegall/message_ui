<?php

/**
 * @file
 * Definition of Drupal\message_ui\Tests\MessageUiPermissions.
 */

namespace Drupal\Tests\message_ui\Functional;

use Drupal\Tests\message\Functional\MessageTestBase;
use Drupal\user\Entity\Role;
use Drupal\user\RoleInterface;
use Drupal\user\UserInterface;

/**
 * Testing the display of the preview.
 *
 * @group Message UI
 */
class MessageUiShowPreviewTest extends MessageTestBase {

  /**
   * The user account object.
   *
   * @var UserInterface
   */
  protected $account;

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['message', 'message_ui'];

  /**
   * The user role.
   *
   * @var integer
   */
  protected $rid;

  /**
   * Grant to the user a specific permission.
   *
   * @param string $operation
   *   The template of operation - create, update, delete or view.
   */
  protected function grantMessageUiPermission($operation) {
    user_role_grant_permissions($this->rid, array($operation . ' foo message'));
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    $this->account = $this->drupalCreateUser();

    // Load 'authenticated' user role.
    $this->rid = Role::load(RoleInterface::AUTHENTICATED_ID)->id();

    // Create Message template foo.
    $this->createMessageTemplate('foo', 'Dummy test', 'Example text.', array('Dummy message'));

    // Grant and check create permissions for a message.
    $this->grantMessageUiPermission('create');

    // Don't show the text of the message.
    $this->configSet('show_preview', TRUE);
  }

  /**
   * Set a config value.
   *
   * @param string $config
   *   The config name.
   * @param string $value
   *   The config value.
   * @param string $storage
   *   The storing of the configuration. Default to message.message.
   */
  protected function configSet($config, $value, $storage = 'message_ui.settings') {
    $this->container->get('config.factory')->getEditable($storage)->set($config, $value)->save();
  }

  /**
   * Testing the displaying of the preview.
   */
  public function testMessageUiPreviewDisplaying() {

    // User login.
    $this->drupalLogin($this->account);

    // Verify the user can't create the message.
    $this->drupalGet('/message/add/foo');

    // Make sure we can see the message text.
    $this->assertSession()->pageTextContains('Dummy message');

    // Don't show the message text.
    $this->configSet('show_preview', FALSE);
    drupal_static_reset();

    // Verify the user can't create the message.
    $this->drupalGet('/message/add/foo');

    // Make sure we can see the message text.
    $this->assertSession()->pageTextNotContains('Dummy message');
  }

}
