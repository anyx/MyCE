<?php

/**
 * 
 */
class crosswordComponents extends sfComponents {

    /**
     *
     * @param sfWebRequest $request 
     */
    public function executeNewcrosswords(sfWebRequest $request) {
        $this->crosswords = Doctrine_Core::getTable('Crossword')->getNewCrosswords($this->count);

    }

	/**
	 *
	 * @param sfWebRequest $request 
	 */
	public function executePopularcrosswords(sfWebRequest $request) {
		$this->crosswords = Doctrine_Core::getTable('Crossword')->getPopularCrosswords($this->count);
	}
	
    /**
     * User crosswords list
     *  
     * @param sfWebRequest $request
     */
    public function executeUsercrosswords(sfWebRequest $request) {

        $this->pager = new sfDoctrinePager(
                        'Crossword',
                        $this->max_count
        );

        $this->pager->setQuery(Doctrine_Core::getTable('Crossword')->getUserCrosswordsQuery($this->user_id));
        $this->pager->setPage($request->getParameter($this->page_param, 1));
        $this->pager->init();

        $this->crosswords = $this->pager->getResults();
        $this->solutions = array();

        if (!empty($this->crosswords) && $this->crosswords->count() > 0) {

            $crosswordIds = array();

            foreach ($this->crosswords as $crossword) {
                $crosswordIds[] = $crossword->getId();
            }

            $this->solutions = Doctrine_Core::getTable('UserAnswer')->getCrosswordAnswers($crosswordIds);
        }
    }

	/**
     *
     * @param sfWebRequest $request 
     */
    public function executeUsersolves(sfWebRequest $request) {

        $this->pager = new sfDoctrinePager(
                        'UserAnswer',
                        $this->max_count
        );

        $this->pager->setQuery(Doctrine_Core::getTable('UserAnswer')->getUserAnswersQuery($this->user_id));
        $this->pager->setPage($request->getParameter($this->page_param, 1));
        $this->pager->init();
        
        $results = $this->pager->getResults();
        
        if ( !empty( $results ) && count( $results ) > 0 ) {
            
            $crosswordIds = array();
            foreach ($results as $answer) {
                if (!in_array($answer->getCrosswordId(), $crosswordIds)){
                    $crosswordIds[] = $answer->getCrosswordId();
                }
            }
            $this->crosswords = Doctrine_Core::getTable( 'Crossword' )->getByIds($crosswordIds);
        }
    }

}

