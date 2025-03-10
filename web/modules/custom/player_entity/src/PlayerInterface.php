<?php

declare(strict_types=1);

namespace Drupal\player_entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a player entity type.
 */
interface PlayerInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
