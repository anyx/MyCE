<?if ( !empty( $crosswords ) ):?>

<?php use_helper('Text') ?>
<?php use_helper('Date') ?>

	<table class="crosswords-list table" cellspacing="0">
	<thead>
		<th><?=__('Crossword')?></th>
		<th><?=__('Date update')?></th>
		<th><?=__('Count solves')?></th>
	</thead>
	<?foreach ( $crosswords as $crossword ):?>
		<tr>
			
			<td class="name-container">
				<a href="<?php echo url_for('@crossword_resolve?id=' . $crossword->getId()) ?>" class="title" title="<?= __('Resolve') ?>">
					<?php echo $crossword->getTitle() ?>
				</a>
				<div class="description">
					<?php echo truncate_text($crossword->getDescription(), 512) ?>
				</div>
			</td>
			<td><?php echo format_date($crossword->getUpdatedAt()) ?></td>
			<td>
				<?if ( !empty( $solutions ) ):?>
					<?if(!empty($solutions[$crossword->getId()]) ):?>
						<span class="right-count"><?= $solutions[$crossword->getId()]['right'] ?></span> / <span class="wrong-count"><?= $solutions[$crossword->getId()]['wrong'] ?></span>
					<?else:?>
						<span><?=__('Solutions not found')?></span>
					<?endif;?>
				<?else:?>
					<span><?=__('Solutions not found')?></span>
				<?endif;?>
			</td>
		</tr>
	<?endforeach;?>
	</table>

	<?php if ( !empty( $fullListRoute ) ): ?>
	<p>
	<?=link_to( 'More', $fullListRoute )?>
	</p>
	<?php endif;?>

<?else:?>
	<div class="info message"><?=__('Crosswords not found')?></div>
<?endif;?>
