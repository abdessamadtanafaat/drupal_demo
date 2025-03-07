<?php

declare(strict_types=1);

namespace Drupal\anytown\Hook;

use Drupal\Core\Hook\Attribute\Hook;

class AnytownEntityHooks {

  /**
   * Implements hook_entity_type_alter().
   */
  #[Hook('entity_type_alter')]
  public function entityTypeAlter(array &$entity_types) : void {
    // Add validation constraint to user entities.
    $entity_types['user']->addConstraint('AnytownUserNameConstraint');
  }

}
