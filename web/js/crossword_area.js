/**
 * 
 * @param options
 * @returns {CrosswordArea}
 */
function CrosswordArea( options ) {
	
	/**
	 * 
	 */
	var _this = this;

	/**
	 * 
	 */
	this.constructor.call( this, options );
	
	/**
	 * 
	 */
	this.showCrossword = function( crossword ) {
		
		if ( crossword == undefined ) {
			crossword = this.getCrossword();
		}
		
		this.clear();
		
		var items = crossword.getItems();
		
		for( var i = 0; i < items.length; i++ ) {
			var word_view = new WordView( items[i] );
			this.showWordView( word_view );
		}
	};
	
	/**
	 * 
	 */
	function initDroppable() {
		
		$('div.word-preview').droppable({
			accept		: '.word-view',
			drop: function( event, ui ) {
				ui.draggable.eq(0)
					.appendTo( $('div.word-preview') )
					.css({
						'left'		: '0px',
						'top'		: '0px',
						'position' 	: 'static'
					});
			}
		});
			
		$( _this.getElement() ).droppable({
			accept		: '.word-view',
			activeClass	: 'droppable-active',
			hoverClass	: 'droppable-hover',
			drop: function( event, ui ) {
				var word_view = ui.draggable.get(0);
	
				var x = Math.ceil( ( event.clientX - crossword_start_point.left ) / _this.getCellSize() ) - 1;
				var y = Math.ceil( ( event.clientY - crossword_start_point.top ) / _this.getCellSize() ) - 1;
	
				var active_cell = _this.getCell( x, y );
	
				var word_item = word_view.getWordItem();
	
				if ( active_cell != false && _this.getCrossword().canAddItem( word_item ) ) {
	
					_this.getCrossword().addItem( word_item );
					active_cell = active_cell.parent().get(0);
	
					$( word_view ).css( 'position' , 'absolute' )
						.appendTo( _this.getElement() )
							.css( 'left', active_cell.offsetLeft - 1 )
							.css( 'top', active_cell.offsetTop - 1 );
				} else {
					$( word_view ).appendTo( $('div.word-preview') ).css({
						'left'		: '0px',
						'top'		: '0px',
						'position' 	: 'static'
					});
				}
				
				return false;
			}
		});
		
		$( 'body' ).droppable({
			accept	: '.word-view',
			drop	: function( event, ui ) {
				ui.draggable.remove();
			}
		});
	}
	
	initDroppable();
	this.buildGrid();
}

CrosswordArea.prototype = new AbstractCrosswordArea();