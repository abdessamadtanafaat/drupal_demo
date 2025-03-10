<?php

namespace Drupal\access_result_test\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Returns a response for the custom route.
 */
class Controller extends ControllerBase {

  /**
   * Returns content for /custom-page.
   */

  public function accessPage(): array {
    return [
      '#markup' => $this->t('Welcome to the Test Access Page. Only for administrators !'),
    ];
  }


}
