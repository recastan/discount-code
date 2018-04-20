<?php

namespace Drupal\discount_code\Entity\Controller;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Provides a list controller for discount_code entity.
 */
class DiscountCodeListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('ID');
    $header['user'] = $this->t('User');
    $header['code'] = $this->t('Code');

    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\discount_code\Entity\DiscountCode */
    $row['id'] = $entity->id();
    $row['user'] = $entity->getUser()->toLink();
    $row['code'] = $entity->toLink($entity->getCode());

    return $row + parent::buildRow($entity);
  }

}
