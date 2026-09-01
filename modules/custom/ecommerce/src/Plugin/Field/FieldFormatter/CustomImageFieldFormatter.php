<?php

// src/Plugin/Field/FieldFormatter/CustomImageFieldFormatter.php

namespace Drupal\ecommerce\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\image\Plugin\Field\FieldFormatter\ImageFormatter;

/**
 * @FieldFormatter(
 *   id = "custom_image_field_formatter",
 *   label = @Translation("Custom Image Style Formatter"),
 *   field_types = {"custom_image_field"}
 * )
 */
class CustomImageFieldFormatter extends ImageFormatter {
  public function viewElements(FieldItemListInterface $items, $langcode) {
    // die('Method called');
    // print_r("Method Fired!");
    $elements = [];
    foreach ($items as $delta => $item) {
      $file = $item->entity;
      if (isset($file)) {
        $file_uri = $file->getFileUri() ?? NULL;
      } else {
        $file_uri = NULL;
      }
      // dump($item->alt);

      // Hardcode or dynamically set your custom image style ID here
      $elements[$delta] = [
        '#theme' => 'image_style',
        '#style_name' => 'product_style',   // Machine name of the image style
        '#uri' => $file_uri,           // Path to the original image
        '#alt' => $item->alt,
        '#width' => $item->width,
        '#height' => $item->height,
      ];
      // '#style_name' => 'thumbnail';
      // $elements[$delta] = [
      //   '#markup' => \Drupal::service('renderer')->render($source)];
    }
    return $elements;
  }
}


// use Drupal\Core\Field\FieldItemListInterface;
// use Drupal\Core\Field\FormatterBase;

// /**
//  * @FieldFormatter(
//  *   id = "custom_image_field_formatter",
//  *   label = @Translation("Custom Image Field Formatter"),
//  *   field_types = { "custom_image_field" }
//  * )
//  */
// class CustomImageFieldFormatter extends FormatterBase {
//   public function viewElements(FieldItemListInterface $items, $langcode) {
//     $elements = [];
//     foreach ($items as $delta => $item) {
//         $source = [
//             '#theme' => 'image_style',
//             '#style_name' => 'thumbnail',   // Machine name of the image style
//             '#uri' => $item->uri,           // Path to the original image
//             '#alt' => $item->alt,
//         ];
//       $elements[$delta] = [
//         '#type' => 'markup',
//         '#markup' => \Drupal::service('renderer')->render($source)];
//     }
//     return $elements;
//   }
// }
