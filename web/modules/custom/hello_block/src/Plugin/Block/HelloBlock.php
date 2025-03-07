<?php

namespace Drupal\hello_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Hello World' custom block.
 *
 * @Block(
 *   id = "hello_block",
 *   admin_label = @Translation("Hello Block"),
 * )
 */
class HelloBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#markup' => $this->t('Hello World from my custom block!'),
    ];
  }

}
