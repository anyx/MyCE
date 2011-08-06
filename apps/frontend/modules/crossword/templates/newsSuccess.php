<?php slot('title') ?>
<?=__('New crosswords')?>
<?php end_slot(); ?>

<?include_partial(
			'crosswordslist',
			array(
				'crosswords'	=> $crosswords,
				'solutions'		=> $solutions,
))?>