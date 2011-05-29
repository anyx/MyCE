/**
 * Created by JetBrains PhpStorm.
 * User: Aleksandr Klimenkov
 * Date: 03.04.11
 * Time: 21:20
 * To change this template use File | Settings | File Templates.
 */
/**
 *
 * @param wordItem
 */
function WordView( wordItem ) {

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
        return wordItem;
    };
	
    /**
     * 
     */
    this.setWordItem = function( newWordItem ) {
        wordItem = newWordItem;
    };

    /**
    * draggable
    */
    function initDraggable() {
	   
        crosswordArea = context.get( 'Constructor/CrosswordArea'); 
	   
        var crosswordStartPoint = $( crosswordArea.getElement() ).offset();
	   
        var cellSize = crosswordArea.getCellSize(); 
        var left, top;
	   
        _this.getElement().draggable({
            cursor: 'move',
            zIndex: 10,
            appendTo: crosswordArea.getElement(),
            revert: 'invalid',
            start: function( event, ui ) {
                if ( $( this ).parent().get(0) == crosswordArea.getElement() ) {
                    crosswordArea.getCrossword().removeItem( _this.getWordItem() );
                }
                ui.helper.appendTo( crosswordArea.getElement() ).css( 'position', 'absolute' );
            },
            drag: function( event, ui ) {
                var x = Math.ceil( ( event.pageX - crosswordStartPoint.left ) / cellSize ) - 1;
                var y = Math.ceil( ( event.pageY - crosswordStartPoint.top ) / cellSize ) - 1; 
			   
                wordItem.setStartPoint({
                    x : x,
                    y : y	   
                });

                if ( !crosswordArea.getCrossword().canAddItem( wordItem ) ) {
                    setBorderColor( '#c00' );
                } else {
                    setBorderColor( '#000' );
                }
			   
                if ( crosswordArea.getElement() == $(this).parent().get(0) ) {
                    left = x * cellSize;
                    top = y * cellSize;
                } else {
                    left = - ( context.word_preview_point.left - ( x * cellSize + crosswordStartPoint.left ) );
                    top = y * cellSize;
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
            context.get( 'Constructor/WordForm').bind( _this );
        });
	   
    }
 
    this.build( wordItem );
    initEvents();
    initDraggable();
}

WordView.prototype = new AbstractWordView;