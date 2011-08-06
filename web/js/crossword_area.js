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

	options = $.extend({
		onAddItem: function( crossword, word_view ){}
	}, options); 

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
	this.addWordView = function( word_view ) {
		
		word_item = initItemFromData( word_view.getWordItem().getData() );
		var result = this.getCrossword().addItem( word_item );
		if ( result ) {
			options.onAddItem( this, word_item );
			return true;
		}
		return false;
	}

	/**
	 * @param initData
	 * @returns {WordItem}
	 */
	function initItemFromData ( initData ) {
		return new WordItem(
			{
				id			: initData.id,
				text		: initData.text,
				definition	: initData.definition
			},
			{
				direction	: initData.direction,
				x			: initData.x,
				y			: initData.y
			}
		)
	}

	/**
     * 
     */
	function initDroppable() {
		
		$( 'div.word-preview' ).droppable({
			accept		: '.word-view',
			drop: function( event, ui ) {
				ui.draggable.eq(0)
				.appendTo( $('div.word-preview') )
				.css({
					'left'	: '0px',
					'top'	: '0px',
					'position' 	: 'static'
				});
			}
		});
			
		var crosswordStartPoint = $( _this.getElement() ).offset();
        
		$( _this.getElement() ).droppable({
			accept		: '.word-view',
			activeClass	: 'droppable-active',
			hoverClass	: 'droppable-hover',
			drop: function( event, ui ) {
				var word_view = ui.draggable.get(0);
	
				var x = Math.ceil( ( event.pageX - crosswordStartPoint.left ) / _this.getCellSize() ) - 1;
				var y = Math.ceil( ( event.pageY - crosswordStartPoint.top )  / _this.getCellSize() ) - 1;
	
				var active_cell = _this.getCell( x, y );
				var word_item = word_view.getWordItem();
				
				if ( active_cell != false && _this.getCrossword().canAddItem( word_item ) ) {
		
					_this.addWordView( word_view );
                    
					active_cell = active_cell.parent().get(0);
	
					$( word_view )
						.css( 'position' , 'absolute' )
						.appendTo( _this.getElement() )
						.css( 'left', active_cell.offsetLeft - 1 )
						.css( 'top', active_cell.offsetTop - 1 );
                        
				} else {
                    
					$( word_view ).appendTo( $('div.word-preview') ).css({
						'left'		: '0px',
						'top'		: '0px',
						'position' 	: 'relative'
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