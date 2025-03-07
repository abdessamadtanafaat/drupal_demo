<?php

namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Provides a Hello World controller.
 */
class HelloWorldController extends ControllerBase {

  /**
   * Returns a Hello World message.
   *
   * @return array<string, string>
   *   A render array with a string key ('#markup') and a string value.
   */
  public function message(): array {
    return [
      '#markup' => $this->t('Hello World from my first custom module!'),
    ];
  }

}
