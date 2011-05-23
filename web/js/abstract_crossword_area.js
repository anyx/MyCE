function AbstractCrosswordArea( options ) {
	
	options = $.extend({
				element		: null,
				cell_size	: 25,
				grid_size   : {
					width   : 25,
					height  : 25
				}
	}, options); 
	
	/**
	 * 
	 */
	var element = null;
	
	/**
	 * 
	 */
	this.setOptions = function ( new_options ) {
		element = $( options.element );
		options = new_options;
	};
	
	/**
	 * 
	 */
	this.getCrossword = function() {
		return options.crossword; 
	};
	
	/**
	 * 
	 */
	this.setCrossword = function( crossword ) {
		options.crossword = crossword;
	};

	/**
	 * 
	 */
	this.getCell = function( x, y ) {
		row = element.find( 'tr:eq(' + y +')' );
		if ( row.length > 0 ) {
			return row.find( 'td:eq(' + x + ') div' );
		}
		return false;
	};
	
	/**
	 * 
	 */
	this.getCellSize = function() {
		return options.cell_size;
	};
	
	/**
	 * 
	 */
	this.clear = function() {
		element.find('.word-view').remove();
	};
	
	/**
	 * 
	 */
	this.getElement = function() {
		return element.get(0);
	};
	
	/**
	 * 
	 */
	this.buildGrid = function() {
		
		var table = $('<table></table>').addClass( 'grid' );

		var tbody = $('<tbody></tbody>').appendTo( table );

		for ( var i = 0; i < options.grid_size.height; i++ ) {
			var row = $('<tr></tr>').appendTo( tbody );
			for ( var j = 0; j < options.grid_size.width; j++ ) {
				$('<td><div/></td>').appendTo( row );
			}
		}
		element.empty().append( table );
	};

	/**
	 * 
	 */
	this.showWordView = function( word_view ) {
		
		var position = word_view.getWordItem().getPosition();
		
		var cell = this.getCell( position.x, position.y );
		var cell_position = cell.position();
		
		$( word_view.getElement() ).css( 'position' , 'absolute' )
		.appendTo( this.getElement() )
			.css({
				'left'		: cell_position.left - 1,
				'top'		: cell_position.top - 1,
				'zIndex'	: '50'
			});
	};
	
	this.setOptions( options );
}