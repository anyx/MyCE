<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('crossword/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>

<?=$form->renderGlobalErrors();?>

<dl class="form">
<?php foreach ( $form as $field ):?>
    <?php if ( $field->isHidden() ) continue; ?>
    
    <?php if ( $field->getWidget()->getOption( 'type' ) == 'checkbox' ): ?>
        <dt><?=$field->render();?> <?=$field->renderHelp();?><?=$field->renderLabel();?><?=$field->renderError();?></dt>
        <dd></dd>
    
    <?php else: ?>
        <dt><?=$field->renderHelp();?><?=$field->renderLabel();?><?=$field->renderError();?></dt>
        <dd><?=$field->render();?></dd>
    <?php endif;?>
        
<?php endforeach;?>
</dl>

<?php //echo $form ?>

<input type="submit" value="<?=__("Save")?>" class="save-crossword button" />
          
<?php if (!$form->getObject()->isNew()): ?>
<?=link_to(
            'Delete',
            'crossword/delete?id='.$form->getObject()->getId(),
            array(
                'method'    => 'delete',
                'confirm'   => 'Are you sure?',
                'class'     => 'delete button'
            )
);?>
<?php endif; ?>

<?=$form->renderHiddenFields();?>
</form>

<?php slot( 'help_panel' );?>
<?=__( 'If crossword is not valid, you can\'t public crossword' );?>
<?php end_slot(); ?>