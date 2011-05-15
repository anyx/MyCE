/**
 * 
 * @returns {AbstractWordView}
 */
function AbstractWordView() {

	/**
	 * 
	 */
	var word_class = 'word-view';
	
	/**
	 * 
	 */
	var element = $( '<div />' ).addClass( word_class );

	/**
	 * 
	 */
	this.getElement = function() {
		return element;
	};
		
	/**
	 * Build
	 */
	this.build = function( word_item ) {
		
		var table = $( '<table>' ).addClass( 'word-table' ).append( '<tbody>' );
		
		if ( word_item.isHorizontal() ) {
			table.children( 'tbody' ).append( $( '<tr>' ) );
			for ( i = 0; i < word_item.getLength(); i++ ) {
				table.children( 'tbody' )
					.children( 'tr' ).append( '<td>'+word_item.getText().charAt(i)+'</td>' );
			}
		} else {
			for ( i = 0; i < word_item.getLength(); i++ ) {
				table.children( 'tbody' )
					.append( '<tr><td>'+word_item.getText().charAt(i)+'</td></tr>' );
			}
		}
		
		element.append( table );
		
		element.get(0).getWordItem = function() {
			return word_item;
		};
	};
}