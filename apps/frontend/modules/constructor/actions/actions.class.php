<?php

/**
 * constructor actions.
 *
 * @package    crosswords
 * @subpackage constructor
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class constructorActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {

        $this->crossword = $this->getRoute()->getObject();

        $this->forward404Unless($this->crossword, 'Object crossword does not exist');

        $this->word_items = $this->crossword->getWords();
    }

    /**
     * 
     * Enter description here ...
     * @param sfWebRequest $request
     */
    public function executeSave(sfWebRequest $request) {

        $this->setLayout(null);

        $crossword = $this->getRoute()->getObject();
        $this->forward404Unless($crossword, 'Object crossword does not exist');

        $crossword->removeWords();

        $items = $request->getParameter('items');

        $this->result_items = array();

        foreach ( $items as $item ) {
            $word = null;
            
            if ( array_key_exists('id', $item) && intval($item['id']) > 0 ) {
                $word = Doctrine::getTable('Word')->find($item['id']);
            }
            
            if ( empty( $word ) ) {
                $word = new Word;
            }
            
            $word->setWord($item['text'])
                    ->setDefinition($item['definition'])
                    ->setHorisontal($item['direction'] == 'horizontal')
                    ->setCrossword($crossword)
                    ->setX($item['x'])
                    ->setY($item['y'])
            ;

            $word->save();
                    
            $this->result_items[] = array(
                'id'			=> $word->getId(),
                'text'			=> $word->getWord(),
                'direction'		=> $word->getHorisontal() ? 'horizontal' : 'vertical',
                'definition'	=> $word->getDefinition(),
                'x'				=> $word->getX(),
                'y'				=> $word->getY()
            );
        }
    }

}
