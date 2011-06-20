<?php

/**
 * crossword actions.
 *
 * @package    crosswords
 * @subpackage crossword
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class crosswordActions extends sfActions {

    /**
     *
     * @param sfWebRequest $request 
     */
    public function executeTag(sfWebRequest $request) {

        $this->tag = $this->getRoute()->getObject();

        $this->forward404Unless($this->tag);

        $this->crosswords = Doctrine_Core::getTable('Crossword')->getByTag($this->tag);
    }

    /**
     *
     * @param sfWebRequest $request 
     */
    public function executeShow(sfWebRequest $request) {
        $this->crossword = Doctrine_Core::getTable('Crossword')->find(array($request->getParameter('id')));
        $this->forward404Unless($this->crossword);
    }

    /**
     *
     * @param sfWebRequest $request 
     */
    public function executeNew(sfWebRequest $request) {
        $this->form = new CrosswordForm();

        unset($this->form['is_activated'], $this->form['is_public']);
    }

    /**
     *
     * @param sfWebRequest $request 
     */
    public function executeCreate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod(sfRequest::POST));

        $this->form = new CrosswordForm();

        $this->processForm($request, $this->form);

        $this->form->hidePublicFields();
        $this->setTemplate('new');
    }

    /**
     *
     * @param sfWebRequest $request 
     */
    public function executeEdit(sfWebRequest $request) {
        $this->forward404Unless($this->crossword = Doctrine_Core::getTable('Crossword')->find(array($request->getParameter('id'))), sprintf('Object crossword does not exist (%s).', $request->getParameter('id')));

        $this->form = new CrosswordForm($this->crossword);
        
        if ( !$this->crossword->valid() ) {
            $this->form->hidePublicFields();
        }
    }

    /**
     *
     * @param sfWebRequest $request 
     */
    public function executeUpdate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($crossword = Doctrine_Core::getTable('Crossword')->find(array($request->getParameter('id'))), sprintf('Object crossword does not exist (%s).', $request->getParameter('id')));
        $this->form = new CrosswordForm($crossword);

        $this->processForm($request, $this->form);
        $this->form->hidePublicFields();
        $this->setTemplate('edit');
    }

    /**
     *
     * @param sfWebRequest $request 
     */
    public function executeDelete(sfWebRequest $request) {
        $request->checkCSRFProtection();

        $this->forward404Unless($crossword = Doctrine_Core::getTable('Crossword')->find(array($request->getParameter('id'))), sprintf('Object crossword does not exist (%s).', $request->getParameter('id')));
        $crossword->delete();

        $this->redirect('crossword/index');
    }

    /**
     *
     * @param sfWebRequest $request
     * @param sfForm $form 
     */
    protected function processForm(sfWebRequest $request, sfForm $form) {

        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

        $form->setUserId($this->getUser()->getGuardUser()->getId());

        if ($form->isValid()) {

            $crossword = $form->save();
            $this->getUser()->setFlash( 'notice', 'Crossword save succesfully' );
            $this->redirect('crossword/edit?id=' . $crossword->getId());
        }
    }

}
