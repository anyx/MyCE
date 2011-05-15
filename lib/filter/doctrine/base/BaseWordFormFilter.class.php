<?php

/**
 * Word filter form base class.
 *
 * @package    crosswords
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseWordFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'word'         => new sfWidgetFormFilterInput(),
      'definition'   => new sfWidgetFormFilterInput(),
      'crossword_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Crossword'), 'add_empty' => true)),
      'horisontal'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'x'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'y'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'word'         => new sfValidatorPass(array('required' => false)),
      'definition'   => new sfValidatorPass(array('required' => false)),
      'crossword_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Crossword'), 'column' => 'id')),
      'horisontal'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'x'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'y'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('word_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Word';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'word'         => 'Text',
      'definition'   => 'Text',
      'crossword_id' => 'ForeignKey',
      'horisontal'   => 'Boolean',
      'x'            => 'Number',
      'y'            => 'Number',
      'created_at'   => 'Date',
      'updated_at'   => 'Date',
    );
  }
}
