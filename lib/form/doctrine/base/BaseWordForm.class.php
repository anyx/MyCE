<?php

/**
 * Word form base class.
 *
 * @method Word getObject() Returns the current form's model object
 *
 * @package    crosswords
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseWordForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'word'         => new sfWidgetFormInputText(),
      'definition'   => new sfWidgetFormInputText(),
      'crossword_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Crossword'), 'add_empty' => false)),
      'horisontal'   => new sfWidgetFormInputCheckbox(),
      'x'            => new sfWidgetFormInputText(),
      'y'            => new sfWidgetFormInputText(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'word'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'definition'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'crossword_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Crossword'))),
      'horisontal'   => new sfValidatorBoolean(array('required' => false)),
      'x'            => new sfValidatorInteger(),
      'y'            => new sfValidatorInteger(),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('word[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Word';
  }

}
