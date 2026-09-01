<?php

namespace Drupal\ecommerce\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines the 'button_link_widget' field widget.
 *
 * @FieldWidget(
 *   id = "button_link_widget",
 *   label = @Translation("Button Link Form"),
 *   field_types = {
 *     "button_link"
 *   }
 * )
 */
class ButtonLinkWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Button Label'),
      '#default_value' => isset($items[$delta]->label) ? $items[$delta]->label : NULL,
      '#size' => 60,
      '#maxlength' => 255,
      '#placeholder' => $this->t('e.g., Login'),
    ];

    // Wrap elements into a proper fieldset container visually
    $element['#type'] = 'fieldset';

    return $element;
  }

}
