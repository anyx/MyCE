<?php slot('title') ?>
<?= __('Crosswords') ?>
<?php end_slot(); ?>

<h3 class="subtitle"><?=__('Popular crosswords')?></h3>

<?include_partial(
			'crosswordslist',
			array(
				'crosswords'	=> $popularCrosswords,
				'solutions'		=> $popularSolutions,
				'fullListRoute'	=> 'crossword/popular'
))?>


<h3 class="subtitle"><?=__('New crosswords')?></h3>

<?include_partial(
		'crosswordslist',
		array(
			'crosswords'	=> $newCrosswords,
			'solutions'		=> $newSolutions,
			'fullListRoute'	=> 'crossword/news'
))?>

<?php slot( 'help_panel' );?>
<?=__( 'The popularity of the crossword is determined by the number of its passages' );?>
<?php end_slot(); ?>