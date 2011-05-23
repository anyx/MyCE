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
    var text_field = $( options.textField );
	
    /**
     * 
     */
    var definition_field = $( options.definitionField );

    /**
     * 
     */
    var direction_field = $( options.directionField );

    /**
     * $var word_view
     */
    var binded_item = null;

    /**
     * 
     * @param options
     * @returns
     */
    var status_element = $( options.statusElement );
		
    /**
     * 
     */
    this.bind = function( word_view ) {
        binded_item = word_view;
        var word = word_view.getWordItem();
		
        text_field.val( word.text );
        definition_field.val( word.definition );
        direction_field.filter( '[value=' + word.getDirection() + ']' ).attr( 'checked', 'checked' );
    };

    /**
     * 
     */
    this.valid = function(){
		
        this.resetStatus();
		
        if ( $.trim( text_field.val() ).length < 2 ) {
            this.setStatus( 'error', 'Слишком короткое слово' );
            return false;
        }
		
        if ( $.trim( definition_field.val() ).length < 3 ) {
            this.setStatus( 'error', 'Слишком короткое определение слова' );
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
            'text'			: text_field.val(),
            'definition'	: definition_field.val()
        },
        {
            'direction'		: direction_field.filter(':checked').val() 
        }
        );
		
        return word_item;
    };
	
    /**
     * 
     */
    this.showWordItem = function() {
		
        if ( binded_item != null ) {
            var word_item = binded_item.getWordItem(); 
            word_item.setText( text_field.val() );
            word_item.setDirection( direction_field.filter(':checked').val() );
            word_item.setDefinition( definition_field.val() );
            binded_item = new WordView( word_item );
        } else {
            binded_item = new WordView( this.getWordItem() );
        }

        binded_item.getElement().appendTo( $( options.previewBox ).empty() );
		
        var box_length = $( options.previewBox ).width();
        var box_height = $( options.previewBox ).height();
		
        var element_width = binded_item.getElement().find( 'table' ).width();
        var element_height = binded_item.getElement().find( 'table' ).height();

        binded_item.getElement().css({
            'left'	: Math.round( box_length / 2 - element_width / 2 ) + 'px',
            'top'	: Math.round( box_height / 2 - element_height / 2 ) + 'px'
        });
			
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
     *
     *
     */
    this.setStatus = function( code, message ) {
        status_element
            .attr( 'class', code )
            .find( '.text' )
                .text( message )
    }

    /**
     *
     */
    this.resetStatus = function() {
        status_element
            .attr( 'class', options.defaultStatus )
            .find( '.text' )
                .text( options.defaultStatusText );
    }
    
    /**
     * 
     */
    this.initEvents = function() {
        
        this.resetStatus();
        
        $( text_field ).add( definition_field )
        .keyup(function(){
            if ( _this.valid() ) {
                _this.showWordItem();
            }
        })
        .add( direction_field )
        .change(function(){
            if ( _this.valid() ) {
                _this.showWordItem();
            }
        });
        
        status_element
            .find( '.icon' )
            .hover(
                function(){
                    status_element.find('.hint').show();
                },
                function(){
                    status_element.find('.hint').hide();
                }
        )
    };
	
    this.initEvents();
};