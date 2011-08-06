/**
 * @param mapped_word_item
 * 
 * @returns {MappedWordView}
 */
function MappedWordView( mapped_word_item ) {

	var _this = this;
	
	/**
	 *
	 */
	var active_direction = 'horizontal';
	
	/**
	 * 
	 */
	var letters = [];
	
	this.constructor.call( this );

	/**
	 * 
	 */
	this.getLetterElements = function(){
		return letters;
	};
	
	/**
	 * 
	 */
	this.replaceLetterElement = function( index, element ) {
		$( letters[index] ).replaceWith( element );
		letters[index] = element;
	};
	
	/**
	 * 
	 */
	this.getWordItem = function() {
		return mapped_word_item;
	};
	
	/**
	 * @param code
	 * @return bool
	 */
	function isAllowCharCode( code ) {
		
		if ( code >= 1040 /*А*/ && code <= 1103 /*я*/  ) {
			return true;
		}

		if ( code == 1025 || code == 1105 /*ё*/  ) {
			return true;
		}

		if ( code >= 65 /*A*/ && code <= 90 /*Z*/  ) {
			return true;
		}

		if ( code >= 97 /*a*/ && code <= 122 /*z*/  ) {
			return true;
		}
	
		return false;
	}
	
	/**
	 * 
	 */
	this.getAbsoluteLetterPosition = function ( letter_number ) {
		
		var word_item = this.getWordItem();
		
		var position = word_item.getStartPoint();
		
		if ( word_item.isHorizontal() ) {
			position.x += letter_number;
		} else {
			position.y += letter_number;
		}
		
		return position;
	};
	
	/**
	 *
	 */
	function getElementByPosition( point ) {
		return $( 'input[data-x=' + point.x + ']' )
			.filter('[data-y=' + point.y + ']')
			.get(0);
	}
	
	/**
	 * 
	 */
	this.getLetterElementByNumber = function( number ) {
		return letters[number];
	};
	
	/**
	 * Build
	 */
	this.build = function() {
		
		letters = [];
		
		var table = $( '<table>' ).addClass( 'word-table' ).attr( 'rel', mapped_word_item.getNumber() ).append( '<tbody>' );
	
		if ( mapped_word_item.isHorizontal() ) {
			table.children( 'tbody' ).append( $( '<tr>' ) );
		}
		
		for ( i = 0; i < mapped_word_item.getLength(); i++ ) {
			var cell = null;
		
			if ( mapped_word_item.isHorizontal() ) {
				cell = $( '<td></td>' ).appendTo( table.children( 'tbody' ).children( 'tr' ) );
				
			} else {
				cell = $( '<td></td>' );
				var tr = $( '<tr />' ).append( cell );
				
				table.children( 'tbody' )
				.append( tr );
			}
			
			var position = this.getAbsoluteLetterPosition( i );
			
			letters[letters.length] = $( '<input type="text"/>' )
				.attr( 'data-x', position.x )
				.attr( 'data-y', position.y )
				
				.appendTo( cell )
				.get(0);
		}
		
		var first_cell = table.find( 'td:eq(0)' );
		first_cell.append( '<span class="number">' + mapped_word_item.getNumber() + '</span>' );
		
		this.getElement().append( table );
		this.initEvents();
		
	};
	
	/**
	 * 
	 */
	this.initEvents = function() {
		
		var specialKeys = {
				8 	: 'backspace',
				37	: 'left',
				38	: 'up',
				39	: 'right',
				40	: 'down',
				35	: 'end',
				36	: 'home',
				46	: 'del'
		};
			
		$( this.getElement() ).find( 'input' )
			.bind('keypress', function(event){
				
				var charCode = event.charCode;
				var keyCode = event.keyCode;
				
				var letter_position = $( this ).data();
				var next_letter_position = new Point( letter_position.x, letter_position.y );
				
				if ( keyCode in specialKeys ) {
					switch( specialKeys[keyCode] ) {
						case 'backspace' :
							_this.setLetter( this, '' );
							next_letter_position.x -= 1;
							break;
						case 'left'	:
								next_letter_position.x -= 1;
							break;
						case 'right':
								next_letter_position.x += 1;
							break;
						case 'down'	:
								next_letter_position.y += 1;
							break;		
						case 'up'	:
								next_letter_position.y -= 1;
							break;		
						case 'end'	: break;
						case 'home' : break;
						case 'del'	:
							_this.setLetter( this, '' );
							break;
					}
					
					var next_element = $( getElementByPosition( next_letter_position ) ).focus();
					
					return false;
				}
				
				var letter = String.fromCharCode( charCode );
				
				if ( isAllowCharCode( charCode ) ) {//type
					_this.setLetter( this, letter );
					
					var right_point = next_letter_position.clone();
					right_point.x += 1;
					right_element = getElementByPosition( right_point );
					
					var bottom_point = next_letter_position.clone();
					bottom_point.y += 1;
					bottom_element = getElementByPosition( bottom_point );

					if ( right_element != null && bottom_element != null ) {
						next_element = active_direction == 'horizontal' ? right_element : bottom_element;
					} else {
						next_element = right_element != null ? right_element : bottom_element;
					}
					
					$( next_element ).focus();
					
					active_direction = _this.getWordItem().getDirection();
					
				} else {
					_this.getMessageHelper().showMessage( 'error', 'Letter not allowed' );
					return false;
				}
				return false;
		});		
	};
	
	
	this.setLetter = function( element, letter ) {
		$( element ).val( letter );
	};
	
	/**
	 * 
	 */
	this.getWord = function() {
		
		var word = '';
		
		for ( var i = 0; i < letters.length; i++ ) {
			var value = $( letters[i] ).val(); 
			word += value != '' ? value : ' ';
		}
		
		return word;
	};
}

MappedWordView.prototype = new AbstractWordView();