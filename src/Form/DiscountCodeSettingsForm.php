<?php

namespace Drupal\discount_code\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Defines a form that configures module settings.
 */
class DiscountCodeSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'discount_code_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'discount_code.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, Request $request = NULL) {
    $config = $this->config('discount_code.settings');

    $form['help_header'] = [
      '#type' => 'html_tag',
      '#tag' => 'h2',
      '#value' => $this->t('Tokens:'),
    ];

    $form['help'] = [
      '#type' => 'html_tag',
      '#tag' => 'ul',
      'help_user_name' => [
        '#type' => 'html_tag',
        '#tag' => 'li',
        '#value' => $this->t('[current-user:name] - the name of the current user.'),
      ],
      'help_discount_code' => [
        '#type' => 'html_tag',
        '#tag' => 'li',
        '#value' => $this->t('[discount-code:code] - the discount code of the current user.'),
      ],
    ];

    $form['message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Message'),
      '#default_value' => $config->get('message'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    $this->config('discount_code.settings')
      ->set('message', $values['message'])
      ->save();
  }

}
