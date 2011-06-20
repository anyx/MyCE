jQuery.fn.tabsManager = function( options ) {
    
    var options = jQuery.extend({
        blockContainer  : '.block',
        tabContainer    : '.tabs-container',
        titleContainer  : '.block-title'
    }, options);
    
    var menuLinks = [];
    
    function hideAll() {
        $(options.blockContainer).hide();
    }
    
    
    this.find( options.blockContainer )
        .hide()
        .each(function(){
            
            var blockTitle = $(this).find( options.titleContainer );
            
            $('<a href="#"/>')
                .text( blockTitle )
                .click(function(){
                    hideAll();
                })
            
        })
        ;
    
    return this;
}
