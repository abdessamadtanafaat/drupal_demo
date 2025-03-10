<?php

namespace Drupal\access_result_test\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Routing\Access\AccessInterface;

/**
 * Custom access check.
 */
class AccessCheck implements AccessInterface {

  /**
   * Check access based on user roles.
   */
  public function access(AccountInterface $account) {
    // Grant access only if the user has 'admin' role.
    if ($account->hasRole('administrator')) {
      return AccessResult::allowed();
    }

    // Deny access to others.
    return AccessResult::forbidden();
  }
}
