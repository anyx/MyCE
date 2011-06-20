<?php slot('title') ?>
<?= __('Edit crossword') ?>
<?php end_slot(); ?>

<?php if ( !empty( $crossword ) ): ?>
<div class="top-link-container">
<?=link_to( 'Go to constructor', '@constructor?id=' . $crossword->getId() );?>
</div>
<?php endif; ?>

<?php include_partial('form', array('form' => $form)) ?>
