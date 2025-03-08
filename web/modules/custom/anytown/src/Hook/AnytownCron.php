<?php

declare(strict_types=1);

namespace Drupal\anytown\Hook;

use Drupal\Core\Hook\Attribute\Hook;

class AnytownCron {

  /**
   * Implements hook_cron().
   */
  #[Hook('cron')]
  public function cron() {
    // Get the current time.
    $current_time = new \DateTime();
    // Get the last time this was run.
    $last_run_timestamp = \Drupal::state()->get('anytown.last_cron_weekly_run', 0);
    $last_run = new \DateTime();
    if ($last_run_timestamp) {
      $last_run->setTimestamp($last_run_timestamp);
    }

    // If it's been more than 6 days since that last run, we're good, and if today
    // is Monday or later, we're good.
    $interval = $last_run->diff($current_time);

    // 1==1 is so that this will execute every time cron runs for demonstration
    // purposes.
    if (1 == 1 || $interval->days > 6 && $current_time->format('w') >= 1) {
      // Perform the weekly task.
      $this->clearVendorStatus();

      // Update the last run time.
      \Drupal::state()->set('anytown.last_cron_weekly_run', $current_time->getTimestamp());
    }
  }

  /**
   * Reset field_vendor_attending to FALSE for all vendor nodes.
   */
  public function clearVendorStatus() {
    $query = \Drupal::entityTypeManager()->getStorage('node')->getQuery()
      // Specifying an accessCheck of TRUE|FALSE is required.
      // Return all nodes, regardless of the users access. This is safe here
      // because we want cron (the system) to update them all.
      ->accessCheck(FALSE)
      // Filter by the 'vendor' bundle.
      ->condition('type', 'vendor')
      // Filter nodes where 'field_attending' is TRUE.
      ->condition('field_vendor_attending', TRUE);

    // Execute the query to get an array of node IDs that match the conditions.
    $node_ids = $query->execute();

    // Load the node entities.
    $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadMultiple($node_ids);

    // Now you can work with the $nodes array.
    /** @var \Drupal\node\NodeInterface $node */
    foreach ($nodes as $node) {
      $node->set('field_vendor_attending', FALSE);
      $node->save();
    }
  }

}
