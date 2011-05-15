<div class="constructor">

	<div class="right-panel">
		<div class="words-panel">
			<form class="word-form">
				<dl class="form">
					<dt><label for="word">Word</label></dt>
					<dd class="form-item"><input type="text" name="word" maxlength="255" id="word"/></dd>
					<dt><label for="word-definition">Definition</label></dt>
					<dd class="form-item"><textarea name="word-definition" id="word-definition"></textarea></dd>
					<dt>Direction</dt>
					<dd>
						<input type="radio" name="direction" value="horizontal" id="direction-horizontal"/><label for="direction-horizontal">Horizontal</label>
						<input type="radio" name="direction" value="vertical" id="direction-vertical"/><label for="direction-vertical">Vertical</label>
					</dd>
				</dl>
				<input type="button" class="submit-button" value="Add" />
			</form>
			<span id="log"></span>
		</div>
		
		<input type="button" value="Save Crossword" id="save-button" />
	</div>
	
	<div class="word-preview">
	</div>

	<div class="d-crossword-area">
	</div>
	<script type="text/javascript">
	
		$(function(){
			<?if( count( $word_items ) > 0 ):?>
				<?foreach ( $word_items as $word_item ):?>
				var word_item = new WordItem(
							{
								text		: "<?=$word_item['word']?>",
								definition	: "<?=$word_item['definition']?>",
								id			: <?=$word_item['id']?>
							},
							{
								x 			: <?=$word_item['x']?>,
								y 			: <?=$word_item['y']?>,
								direction	: "<?=$word_item['direction']?>"
							}
				);
				context.crossword_area.getCrossword().addItem( word_item );
				<?endforeach;?>
			<?endif;?>
			
			var crossword = context.crossword_area.getCrossword();
			console.log( crossword );
			context.crossword_area.showCrossword();
		});
	</script>
</div>