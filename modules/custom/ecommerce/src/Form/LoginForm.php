<?php

namespace Drupal\ecommerce\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Entity\User;

class LoginForm extends FormBase {

  public function getFormId() {
    return 'ecommerce_login_form'; // Must be a unique ID
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['#attributes']['class'][] = 'ecommerce-login-form-custom';
    // Add a custom class for styling

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
      '#value' => $this->t('Log In'),
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
    $username = $form_state->getValue('username');
    $password = $form_state->getValue('password');

    // Authenticate the user credentials using core user authentication service
    $uid = \Drupal::service('user.auth')->authenticate($username, $password);

    if (!$uid) {
      $form_state->setErrorByName('username', $this->t('Invalid username or password.'));
    }
    else {
      // Store UID in form state to carry it over to the submit handler
      $form_state->set('authenticated_uid', $uid);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $uid = $form_state->get('authenticated_uid');
    
    if ($uid) {
      $user = User::load($uid);
      
      // Finalize the login session for the user in Drupal
      user_login_finalize($user); 
      
      $this->messenger()->addStatus($this->t('Welcome back, @name!', ['@name' => $user->getDisplayName()]));
      
      // Redirect to the home page
      $form_state->setRedirect('entity.node.canonical', ['node' => 3]);
    }
  }
}
