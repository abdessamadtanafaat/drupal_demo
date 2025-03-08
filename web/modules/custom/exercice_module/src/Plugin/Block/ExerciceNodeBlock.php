<?php
namespace Drupal\exercice_module\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;

/**
 * Provides a block that displays the selected node's title.
 *
 * @Block(
 *   id = "exercie_node_block",
 *   admin_label = @Translation("Exercice Block")
 * )
 */
class ExerciceNodeBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

//    $current_route = \Drupal::routeMatch()->getRouteName();
//    \Drupal::logger('exercice_module')->notice('Current route: ' . $current_route);
//
//    if ($current_route !== 'exercice_custom_module.form') {
//      return [];
//    }


    $selected_nid = \Drupal::service('tempstore.private')->get('exercice_module')->get('selected_node');

    if ($selected_nid) {
      $node = Node::load($selected_nid);
      if ($node) {
        return [
          '#theme' => 'exercice_node_list',
          '#selected_title' => $node->getTitle(),
          '#node_list' => $this->getOtherNodes($node),
        ];
      }
    }
    return ['#markup' => $this->t('No node selected.')];
  }

  /**
   * Get a list of nodes of the same content type, excluding the current one.
   */
  protected function getOtherNodes(Node $node) {
    $query = \Drupal::entityQuery('node')
      ->condition('type', $node->bundle())
      ->condition('nid', $node->id(), '<>')
      ->accessCheck(TRUE)
      ->execute();

    return Node::loadMultiple($query);
  }
}

