<?php

namespace Drupal\discount_code;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Access controller for the discount_code entity.
 */
class DiscountCodeAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'view discount_code entity');

      case 'edit':
        return AccessResult::allowedIfHasPermission($account, 'edit discount_code entity');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete discount_code entity');
    }

    return AccessResult::allowed();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add discount_code entity');
  }

}
