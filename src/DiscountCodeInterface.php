<?php

namespace Drupal\discount_code;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\UserInterface;

/**
 * Provides an interface defining a DiscountCode entity.
 */
interface DiscountCodeInterface extends ContentEntityInterface {

  /**
   * Sets the user entity.
   *
   * @return \Drupal\discount_code\DiscountCodeInterface
   *   The discount code entity.
   */
  public function setUser(UserInterface $user);

  /**
   * Returns the user entity.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity.
   */
  public function getUser();

  /**
   * Returns the discount code.
   *
   * @return string
   *   The discount code.
   */
  public function getCode();

}
