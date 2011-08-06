<?php slot('title') ?>
<?=__('Popular crosswords')?>
<?php end_slot(); ?>

<h3 class="subtitle"><?=__('Popular crosswords')?></h3>

<?include_partial(
			'crosswordslist',
			array(
				'crosswords'	=> $crosswords,
				'solutions'		=> $solutions,
))?>