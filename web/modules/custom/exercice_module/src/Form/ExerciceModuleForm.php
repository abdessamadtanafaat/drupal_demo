<?php

namespace Drupal\exercice_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;

/**
 * Provides a form to select a node and save it.
 */
class ExerciceModuleForm extends FormBase {

  /**
   * {@inheritdoc}
   * Returns the unique ID of the form.
   */
  public function getFormId() {
    return 'custom_node_form';
  }

  /**
   * {@inheritdoc}
   * Builds the form with a select field to choose a node and a submit button.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    // Fetch available nodes to display in the select dropdown.
    $options = $this->getNodeOptions();

    // Dropdown field to select a node.
    $form['selected_node'] = [
      '#type' => 'select',
      '#title' => $this->t('Select a Node'),
      '#options' => $options,
      '#required' => TRUE,
    ];

    // Submit button to save the selection.
    $form['actions'] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Save Selection'),
      ],
    ];

    return $form;
  }

  /**
   * Fetches a list of available nodes and returns them as an array.
   *
   * @return array
   *   An array of node IDs as keys and their titles as values.
   */
  private function getNodeOptions() {
    $options = [];

    // Query all nodes ensuring access checks are respected.
    $query = \Drupal::entityQuery('node')
      ->accessCheck(TRUE)
      ->execute();

    // Load all nodes from the query result.
    $nodes = Node::loadMultiple($query);

    // Populate the dropdown options with node IDs as keys and titles as values.
    foreach ($nodes as $node) {
      $options[$node->id()] = $node->getTitle();
    }

    return $options;
  }

  /**
   * {@inheritdoc}
   * Handles form submission by storing the selected node ID and redirecting.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Get the selected node ID from the form submission.
    $selected_nid = $form_state->getValue('selected_node');

    // state() stores data globally for all users, which is not recommended for per-user data.
    \Drupal::service('tempstore.private')->get('exercice_module')->set('selected_node', $selected_nid);

  }
}
