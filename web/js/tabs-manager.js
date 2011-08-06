jQuery.fn.tabsManager = function( options ) {
    
    var options = jQuery.extend({
        blockContainer  : '.block',
        tabContainer    : '.tabs-container',
        titleContainer  : '.block-title'
    }, options);
    
		
	var tabs = [];
	
    function hideAll() {
        $(options.blockContainer).hide();
    }
    
    this.find( options.blockContainer )
        .hide()
        .each(function(){
            
            var blockTitle = $(this).find( options.titleContainer ).hide();
			var block = this;
			
            var link = $('<a href="#" />')
				.addClass( 'tab' )
                .text( blockTitle.text() )
                .click(function() {
					
                    hideAll();
					showBlock( block );
					
                }).appendTo( $(options.tabContainer) );
				
				tabs[tabs.length] = {
					link : link,
					block : this
				}
        });
		
	function showBlock( block ) {
		
		$('.tab').removeClass( 'active' );

		for ( i = 0; i < tabs.length; i++ ) {
			if ( block == tabs[i].block ) {
				$(block).show();
				$( tabs[i].link ).addClass( 'active' ).blur();
				return true;
			}
		}
		
		return false;
	}
	
	showBlock( this.find( options.blockContainer ).filter( '.active' ).get(0) );
	
    return this;
}
