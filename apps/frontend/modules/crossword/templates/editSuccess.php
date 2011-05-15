<h1>Edit Crossword</h1>
<?=link_to( 'Go to constructor', '@constructor?crossword_id=' . $crossword->getId() );?>
<?php include_partial('form', array('form' => $form)) ?>
