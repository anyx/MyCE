
<?$word_items = $crossword->getWords()?>

<?if( count( $word_items ) == 0 ):?>
Words not found!
<?return;?>
<?endif;?>

<?php slot('title') ?>
<?=__( 'Crossword' )?> &laquo;<?=$crossword->getTitle();?>&raquo;
<?php end_slot(); ?>

<div class="tags">

<?$tags = $crossword->getTags();?>
<?if( count( $tags ) > 0 ):?>
<?$aTags = array();?>
	<?foreach ( $tags as $tag ):?>
		<?$aTags[] = link_to( $tag->getName(), 'fz_tag_show', array( 'name' => $tag->getName() ) )?>
	<?endforeach;?>
<span class="tag-title"><?=__( 'Tags' )?>:</span> <?=implode( ', ', $aTags )?>
<?endif;?>
</div>


<?
$horizontal_words = array();
$vertical_words = array();
foreach ( $word_items as $word_number => $word ) {
	if ( $word->isHorizontal() ) {
		$horizontal_words[$word_number] = $word;
	} else {
		$vertical_words[$word_number] = $word;
	}
}
?>

<div class="resolver-right-block">

	<input type="button" id="save-button" value="<?=__( 'Save answer' )?>" />
	
	<div class="definition-panel">
		<h4>Horizontal</h4>
		<?foreach( $horizontal_words as $number => $word ):?>
		<div>
			<span class="number"><?=$number+1?></span>. <span class="word"><?=$word->getDefinition()?></span>
		</div>
		<?endforeach;?>
		
		<h4>Vertical</h4>
		<?foreach( $vertical_words as $number => $word ):?>
		<div>
			<span class="number"><?=$number+1?></span>. <span class="word"><?=$word->getDefinition()?></span>
		</div>
		<?endforeach;?>
	</div>
</div>


<div class="errors-panel"></div>
<div class="messages-panel"></div>
<div class="success-panel"></div>

<div class="d-crossword-area resolver">
</div>

<script type="text/javascript">
	$(function(){

		var messages_helper = new MessagesHelper({
				timeout	: 3000,
				types	: {
					error	: {
						selector	: '.errors-panel'
					},
					info	: {
						selector	: '.messages-panel'
					},
					success	: {
						selector	: '.success-panel'
					}
				}
			});

		MappedWordView.messages_helper = messages_helper; 
		
		var crossword_resolver = new CrosswordResolver({
			element	 	: '.d-crossword-area',
			cell_size   : 20,
			grid_size   : {
							width   : 25,
							height  : 25
			}
		});

		var words = [];
		
		<?foreach ( $word_items as $number => $word_item ):?>
		words[words.length] = new MappedWordItem(
								{
									length		: "<?=strlen( $word_item->getWord())?>",
									definition	: "<?=$word_item->getDefinition()?>",
									id			: <?=$word_item->getId()?>
								},
								{
									x			: <?=$word_item->getX()?>,
									y			: <?=$word_item->getY()?>,
									direction	: "<?=$word_item->getHorisontal() ? 'horizontal' : 'vertical'?>",
									number		: <?=$number+1?>
								}

		);

		<?endforeach;?>
		crossword_resolver.showWords( words );

		$('#save-button').click(function(){

			$.post( '/frontend_dev.php/resolve/1/save', { answers : crossword_resolver.getAnswers() }, function( response ) {
				
				if ( response.result ) {
					messages_helper.showMessage( 'info', 'Save success' );
				} else {
					messages_helper.showMessage( 'error', 'Answer isn\'t save' );
				}
				
				if ( response.correct ) {
					messages_helper.showMessage( 'success', 'Correct!' );
				} else {
					messages_helper.showMessage( 'error', 'Not correct!' );
				}

			}, 'json');
		});
	});
</script>