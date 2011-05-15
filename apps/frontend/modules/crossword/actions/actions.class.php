<?php

/**
 * crossword actions.
 *
 * @package    crosswords
 * @subpackage crossword
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class crosswordActions extends sfActions
{

  public function executeTag( sfWebRequest $request ) {
  	
  	$this->tag = $this->getRoute()->getObject();
  	
  	$this->forward404Unless( $this->tag );

  	$this->crosswords = Doctrine_Core::getTable('Crossword')->getByTag( $this->tag );
  }
  
  
  public function executeShow(sfWebRequest $request)
  {
    $this->crossword = Doctrine_Core::getTable('Crossword')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->crossword);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new CrosswordForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new CrosswordForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($this->crossword = Doctrine_Core::getTable('Crossword')->find(array($request->getParameter('id'))), sprintf('Object crossword does not exist (%s).', $request->getParameter('id')));
    $this->form = new CrosswordForm($this->crossword);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($crossword = Doctrine_Core::getTable('Crossword')->find(array($request->getParameter('id'))), sprintf('Object crossword does not exist (%s).', $request->getParameter('id')));
    $this->form = new CrosswordForm($crossword);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($crossword = Doctrine_Core::getTable('Crossword')->find(array($request->getParameter('id'))), sprintf('Object crossword does not exist (%s).', $request->getParameter('id')));
    $crossword->delete();

    $this->redirect('crossword/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $crossword = $form->save();

      $this->redirect('crossword/edit?id='.$crossword->getId());
    }
  }

  
}
