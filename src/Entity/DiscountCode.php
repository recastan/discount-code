<?php

namespace Drupal\discount_code\Entity;

use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\discount_code\DiscountCodeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the DiscountCode entity.
 *
 * @ContentEntityType(
 *   id = "discount_code",
 *   label = @Translation("Discount Code"),
 *   base_table = "discount_code",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *     "uid" = "uid",
 *     "code" = "code",
 *   },
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\discount_code\Entity\Controller\DiscountCodeListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\discount_code\Form\DiscountCodeForm",
 *       "edit" = "Drupal\discount_code\Form\DiscountCodeForm",
 *       "delete" = "Drupal\discount_code\Form\DiscountCodeDeleteForm",
 *     },
 *     "access" = "Drupal\discount_code\DiscountCodeAccessControlHandler",
 *   },
 *   links = {
 *     "canonical" = "/discount_code/{discount_code}",
 *     "collection" = "/discount_code/list",
 *     "edit-form" = "/discount_code/{discount_code}/edit",
 *     "delete-form" = "/discount_code/{discount_code}/delete",
 *   },
 * )
 */
class DiscountCode extends ContentEntityBase implements DiscountCodeInterface {

  /**
   * {@inheritdoc}
   */
  public function getUser() {
    return $this->get('uid')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function setUser(UserInterface $user) {
    $this->set('uid', $user->id());

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCode() {
    return $this->get('code')->getString();
  }

  /**
   * Generates the new discount code.
   *
   * @return string
   *   Discount code.
   */
  protected static function generateCode() {
    $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $code = '';

    for ($i = 0; $i < 10; ++$i) {
      $code .= $chars[rand(0, strlen($chars) - 1)];
    }

    return $code;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    // Standard field, used as unique if primary index.
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the DiscountCode entity.'))
      ->setReadOnly(TRUE);

    // Standard field, unique outside of the scope of the current project.
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the DiscountCode entity.'))
      ->setReadOnly(TRUE);

    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('User ID'))
      ->setDescription(t('The ID of the associated user.'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => 60,
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'entity_reference_label',
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['code'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Code'))
      ->setDescription(t('The discount code of the DiscountCode entity.'))
      ->setSettings([
        'default_value' => '',
        'max_length' => 10,
        'text_processing' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
      ])
      ->setDisplayOptions('view',[
        'label' => 'above',
        'type' => 'string',
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);

    do {
      $code = static::generateCode();

      // Repeats code generation if generated is not unique.
      $existingCodes = $storage_controller->loadByProperties(['code' => $code]);
      $isUnique = empty($existingCodes);
    } while (!$isUnique);

    $values += [
      'code' => $code,
    ];
  }

}
