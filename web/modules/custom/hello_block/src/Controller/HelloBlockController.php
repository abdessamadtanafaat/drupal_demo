<?php

namespace Drupal\hello_block\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Provides a Hello World controller.
 */
class HelloBlockController extends ControllerBase {

  /**
   * Returns a Hello World message.
   *
   * @return array<string, string>
   *   A render array with a string key ('#markup') and a string value.
   */
  public function content(): array {
    return [
      '#markup' => $this->t('Hello World from my custom block module!'),
    ];
  }

}
