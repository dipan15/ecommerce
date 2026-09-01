<?php

namespace Drupal\ecommerce\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\Field\Attribute\FieldType;

/**
 * Defines the 'button_link' field type.
 */
#[FieldType(
  id: "button_link",
  label: new TranslatableMarkup("Button Link"),
  description: new TranslatableMarkup("Stores a link with a button style."),
  default_widget: "button_link_widget",
  default_formatter: "button_link_formatter"
)]
class ButtonLinkItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   * Defines the schema for your database table columns.
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'label' => [
          'type' => 'varchar',
          'length' => 255,
          'not null' => FALSE,
        ]
      ],
    ];
  }

  /**
   * {@inheritdoc}
   * Informs Drupal about the internal properties of the data types.
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['label'] = DataDefinition::create('string')
      ->setLabel(t('Button Label'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   * Determines if the field is not empty before saving.
   */
  public function isEmpty() {
    $label = $this->get('label')->getValue();
    return ($label === NULL || $label === '');
  }

}
