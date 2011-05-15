<?php

/**
 * CrosswordTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CrosswordTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object CrosswordTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Crossword');
    }
    
    /**
     * 
     * 
     * @param int $count
     */
    public function getNewCrosswords( $count = 10 ) {
    	$query = $this->getQueryObject();
    	
    	return  $query->addOrderBy( 'created_at DESC' )
    			->limit( $count )
    			->execute();
    }
    
    /**
     * 
     * Enter description here ...
     * @param unknown_type $tagName
     */
    public function getByTag( fzTag $tag ) {
    	return $tag->getCrosswords();
    }
}