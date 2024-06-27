<?php

declare(strict_types=1);

namespace Drupal\Tests\ui_examples\Functional;

use Drupal\Core\Url;
use Drupal\Tests\BrowserTestBase;
use Drupal\user\UserInterface;

/**
 * Provides common methods for UI examples functional tests.
 *
 * @group ui_examples
 */
class UiExamplesTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'ui_examples',
    'ui_examples_test',
  ];

  /**
   * The admin user.
   *
   * @var \Drupal\user\UserInterface
   */
  protected UserInterface $adminUser;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    $user = $this->drupalCreateUser($this->getAdminUserPermissions());
    if (!($user instanceof UserInterface)) {
      $this->fail('Impossible to create the tests user.');
    }

    $this->adminUser = $user;
  }

  /**
   * The list of admin user permissions.
   *
   * @return array
   *   The list of admin user permissions.
   */
  protected function getAdminUserPermissions(): array {
    return [
      'access_ui_examples_library',
    ];
  }

  /**
   * Test display.
   */
  public function testDisplay(): void {
    $this->drupalLogin($this->adminUser);
    $this->drupalGet(Url::fromRoute('ui_examples.overview'));

    // Title and description.
    $this->assertSession()->linkExists('Test');
    $this->assertSession()->pageTextContains('Test plugin.');

    // External links.
    $this->assertSession()->linkExists('External documentation');
    $this->assertSession()->linkByHrefExists('https://test.com');
    $this->assertSession()->linkExists('Example');
    $this->assertSession()->linkByHrefExists('https://example.com');

    $this->drupalGet(Url::fromRoute('ui_examples.single', ['name' => 'test']));
    // Defined render array.
    $this->assertSession()->elementExists('css', 'h1:contains("Test")');
  }

}
