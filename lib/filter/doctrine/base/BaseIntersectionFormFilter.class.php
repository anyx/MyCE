<?php

/**
 * Intersection filter form base class.
 *
 * @package    crosswords
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseIntersectionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'first_word_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FirstWord'), 'add_empty' => true)),
      'first_word_position'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'second_word_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('SecondWord'), 'add_empty' => true)),
      'second_word_position' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'first_word_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('FirstWord'), 'column' => 'id')),
      'first_word_position'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'second_word_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('SecondWord'), 'column' => 'id')),
      'second_word_position' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('intersection_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Intersection';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'first_word_id'        => 'ForeignKey',
      'first_word_position'  => 'Number',
      'second_word_id'       => 'ForeignKey',
      'second_word_position' => 'Number',
    );
  }
}
