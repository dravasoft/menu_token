<?php

namespace Drupal\menu_token\Form;

use Drupal\Core\Entity\ContentEntityType;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\webprofiler\Entity\EntityManagerWrapper;

/**
 * Class AvaliableEntitiesConfigurationForm.
 *
 * @package Drupal\menu_token\Form
 */
class AvaliableEntitiesConfigurationForm extends ConfigFormBase {

  /**
   * Drupal\webprofiler\Entity\EntityManagerWrapper definition.
   *
   * @var \Drupal\webprofiler\Entity\EntityManagerWrapper
   */
  protected $entityTypeManager;

  /**
   * {@inheritdoc}
   */
  public function __construct(

    ConfigFactoryInterface $config_factory,
      EntityManagerWrapper $entity_type_manager
    ) {

    parent::__construct($config_factory);

    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'), $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'menu_token.avaliableentitiesconfiguration',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'avaliable_entities_configuration_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $config = $this->config('menu_token.avaliableentitiesconfiguration');
    $form['available_entities'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Available entities'),
      '#description' => $this->t('Available entities'),
    ];
    $entity_type_definations = $this->entityTypeManager->getDefinitions();
    /* @var $definition EntityTypeInterface */
    foreach ($entity_type_definations as $definition) {

      if ($definition instanceof ContentEntityType) {

        if (!empty($config->getRawData()['available_entities'][$definition->id()])) {

          $form['available_entities']['#options'][$definition->id()] = $definition->id();

          // Definition that is marked for check is checked.
          $form['available_entities']['#default_value'][] = $definition->id();

        }
        else {

          $form['available_entities']['#options'][$definition->id()] = $definition->id();
        }
      }
    }


    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    // Store to configuration.
    $this->config('menu_token.avaliableentitiesconfiguration')
      ->set('available_entities', $form_state->getValue('available_entities'))
      ->save();
  }

}
