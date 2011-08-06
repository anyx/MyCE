/**
 * Init constructor form
 */
$(function(){

	$( '.direction-selector' ).radioDecorator();
	
	context.set( 'Constructor/WordForm', new WordForm({
		form                : '.word-form',
		textField           : '#word',
		directionField      : 'input[name=direction]',
		definitionField     : '#word-definition',
		submitButton        : '.submit-button',
		previewBox          : 'div.word-preview',
		statusElement       : '#form-status',
		defaultStatus       : 'info',
		defaultStatusText   : context.get( 'Lang/Constructor/infoMessage' ),
		onBeforeWordChange  : function( word_item ) {
			var crossword = context.get( 'Constructor/CrosswordArea').getCrossword();
            
			if ( ( index = crossword.getItemIndex( word_item ) ) != null ) {
				crossword.removeItemByIndex( index );
				context.get( 'Constructor/CrosswordArea').showCrossword();
			}
		}
	}));
	
	$( 'input[name=direction]' ).change(function(){
		context.get( 'Constructor/WordForm').showWordItem();
	});
	
	WordView.context = context;

	context.set( 'Constructor/CrosswordArea', new CrosswordArea({
		element	 : '.d-crossword-area',
		cell_size   : 20,
		grid_size   : {
			width   : 25,
			height  : 25
		},
		crossword   : new Crossword,
		onAddItem   : function( crossword, word_view ) {
			context.get( 'Constructor/WordForm').clear();
		}
	}));

	/**
     * Saving Crossword
     */
	$( '#save-button' ).click(function(){
		var post_items = {
			items : context.get( 'Constructor/CrosswordArea').getCrossword().getItemsData()
		};
	
		context.get( 'Constructor/WordForm' ).setStatus( 'loading', context.get( 'Lang/Constructor/saving' ) );

		$.post( '/' + context.get( 'Site/Path' ) + 'constructor/' + context.get( 'Page/Params' )['id']  + '/save', post_items, function( words ) {
            
			var crossword = context.get( 'Constructor/CrosswordArea' ).getCrossword();
			crossword.clear();
			
			for ( var i = 0; i < words.length; i++ ) {
				crossword.addItem(
					new WordItem(
					{
						id			: words[i].id,
						text		: words[i].text,
						definition	: words[i].definition
					},
					{
						x			: words[i].x,
						y			: words[i].y,
						direction	: words[i].direction 
					}
				));
			}
			context.get( 'Constructor/CrosswordArea' ).setCrossword( crossword );
			context.get( 'Constructor/CrosswordArea' ).showCrossword();
			context.get( 'Constructor/WordForm' ).setStatus( 'success', context.get( 'Lang/Constructor/successSave' ), true, true );
		}, 'json');
	});
    
	/**
     * Clear word
     */
	$( '.clear-button' ).click(function(){
		context.get( 'Constructor/WordForm' ).clear();
	});
});