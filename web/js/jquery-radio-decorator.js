jQuery.fn.radioDecorator = function( options ) {
	
	var decorator = $( this ); 
	
	 var defaults = {
		'onSelect'	: function( value, event ){}	 
	 };
	
	 var inputs = $( 'input[type=radio]' );
	 
	 var settings = $.extend( {}, defaults, options );
	 
	 $( inputs ).hide();
	 
	 $( this )
	 	.addClass( 'radio-decorator' );
	 
	 inputs.each(function(){
		 
		var input = $( this );
		
		var inputId = input.attr( 'id' ); 
		
		var inputDecorator = $( '<div />' )
								.addClass( 'decorator-button' )
								.click(function(){
									input.attr( 'checked', 'checked' ).change();
									
									$( '.decorator-button' )
										.removeClass( 'selected' );
									
									$( this ).addClass( 'selected' );
								})
								.hover(
									function() {
										$( this ).addClass( 'hover' );
									},
									function() {
										$( this ).removeClass( 'hover' );
									}
								);

		if ( input.attr( 'checked' ) ) {
			$( '.decorator-button' )
				.removeClass( 'selected' );
				inputDecorator.addClass( 'selected' );
		}
		
		if ( inputId ) {
			label = $( 'label[for=' + inputId + ']' );
			if ( label.length > 0 ) {
				inputDecorator.text( label.text() );
				label.hide();
			}
		}
		
		decorator.append( inputDecorator );
	 });
	 
	 return this;
};