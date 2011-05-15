<?php

/**
 * fzTag form base class.
 *
 * @method fzTag getObject() Returns the current form's model object
 *
 * @package    crosswords
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasefzTagForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'name'            => new sfWidgetFormInputText(),
      'weight'          => new sfWidgetFormInputText(),
      'crosswords_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Crossword')),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'            => new sfValidatorString(array('max_length' => 255)),
      'weight'          => new sfValidatorInteger(array('required' => false)),
      'crosswords_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Crossword', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'fzTag', 'column' => array('name')))
    );

    $this->widgetSchema->setNameFormat('fz_tag[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'fzTag';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['crosswords_list']))
    {
      $this->setDefault('crosswords_list', $this->object->Crosswords->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveCrosswordsList($con);

    parent::doSave($con);
  }

  public function saveCrosswordsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['crosswords_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Crosswords->getPrimaryKeys();
    $values = $this->getValue('crosswords_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Crosswords', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Crosswords', array_values($link));
    }
  }

}
