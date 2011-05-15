<?php

/**
 * fzTag filter form base class.
 *
 * @package    crosswords
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasefzTagFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'weight'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'crosswords_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Crossword')),
    ));

    $this->setValidators(array(
      'name'            => new sfValidatorPass(array('required' => false)),
      'weight'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'crosswords_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Crossword', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('fz_tag_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addCrosswordsListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.CrosswordFzTag CrosswordFzTag')
      ->andWhereIn('CrosswordFzTag.id', $values)
    ;
  }

  public function getModelName()
  {
    return 'fzTag';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'name'            => 'Text',
      'weight'          => 'Number',
      'crosswords_list' => 'ManyKey',
    );
  }
}
