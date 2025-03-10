<?php

namespace Drupal\field_fetcher_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityFieldManagerInterface;

/**
 * Controller to fetch and display field definitions for the 'user' entity.
 */
class FieldFetcherController extends ControllerBase {

  /**
   * The entity field manager service.
   *
   * @var \Drupal\Core\Entity\EntityFieldManagerInterface
   */
  protected $entityFieldManager;

  /**
   * Constructor to inject the entity field manager service.
   *
   * @param \Drupal\Core\Entity\EntityFieldManagerInterface $entityFieldManager
   *   The entity field manager service.
   */
  public function __construct(EntityFieldManagerInterface $entityFieldManager) {
    // Assign the injected entity field manager service to the class property.
    $this->entityFieldManager = $entityFieldManager;
  }

  /**
   * Creates an instance of the controller using dependency injection.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The service container.
   *
   * @return static
   *   Returns an instance of FieldFetcherController.
   */
  public static function create(ContainerInterface $container) {
    // Return a new instance of the controller with dependencies injected.
    return new static(
      $container->get('entity_field.manager')
    );
  }

  /**
   * Retrieves and displays all field definitions for the 'user' entity.
   *
   * @return array
   *   A render array containing the markup to display field names and types.
   */
  public function getFieldInfo() {
    // Retrieve field definitions for the 'user' entity type.
    $field_definitions = $this->entityFieldManager->getFieldDefinitions('user', 'user');

    // If no field definitions are found, display a message indicating this.
    if (empty($field_definitions)) {
      return ['#markup' => $this->t('No fields found for the user entity.')];
    }

    // Start constructing the output with a heading and an unordered list.
    $output = '<h2>User Entity Fields</h2><ul>';

    // Loop through the field definitions and add each field's name and type to the list.
    foreach ($field_definitions as $field_name => $field_definition) {
      // Get the field type.
      $field_type = $field_definition->getType();
      // Add each field to the list.
      $output .= '<li><strong>' . $field_name . '</strong>: ' . $field_type . '</li>';
    }

    // Close the unordered list.
    $output .= '</ul>';

    // Return the render array with the markup and allowed HTML tags.
    return [
      '#type' => 'markup',
      '#markup' => $output,
      '#allowed_tags' => ['h2', 'ul', 'li', 'strong'],
    ];
  }
}
