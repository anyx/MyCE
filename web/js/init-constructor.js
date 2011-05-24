/**
 * Created by JetBrains PhpStorm.
 * User: Aleksandr Klimenkov
 * Date: 03.04.11
 * Time: 16:48
 * To change this template use File | Settings | File Templates.
 */

var context = {};

$(function(){

    $( '.direction-selector' ).radioDecorator();
	
    context.word_preview_point = $( '.word-preview' ).offset();
	
    context.word_form = new WordForm({
        form                : '.word-form',
        textField           : '#word',
        directionField      : 'input[name=direction]',
        definitionField     : '#word-definition',
        submitButton        : '.submit-button',
        previewBox          : 'div.word-preview',
        statusElement       : '#form-status',
        defaultStatus       : 'info',
        defaultStatusText   : 'In this place you can see current constructor status',
        onBeforeWordChange  : function( word_item ) {
            var crossword = context.crossword_area.getCrossword();
            
            if ( ( index = crossword.getItemIndex( word_item ) ) != null ) {
                crossword.removeItemByIndex( index );
                context.crossword_area.showCrossword();
            }
        }
    });
	
    WordView.context = context;

    context.crossword_area = new CrosswordArea({
        element	 : '.d-crossword-area',
        cell_size   : 20,
        grid_size   : {
            width   : 25,
            height  : 25
        },
        crossword   : new Crossword,
        onAddItem   : function( crossword, word_view ) {
           context.word_form.clear();
        }
    });



    /**
     * Saving Crossword
     */
    $( '#save-button' ).click(function(){
        var post_items = {
            items : context.crossword_area.getCrossword().getItemsData()
        };
		
        $.post( '/frontend_dev.php/constructor/1/save', post_items, function( words ) {
            var crossword = context.crossword_area.getCrossword();
            crossword.clear();
			
            for ( var i = 0; i < words.length; i++ ) {
                crossword.addItem(
                     new WordItem(
                        {
                            text 	: words[i].word,
                            definition	: words[i].definition,
                            id		: words[i].id
                        },
                        {
                            x		: words[i].x,
                            y		: words[i].y,
                            direction	: words[i].direction 
                        }
                     )
                );
            }
            context.crossword_area.setCrossword( crossword );
            context.crossword_area.showCrossword();
        }, 'json');
    });
});