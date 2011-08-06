<?php slot('title') ?>
<?= __('Profile user') ?> <?= $user->getName() ?>
<?php end_slot(); ?>

<?php
$showCrosswordsBlock = !sfContext::getInstance()->getRequest()->hasParameter('rpage');
?>
<div class="blocks-container">

	<div class="tabs-container"></div>
	
    <div class="block crosswords <?= !$showCrosswordsBlock? : 'active' ?> ">
		<?php
		include_component(
				'crossword', 'usercrosswords', array(
			'user_id' => $user->getId(),
			'max_count' => 20,
			'page_param' => 'cpage'
				)
		);
		?>
    </div>

    <div class="block answers <?= $showCrosswordsBlock? : 'active' ?>">
		<?php
		include_component(
				'crossword', 'usersolves', array(
			'user_id' => $user->getId(),
			'max_count' => 20,
			'page_param' => 'rpage'
				)
		);
		?>
    </div>
</div>

<script type="text/javascript">
	$(function(){
		$( '.blocks-container' ).tabsManager({
			titleContainer: '.subtitle'
		});
	})
</script>

<?php slot('help_panel') ?>
<?= __('Help!') ?>
<?php end_slot(); ?>