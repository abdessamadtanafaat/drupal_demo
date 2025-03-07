<?php

declare(strict_types=1);

namespace Drupal\anytown\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a hello world block.
 *
 * @Block(
 *   id = "anytown_hello_world",
 *   admin_label = @Translation("Hello World"),
 *   category = @Translation("Custom"),
 * )
 */
class HelloWorldBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  private $currentUser;

  /**
   * Construct a HelloWorldBlock.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   The current user service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountProxyInterface $current_user) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->currentUser = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    if ($this->currentUser->isAuthenticated()) {
      $build['content'] = [
        '#markup' => $this->t('Hello, @name! Welcome back.', ['@name' => $this->currentUser->getDisplayName()]),
      ];
    }
    else {
      $build['content'] = [
        '#markup' => $this->t('Hello world!'),
      ];
    }

    // This block contains content that is different depending on the user so
    // we don't want it to get cached.
    $build['content']['#cache'] = [
      'max-age' => 0,
    ];

    return $build;
  }

}
