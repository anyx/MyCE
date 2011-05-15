/**
 * 
 * @param options
 * @returns {MessagesHelper}
 * 
 * options = {
 * 		timeout: 200,
 *		effect		: ?? , // @todo,
 *		speed		: 200, // @todo
 * 		types : {
 * 			error : {
 * 				selector 	: '.error-place',
 * 				timeout		: 300,
 * 				effect		: ?? , // @todo,
 * 				speed		: 200, // @todo
 * 			},
 * 			message : {
 * 				//
 * 			}
 * 		}
 * }
 * 
 * 
 */
function MessagesHelper( options ) {

	var _this = this;
	
	/**
	 * 
	 */
	var timeout = 'timeout' in options ? options.timeout : 3000;
	
	/**
	 * 
	 */
	var timers = {};
	
	/**
	 * 
	 */
	this.showMessage = function( type, message ) {
		
		this.clear( type );
		
		var hide_timeout = 'timeout' in options.types[type] ? options.types[type].timeout : timeout; 
		
		var message_element = $( options.types[type].selector ).text( message ).show();
		
		timers[type] = setTimeout( function(){
			_this.hideElement( message_element );
		}, hide_timeout );
	};
	
	/**
	 * 
	 */
	this.hideElement = function( element ) {
		$( element ).fadeOut();
	};
	
	/**
	 * 
	 */
	this.clear = function( type ) {
		clearTimeout( timers[type] );
		$( options.types[type].selector ).text( '' ).hide();
	};
}