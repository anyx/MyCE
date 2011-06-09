<?php

class crosswordComponents extends sfComponents {
	   
    public function executeNewcrosswords(sfWebRequest $request) {   
    	$this->crosswords = Doctrine_Core::getTable('Crossword')->getNewCrosswords( $this->count );   
	}
	
	/**
	 * User crosswords list
	 *  
	 * @param sfWebRequest $request
	 */
    public function executeUsercrosswords(sfWebRequest $request) {   
    	$this->crosswords = Doctrine_Core::getTable('Crossword')->getUserCrosswords( $this->user_id );

    	if ( $this->crosswords->count() > 0 ) {

    		$crosswordIds = array();
    		
    		foreach ( $this->crosswords as $crossword ) {
    			$crosswordIds[] = $crossword->getId();
    		}
    		
	    	$this->solutions = Doctrine_Core::getTable( 'UserAnswer' )->getCrosswordAnswers( $crosswordIds );
    	}
    }   
}  