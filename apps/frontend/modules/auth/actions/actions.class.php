<?php

/**
 * authorization actions.
 *
 * @package    crosswords
 * @subpackage constructor
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class authActions extends sfActions {
	
  protected $availableAuthServices = array(
  		'facebook',
  		'google',
  		'twitter',
		'vkontakte'
  );	

  public function preExecute() {
  	$this->availableServices = $this->availableAuthServices;
  }
  
  /**
   * 
   * @param sfWebRequest $request
   */
  public function executeIndex( sfWebRequest $request ) {
  }
  
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeConnect(sfWebRequest $request) {
  	
	$service = $request->getParameter( 'service' );
	
  	if ( in_array( $service, $this->availableServices ) ) {
	  	$this->getUser()->connect( $service ); 	
  	}
  }

  /**
   * 
   * @param sfWebRequest $request
   */
  public function executeSuccess( sfWebRequest $request ) {

	$service = $request->getParameter( 'service' );

    $user = $this->getUser()->getMelody( $service )->getMe();
	
    switch ( $service ) {
    	case 'facebook'	: 
    		$userLink = $user->link;
    		break;
    	case 'twitter'	:
    		$userLink = 'http://twitter.com/#!/' . $user->screen_name;
    		break;
		case 'vkontakte' :
			$userData = current( $user->response );
    		$userLink = 'http://vk.com/id' . $userData->uid;
    		break;
    	default:
    		$userLink = '';
    }
    
    $this->getUser()->setAttribute( 'auth_service' , $service );
    $this->getUser()->setAttribute( 'service_profile_link' , $userLink );
    
	$this->redirect( 'homepage' );
  }
  
  /**
   * @param sfWebRequest $request
   */
  public function executeLogout(sfWebRequest $request) {
  	$user = $this->getUser();
  	if ( $user->isAuthenticated() ) {
  		$user->signOut();
  	}
	$this->redirect( 'homepage' );
  }
}