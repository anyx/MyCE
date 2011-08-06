<?php

/**
 * page actions.
 *
 * @package    crosswords
 * @subpackage page
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class pagesActions extends sfActions {

	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeShow(sfWebRequest $request) {
		$this->page = Doctrine::getTable( 'Page' )->getByCode( $request->getParameter('page') );
		$this->forward404Unless($this->page);
	}
}
