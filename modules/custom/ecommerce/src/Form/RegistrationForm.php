<?php

namespace Drupal\ecommerce\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Entity\User;

class RegistrationForm extends FormBase {

  public function getFormId() {
    return 'ecommerce_registration_form'; // Must be a unique ID
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['#attributes']['class'][] = 'ecommerce-registration-form-custom';
    // Add a custom class for styling

    $form['user_type'] = [
      '#type' => 'select',
      '#title' => $this->t('Choose user type'),
      '#options' => [
          'Buyer' => $this->t('Buyer'),
          'Seller' => $this->t('Seller')
      ],
      '#default_value' => 'Buyer',
      '#description' => $this->t('Please select one of the available choices.'),
      '#attributes' => [
        'class' => ['form-control'],
      ],
      '#wrapper_attributes' => [
        'class' => ['mb-3']
      ]
    ];

    $form['username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Username'),
      '#required' => TRUE,
      '#attributes' => [
        'class' => ['form-control'],
      ],
      '#wrapper_attributes' => [
        'class' => ['mb-3']
      ]
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email Address'),
      '#required' => FALSE,
      '#attributes' => [
        'class' => ['form-control'],
      ],
      '#wrapper_attributes' => [
        'class' => ['mb-3']
      ]
    ];

    $form['password'] = [
      '#type' => 'password',
      '#title' => $this->t('Password'),
      '#required' => TRUE,
      '#attributes' => [
        'class' => ['form-control'],
      ],
      '#wrapper_attributes' => [
        'class' => ['mb-3']
      ]
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Register'),
      '#attributes' => [
        'class' => ['btn', 'btn-primary']
      ]
    ];

    // 2. Attach the module library to this specific form
    $form['#attached']['library'][] = 'ecommerce_theme/ecommerce-theme-library';
    $form['#attached']['library'][] = 'ecommerce_theme/bootstrap-cdn';

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $email = $form_state->getValue('email');
    $username = $form_state->getValue('username');

    // Prevent duplicate emails.
    if (user_load_by_mail($email)) {
      $form_state->setErrorByName('email', $this->t('This email address is already registered.'));
    }

    // Prevent duplicate usernames.
    if (user_load_by_name($username)) {
      $form_state->setErrorByName('username', $this->t('This username is already taken.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // 1. Define the user entity values.
    $user_data = [
      'name' => $form_state->getValue('username'),
      'mail' => $form_state->getValue('email'),
      'pass' => $form_state->getValue('password'),
      'status' => 1, // 1 = Active, 0 = Blocked
      'roles' => ['authenticated'] // Add specific role machine names here if needed (e.g., ['authenticated'])
    ];

    if ($form_state->getValue('user_type') === 'Seller') {
      $user_data['roles'][] = 'seller';
    } elseif ($form_state->getValue('user_type') === 'Buyer') {
      $user_data['roles'][] = 'buyer';
    }

    // 2. Create and save the user entity.
    $user = User::create($user_data);
    $user->save();

    // 3. Display success message.
    $this->messenger()->addStatus($this->t('User account for @name with @role role has been successfully created.', [
      '@name' => $form_state->getValue('username'),
      '@role' => $form_state->getValue('user_type'),
    ]));

    // 4. Redirect to the homepage.
    $form_state->setRedirect('entity.node.canonical', ['node' => 3]);
  }
}
