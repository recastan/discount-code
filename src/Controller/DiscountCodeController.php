<?php

namespace Drupal\discount_code\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Provides route responses for the Discount Code module.
 */
class DiscountCodeController extends ControllerBase {

  /**
   * Returns a Discount Code page.
   */
  public function discountCode() {
    $uid = \Drupal::currentUser()->id();

    $discountCodeStorage = \Drupal::entityTypeManager()->getStorage('discount_code');
    $discountCodes = $discountCodeStorage->loadByProperties(['uid' => $uid]);
    $discountCode = !empty($discountCodes) ? array_values($discountCodes)[0] : NULL;

    $message = $this->config('discount_code.settings')->get('message');
    $message = \Drupal::token()->replace($message, [
      'discount-code' => $discountCode,
    ]);

    $element = [
      '#markup' => $message,
    ];

    return $element;
  }

}
