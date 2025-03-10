<?php

declare(strict_types=1);

namespace Drupal\example_demo_field_formatter\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Attribute\FieldFormatter;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Plugin implementation of the 'Heading h2' formatter.
 */
#[FieldFormatter(
  id: 'example_field_formatter',
  label: new TranslatableMarkup('Heading h2'),
  field_types: ['string'],
)]
final class ExampleFieldFormatterFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $element = [];
    foreach ($items as $delta => $item) {
      $element[$delta] = [
        '#type' => 'markup',
        '#markup'=>'<h2> . $item->value . </h2>'
      ];
    }
    return $element;
  }

}
