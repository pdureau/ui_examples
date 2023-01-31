<?php

declare(strict_types = 1);

namespace Drupal\ui_examples\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller to display the examples library.
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
  public static function create(ContainerInterface $container): self {
    $instance = parent::create($container);
    $instance->examplesManager = $container->get('plugin.manager.ui_examples');
    return $instance;
  }

  /**
   * Render examples library page.
   *
   * @return array
   *   Examples overview page render array.
   */
  public function overview(): array {
    return [
      '#theme' => 'ui_examples_overview_page',
      '#examples' => $this->examplesManager->getDefinitions(),
    ];
  }

  /**
   * Render one example page.
   *
   * @param string $name
   *   The ID of the example plugin.
   *
   * @return array
   *   Style page render array.
   */
  public function single(string $name): array {
    /** @var \Drupal\ui_examples\Definition\ExampleDefinition $example */
    $example = $this->examplesManager->getDefinition($name);
    return $example->getRender();
  }

  /**
   * Render one example title.
   *
   * @param string $name
   *   The ID of the example plugin.
   *
   * @return \Drupal\Core\StringTranslation\TranslatableMarkup|string
   *   Example title.
   */
  public function title(string $name): TranslatableMarkup|string {
    /** @var \Drupal\ui_examples\Definition\ExampleDefinition $example */
    $example = $this->examplesManager->getDefinition($name);
    return $example->getLabel();
  }

}
