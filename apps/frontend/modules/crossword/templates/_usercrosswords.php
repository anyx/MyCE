<h4><?=__( 'Created crosswords' )?></h4>

<?if( $crosswords->count() == 0 ):?>
<?=__( 'You not create crossword yet.' )?> <?=link_to( 'Whant now?', 'crossword/new' ) ?>
<?return;?>
<?endif;?>

<?$solutions = $sf_data->getRaw( 'solutions' )?>

<table>
  <thead>
    <tr>
		<th><?=__( 'Title' )?></th>
		<th><?=__( 'Description' )?></th>
		<th><?=__( 'Date create' )?></th>
		<th><?=__( 'Count solves' )?></th>
		<th><?=__( 'Is public' )?></th>
		<th><?=__( 'Is active' )?></th>
		<th><?=__( 'Manage' )?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($crosswords as $crossword): ?>
    <tr>
      <td><a href="<?php echo url_for('@constructor_resolve?crossword_id='.$crossword->getId()) ?>" title="<?=__( 'Resolve' )?>"><?php echo $crossword->getTitle() ?></a></td>
      <td><?php echo $crossword->getDescription() ?></td>
      <td><?php echo $crossword->getCreatedAt() ?></td>
      <td class="text-center">
      	<?if( is_array( $solutions ) && array_key_exists( $crossword->getId(), $solutions ) ): ?>
      		<span class="right-count"><?=$solutions[$crossword->getId()]['right']?></span> / <span class="wrong-count"><?=$solutions[$crossword->getId()]['wrong']?></span>
      	<?else:?>
      		<?=__( 'Solutions not found' )?> 	 
      	<?endif;?>
      </td>
      <td><?php echo $crossword->getIsPublic() ?></td>
      <td><?php echo $crossword->getIsActivated() ?></td>
      <td>
      	<a href="<?php echo url_for('crossword/edit?id='.$crossword->getId()) ?>" title="<?=__( 'Edit' )?>">
      		<?=__( 'Edit' )?>
      	</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('crossword/new') ?>">New</a>
