<?php

/**
 * BasefzTag
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property integer $weight
 * 
 * @method string  getName()   Returns the current record's "name" value
 * @method integer getWeight() Returns the current record's "weight" value
 * @method fzTag   setName()   Sets the current record's "name" value
 * @method fzTag   setWeight() Sets the current record's "weight" value
 * 
 * @package    crosswords
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasefzTag extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('fz_tag');
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'unique' => true,
             'length' => 255,
             ));
        $this->hasColumn('weight', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             ));


        $this->index('tag_weight', array(
             'fields' => 
             array(
              0 => 'weight',
             ),
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}