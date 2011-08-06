/**
 * 
 * @param options
 * @returns {WordForm}
 */
function WordForm( options ) {

	/**
     *
     */
	options = $.extend({
		onWordChange        : function( word_view ){},
		onBeforeWordChange  : function( word_view ){},
		hideTimeout         : 3000
	}, options); 
    
	/**
     * 
     */
	var _this = this;
	
	/**
     * 
     */
	var textField = $( options.textField );
	
	/**
     * 
     */
	var definitionField = $( options.definitionField );

	/**
     * 
     */
	var directionField = $( options.directionField );

	/**
     * $var wordView
     */
	var bindedItem = null;

	/**
     * 
     * @param options
     * @returns
     */
	var statusElement = $( options.statusElement );
		
	/**
     * 
     */
	this.bind = function( wordView ) {
        
		bindedItem = wordView;
		var word = wordView.getWordItem();
		
		textField.val( word.getText() );
		definitionField.val( word.getDefinition() );
		directionField.filter( '[value=' + word.getDirection() + ']' ).attr( 'checked', 'checked' );
	};

	/**
     * 
     */
	this.valid = function(){
		
		this.resetStatus();
		
		if ( $.trim( textField.val() ).length < 2 ) {
			this.setStatus( 'error', context.get( 'Lang/Constructor/wordLengthError' ) );
			return false;
		}
		
		if ( $.trim( definitionField.val() ).length < 3 ) {
			this.setStatus( 'error', context.get( 'Lang/Constructor/definitionLengthError' ) );
			return false;
		}

		/**
         * @todo special chars
         */
		return true;
	};

	/**
     * 
     */
	this.getWordItem = function() {
		
		var word_item = new WordItem(
		{
			'text'		: textField.val(),
			'definition'	: definitionField.val()
		},
		{
			'direction'	: directionField.filter(':checked').val() 
		}
		);
		
		return word_item;
	};
	
	/**
     * 
     */
	this.showWordItem = function() {
		
		if ( bindedItem != null ) {
			var word_item = bindedItem.getWordItem(); 
			word_item.setText( textField.val() );
			word_item.setDirection( directionField.filter(':checked').val() );
			word_item.setDefinition( definitionField.val() );
			bindedItem = new WordView( word_item );
		} else {
			bindedItem = new WordView( this.getWordItem() );
		}

		bindedItem.getElement().appendTo( $( options.previewBox ).empty() );
		
		var box_length = $( options.previewBox ).width();
		var box_height = $( options.previewBox ).height();
		
		var element_width = bindedItem.getElement().find( 'table' ).width();
		var element_height = bindedItem.getElement().find( 'table' ).height();

		bindedItem.getElement().css({
			'left'	: Math.round( box_length / 2 - element_width  / 2 ) + 'px',
			'top'	: Math.round( box_height / 2 - element_height / 2 ) + 'px'
		});
			
		return bindedItem;
	};
	
	/**
     * 
     */
	this.clear = function() {
		
		textField.val( '' );
		definitionField.val( '' );
		
		directionField
			.attr( 'checked', '' )
			.eq(0)
				.attr( 'checked', 'checked' )
				.change();
		
		bindedItem = null;
		
		this.resetStatus();
	};

	/**
     * Set and display form status
	 * 
	 * @param code
	 * @param message
	 * @param autoShow
	 * @param autoHide
     */
	this.setStatus = function( code, message, autoShow, autoHide ) {
        
		if ( typeof autoShow == 'undefined' ) {
			autoShow = false;
		}

		if ( typeof autoHide == 'undefined' ) {
			autoHide = false;
		}

		statusElement
		.attr( 'class', code )
		.find( '.text' )
			.text( message )
        
		statusElement.stop();
        
		var hintElement = statusElement.find( '.hint' );
        
		if ( autoShow ) {
			hintElement.show()
		}
        
		if ( autoHide ) {
            
			if ( hintElement.data( 'timer' ) > 0 ) {
				clearTimeout( hintElement.data( 'timer' ) );
			}
            
			hintElement.data( 'timer', setTimeout(function(){
				hintElement.fadeOut( 400, _this.resetStatus );
			}, options.hideTimeout));
		}
	}

	/**
     *
     */
	this.resetStatus = function() {
		statusElement
			.attr( 'class', options.defaultStatus )
			.find( '.text' )
				.text( options.defaultStatusText );
	}
    
	/**
     *
     */
	function _changeWord() {
		if ( _this.valid() ) {
			options.onWordChange.call( _this, _this.showWordItem() );
		}
	}
    
	/**
     * 
     */
	this.initEvents = function() {
        
		this.resetStatus();
        
		$( textField )
			.add( definitionField )
			.keyup( _changeWord )
			.add( directionField )
			.change( _changeWord )
			.keydown( function(){
				options.onBeforeWordChange.call( this, _this.getWordItem() )
			}); 
            
		statusElement
			.find( '.icon' )
			.hover(
				function(){
					statusElement.find('.hint').show();
				},
				function(){
					statusElement.find('.hint').hide();
				}
			)
	};
	
	this.initEvents();
}