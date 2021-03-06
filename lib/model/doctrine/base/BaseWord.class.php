<?php

/**
 * BaseWord
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $word
 * @property string $definition
 * @property integer $crossword_id
 * @property boolean $horisontal
 * @property integer $x
 * @property integer $y
 * @property Crossword $Crossword
 * @property Doctrine_Collection $Answer
 * 
 * @method string              getWord()         Returns the current record's "word" value
 * @method string              getDefinition()   Returns the current record's "definition" value
 * @method integer             getCrosswordId()  Returns the current record's "crossword_id" value
 * @method boolean             getHorisontal()   Returns the current record's "horisontal" value
 * @method integer             getX()            Returns the current record's "x" value
 * @method integer             getY()            Returns the current record's "y" value
 * @method Crossword           getCrossword()    Returns the current record's "Crossword" value
 * @method Doctrine_Collection getAnswer()       Returns the current record's "Answer" collection
 * @method Word                setWord()         Sets the current record's "word" value
 * @method Word                setDefinition()   Sets the current record's "definition" value
 * @method Word                setCrosswordId()  Sets the current record's "crossword_id" value
 * @method Word                setHorisontal()   Sets the current record's "horisontal" value
 * @method Word                setX()            Sets the current record's "x" value
 * @method Word                setY()            Sets the current record's "y" value
 * @method Word                setCrossword()    Sets the current record's "Crossword" value
 * @method Word                setAnswer()       Sets the current record's "Answer" collection
 * 
 * @package    crosswords
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseWord extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('word');
        $this->hasColumn('word', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('definition', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('crossword_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('horisontal', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => 0,
             ));
        $this->hasColumn('x', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('y', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Crossword', array(
             'local' => 'crossword_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('Answer', array(
             'local' => 'id',
             'foreign' => 'word_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}