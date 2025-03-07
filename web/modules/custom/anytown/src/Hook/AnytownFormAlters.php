<?php

declare(strict_types=1);

namespace Drupal\anytown\Hook;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Hook\Attribute\Hook;

class AnytownFormAlters {

  /**
   * Implements hook_form_FORM_ID_alter() for the registration form.
   */
  #[Hook('form_user_register_form_alter')]
  public function formUserRegisterFormAlter(&$form, FormStateInterface $form_state) : void {
    // Add our custom validation handler.
    $form['#validate'][] = 'anytown_user_register_validate';

    $form['terms_of_use'] = [
      '#type' => 'fieldset',
      '#title' => t('Anytown Terms and Conditions of Use'),
      '#weight' => 10,
      // Admin users can skip the terms of use, this will let them create accounts
      // for other people without seeing these fields.
      '#access' => !\Drupal::currentUser()->hasPermission('administer users')
    ];

    $form['terms_of_use']['terms_of_use_data'] = [
      '#type' => 'markup',
      '#markup' => '<p>By checking the box below you agree to our terms of use. Whatever that might be. ¯\_(ツ)_/¯</p>',
      '#allowed_tags' => ['iframe'],
    ];

    $form['terms_of_use']['terms_of_use_checkbox'] = [
      '#type' => 'checkbox',
      '#title' => t('I agree with the terms above'),
      '#required' => TRUE,
    ];
  }

}
