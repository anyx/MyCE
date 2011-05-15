<?php

/**
 * Answer filter form base class.
 *
 * @package    crosswords
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseAnswerFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'word_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Word'), 'add_empty' => true)),
      'text'      => new sfWidgetFormFilterInput(),
      'answer_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserAnswer'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'word_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Word'), 'column' => 'id')),
      'text'      => new sfValidatorPass(array('required' => false)),
      'answer_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UserAnswer'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('answer_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Answer';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'word_id'   => 'ForeignKey',
      'text'      => 'Text',
      'answer_id' => 'ForeignKey',
    );
  }
}
