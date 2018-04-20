<?php

namespace Drupal\discount_code\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the discount_code entity edit forms.
 */
class DiscountCodeForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $status = parent::save($form, $form_state);

    /** @var \Drupal\discount_code\DiscountCodeInterface $entity */
    $entity = $this->entity;

    if ($status == SAVED_UPDATED) {
      drupal_set_message($this->t('The discount code @link has been updated.', [
        '@link' => $entity->toLink($entity->getCode())->toString(),
      ]));
    }
    else {
      drupal_set_message($this->t('The discount code @link has been added.', [
        '@link' => $entity->toLink($entity->getCode())->toString(),
      ]));
    }

    $form_state->setRedirectUrl($this->entity->toUrl('collection'));

    return $status;
  }

}
