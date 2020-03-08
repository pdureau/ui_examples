<?php

namespace Drupal\ui_examples\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\ui_examples\ExamplePluginManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ExamplesLibraryController.
 *
 * @package Drupal\ui_examples\Controller
 */
class ExamplesLibraryController extends ControllerBase {

  /**
   * Examples manager service.
   *
   * @var \Drupal\ui_examples\ExamplePluginManagerInterface
   */
  protected $examplesManager;

  /**
   * {@inheritdoc}
   */
  final public function __construct(ExamplePluginManagerInterface $examples_manager) {
    $this->examplesManager = $examples_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('plugin.manager.ui_examples'));
  }

  /**
   * Render examples library page.
   *
   * @return array
   *   Examples overview page render array.
   */
  public function overview() {
    return [
      '#theme' => 'ui_examples_overview_page',
      '#examples' => $this->examplesManager->getDefinitions(),
    ];
  }

  /**
   * Render one example page.
   *
   * @return array
   *   Style page render array.
   */
  public function single($name) {
    $example = $this->examplesManager->getDefinition($name);
    return $example['render'];
  }

}
