/**
 * Created by JetBrains PhpStorm.
 * User: Aleksandr Klimenkov
 * Date: 03.04.11
 * Time: 21:20
 * To change this template use File | Settings | File Templates.
 */
/**
 *
 * @param WordItem word_item
 */
function WordView( word_item ) {

    this.constructor.call( this );
    
    /**
     * 
     */
    var _this = this;
	
    /**
     * 
     */
    var context = arguments.callee.context;
	
    /**
     * 
     */
    this.getContext = function() {
        return context;
    };
	
    /**
     * 
     */
    this.getWordItem = function() {
        return word_item;
    };
	
    /**
     * 
     */
    this.setWordItem = function( new_word_item ) {
        word_item = new_word_item;
    };

    /**
    * draggable
    */
    function initDraggable() {
	   
        crossword_area = context.crossword_area; 
	   
        crossword_start_point = $( crossword_area.getElement() ).offset();
	   
        var cell_size = crossword_area.getCellSize(); 
        var left, top;
	   
        _this.getElement().draggable({
            cursor: 'move',
            zIndex: 10,
            appendTo: crossword_area.getElement(),
            revert: 'invalid',
            start: function( event, ui ) {
                if ( $( this ).parent().get(0) == crossword_area.getElement() ) {
                    crossword_area.getCrossword().removeItem( _this.getWordItem() );
                }
                ui.helper.appendTo( crossword_area.getElement() ).css( 'position', 'absolute' );
            },
            drag: function( event, ui ) {
                var x = Math.ceil( ( event.pageX - crossword_start_point.left ) / cell_size ) - 1;
                var y = Math.ceil( ( event.pageY - crossword_start_point.top ) / cell_size ) - 1; 
			   
                word_item.setStartPoint({
                    x : x,
                    y : y	   
                });

                if ( !crossword_area.getCrossword().canAddItem( word_item ) ) {
                    setBorderColor( '#c00' );
                } else {
                    setBorderColor( '#000' );
                }
			   
                if ( context.crossword_area.getElement() == $(this).parent().get(0) ) {
                    left = x * cell_size;
                    top = y * cell_size;
                } else {
                    left = - ( context.word_preview_point.left - ( x * cell_size + crossword_start_point.left ) );
                    top = y * cell_size;
                }
	
                ui.position.left = left;
                ui.position.top = top;
            }
        });
    }

    /**
    * 
    * @param color
    */
    function setBorderColor( color ) {
        var borderable = $( _this.getElement() ).find( 'table' ).find('td').andSelf().css( 'borderColor', color );
    }
   
    /**
    * 
    */
    function initEvents() {
        _this.getElement().click(function(){
            context.word_form.bind( _this );
        });
	   
    }
 
    this.build( word_item );
    initEvents();
    initDraggable();
}

WordView.prototype = new AbstractWordView;