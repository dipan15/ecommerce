<?php

namespace Drupal\ecommerce\Plugin\Field\FieldType;

use Drupal\image\Plugin\Field\FieldType\ImageItem;

// use Drupal\Core\Field\FieldItemBase;
// use Drupal\Core\Field\FieldStorageDefinitionInterface;
// use Drupal\Core\TypedData\DataDefinition;

/**
 * @FieldType(
 *   id = "custom_image_field",
 *   label = @Translation("Custom Image Field"),
 *   description = @Translation("Stores image and applies custom style."),
 *   category = @Translation("Reference"),
 *   default_widget = "image_image",
 *   default_formatter = "custom_image_field_formatter"
 * )
 */
class CustomImageItem extends ImageItem {}


// /**
//  * @FieldType(
//  *   id = "custom_image_field",
//  *   label = @Translation("Custom Image Field"),
//  *   description = @Translation("Stores a cropped image."),
//  *   default_widget = "custom_image_field_widget",
//  *   default_formatter = "custom_image_field_formatter"
//  * )
// */

// class CustomImageItem extends FieldItemBase {

//   public static function schema(FieldStorageDefinitionInterface $field_definition) {
//     return array(
//       'columns' => array(
//         'alt' => array('type' => 'varchar', 'length' => 255, 'not null' => FALSE),
//         'uri' => array('type' => 'varchar', 'length' => 255, 'not null' => FALSE),
//         ),
//     );
//   }

//   public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
//     $properties['alt'] = DataDefinition::create('string')->setLabel(t('Alternative Text'));
//     $properties['uri'] = DataDefinition::create('string')->setLabel(t('Image URI'));
//     return $properties;
//   }

//   public function isEmpty() {
//     $alt = $this->get('alt')->getValue();
//     $uri = $this->get('uri')->getValue();
//     return $alt === NULL || $alt === '' && ($uri === NULL || $uri === '');
//   }
// }
