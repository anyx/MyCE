/**
 * 
 * @param options
 * @returns {WordForm}
 */
function WordForm( options ) {

	/**
	 * 
	 */
	var _this = this;
	
	/**
	 * 
	 */
	var form = $( options.form );
	
	/**
	 * 
	 */
	var text_field = $( options.text_field );
	
	/**
	 * 
	 */
	var definition_field = $( options.definition_field );

	/**
	 * 
	 */
	var direction_field = $( options.direction_field );

	/**
	 * 
	 */
	var binded_item = null;
	
	/**
	 * 
	 */
	this.bind = function( word_view ) {
		
		binded_item = word_view;
		var word = word_view.getWord();
		
		text_field.val( word.text );
		definition_field.val( word.definition );
		direction_field.filter( '[value=' + word.getDirection() + ']' ).attr( 'checked', 'checked' );
	};

	/**
	 * 
	 */
	this.valid = function(){
		
		$( '.error' ).remove();
		
		if ( $.trim( text_field.val() ).length < 2 ) {
			return showError( 'Слишком короткое слово', text_field );
		}
		
		if ( $.trim( definition_field.val() ).length < 3 ) {
			return showError( 'Слишком короткое определение слова', definition_field );
		}

		/**
		 * @todo special chars
		 */
		return true;
	};

	/**
	 * 
	 */
	this.getWord = function() {
		return new Word( text_field.val(), direction_field.filter(':checked').val(), definition_field.val() );
	};
	
	/**
	 * 
	 */
	this.saveWord = function(){
		
		if ( binded_item != null ) {
			binded_item.setWord( this.getWord() );
			this.clear();
		} else {
			binded_item = new WordView( this.getWord() );
			binded_item.getElement().appendTo( options.preview_box );
		}
		
		return binded_item;
	};
	
	/**
	 * 
	 */
	this.clear = function() {
		text_field.val( '' );
		definition_field.val( '' );
		direction_field.eq(0).attr( 'checked', 'checked' );
		binded_item = null;
	};
	
	/**
	 * Display errors
	 */
	function showError( message, element ) {
		element.after( '<span class="error">' + message + '</span>' );
		return false;
	}

	/**
	 * 
	 */
	this.initEvents = function() {
		$( options.submit_button ).click(function(){
			if ( _this.valid() ) {
				_this.saveWord();
			}
		});
	};
	
	this.initEvents();
};