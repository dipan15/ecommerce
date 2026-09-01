<?php

namespace Drupal\ecommerce\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Url;

/**
 * Defines the 'button_link_formatter' field formatter.
 *
 * @FieldFormatter(
 *   id = "button_link_formatter",
 *   label = @Translation("A link with a button style"),
 *   field_types = {
 *     "button_link"
 *   }
 * )
 */
class ButtonLinkFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];

    foreach ($items as $delta => $item) {

      try {
        // dump(str_contains($item->getFieldDefinition()->get('description'), 'Login'));
        # drush ev "\Drupal::configFactory()->getEditable('block_content.type.login_logout_buttons_block_type')->delete();"

        $link = Url::fromUri('http://localhost/drupal_10_4_3/registration');
        
        $element[$delta] = [
          '#type' => 'link',
          '#title' => !empty($item->label) ? $item->label : $item->link,
          '#url' => $link,
          '#options' => [
            'attributes' => [
              'class' => ['btn', 'btn-primary', 'button-link-field'],
            ],
          ],
        ];
      }
      catch (\InvalidArgumentException $e) {
        // Fallback option if user supplied an invalid URI pattern
        $element[$delta] = [
          '#markup' => $this->t('Invalid URL configuration.'),
        ];
      }
    }

    return $element;
  }

}
