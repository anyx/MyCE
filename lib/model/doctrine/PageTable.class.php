<?php

/**
 * PageTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PageTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object PageTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Page');
    }
	
	public function getByCode( $code ) {
		if (empty($code)) {
			throw new InvalidArgumentException('Code is missing');
		}
		return $this->findOneBy( 'code', $code );
	}
	
}