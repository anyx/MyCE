<?php

/**
 * resolve actions.
 *
 * @package    crosswords
 * @subpackage front
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class resolveActions extends sfActions
{
	
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  }
  
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeResolve(sfWebRequest $request)
  {
  	$this->crossword = $this->getRoute()->getObject();
	
	if ( $this->crossword->getUserId() != $this->getUser()->getGuardUser()->getId() )  {
		$this->forward404Unless( $this->crossword->getIsActivated() );
	}
  }
   
  public function executeSave(sfWebRequest $request)
  {
  	$this->result = false;
  	$this->correct = false;
  	 
    $this->setLayout( null );
    
  	$this->crossword = $this->getRoute()->getObject();
  	
	$user = $this->getUser()->getGuardUser();
  	
  	$answers = $request->getParameter( 'answers' );
  	
  	if ( !is_array( $answers ) || count( $answers ) <= 0 ) {
  		return false;
  	}	
  		
	array_map( function( $answer ) {
		$answer['word'] = strtolower( $answer['word'] );
		return $answer;
	}, $answers );  		
 	
	//Получение ответа пользователя
	$user_answer = Doctrine::getTable( 'UserAnswer' )->getUserAnswer( $user->getId(), $this->crossword->getId() );
	if ( empty( $user_answer ) ) {
		$user_answer = new UserAnswer();
		$user_answer->setUserId( $user->getId() );
		$user_answer->setCrossword( $this->crossword );
		$user_answer->save();
	}
	
	//сохранение слов	
	$answers_table = Doctrine::getTable( 'Answer' );
	$answers_table->clearAnswerWords( $user_answer->getId() );
	
	/**
	 * @todo validation
	 */
	foreach ( $answers as $answer_item ) {
		$answer = new Answer();
		$answer->setText( $answer_item['word'] );
		$answer->setWordId( $answer_item['id'] );
		$answer->setAnswerId( $user_answer->getId() );
		$answer->save();
	}
	
	$this->result = true;
	$this->correct = $user_answer->isCorrect();
	
  }
}