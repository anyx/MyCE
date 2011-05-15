/**
 * 
 * @param options
 * @returns {CrosswordResolver}
 */
var CrosswordResolver = function ( options ) {

	this.constructor.call( this, options );
	
	/**
	 * 
	 */
	var word_views = [];
	
	/**
	 * 
	 */
	this.showWords = function( words_data ) {
		
		word_views = [];
		
		for( var i = 0; i < words_data.length; i++ ) {
			
			word_view = new MappedWordView( words_data[i] );
			word_view.build();
			
			word_views[word_views.length] = word_view;
			
			for ( var j = 0; j < i; j++ ) {
				
				var intersection = getLinesIntersection( words_data[i].getStartPoint(), words_data[i].getEndPoint(), words_data[j].getStartPoint(), words_data[j].getEndPoint() );
				
				if ( intersection == null ) {
					continue;
				}
				
				for( var k = 0; k < word_view.getLetterElements().length; k++ ) {
					
					var abs_position = word_view.getAbsoluteLetterPosition( k );
					
					if ( intersection.equal( abs_position ) ) {
						for( var n = 0; n < word_views[j].getLetterElements().length; n++ ) {
							if ( intersection.equal( word_views[j].getAbsoluteLetterPosition( n ) ) ){
								word_view.replaceLetterElement( k, word_views[j].getLetterElementByNumber( n ) );
							}
						}
					}
				}
			}
			this.showWordView( word_view );
		}
	};
	
	/**
	 * 
	 */
	this.getAnswers = function() {
		var answers = [];
		for( var i = 0; i < word_views.length; i++ ) {
			answers[answers.length] = {
					id		:	word_views[i].getWordItem().getId(),
					word	:	word_views[i].getWord()
			};
		}
		return answers;
	};
	
	this.buildGrid();
};

CrosswordResolver.prototype = new AbstractCrosswordArea();