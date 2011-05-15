<?php

class crosswordComponents extends sfComponents   
  {   
    public function executeNewcrosswords(sfWebRequest $request)   
    {   
      $this->crosswords = Doctrine_Core::getTable('Crossword')->getNewCrosswords( $this->count );   
  }   
}  