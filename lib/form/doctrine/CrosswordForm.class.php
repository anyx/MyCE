<?php

/**
 * Crossword form.
 *
 * @package    crosswords
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CrosswordForm extends BaseCrosswordForm {

    /**
     * 
     */
    public function configure() {
        
        unset($this['created_at'], $this['updated_at'], $this['user_id'], $this['is_public'] );
        
        $this->validatorSchema['title'] = new sfValidatorString(array(
                                                'max_length' => 255,
                                                'min_length' => 5,
        ));
    }

    /**
     *
     * @param type $userId 
     */
    public function setUserId($userId) {
        $this->values['user_id'] = $userId;
    }
    
    /**
     * 
     */
    public function hidePublicFields() {
       unset( $this['is_activated'], $this['is_public'] );
    }
}
