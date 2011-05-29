/**
 * Реестр
 */
var Registry = new function Registry() {
    
    /**
     *
     */
    var instance = this;


    /**
     *
     */
    var storage = {};
    
    /**
     *
     */
    Registry.getInstance = function() {
        return instance;
    }

    /**
     *
     */
    this.toString = function() {
        return "[object Registry]";
    }
 
    /**
     * 
     */
    this.get = function( param ) {
        
        var value = storage;
        
        var storage_path = param.split( '/' );
        
        for( var i = 0; i < storage_path.length; i++ ) {
            if ( storage_path[i] in value ) {
                value = value[storage_path[i]];
            } else {
               return null;
            }
        }
        return value;
    }
    
    
    Registry.get = this.get;
    
    /**
     * 
     */
    this.set = function ( param, value ) {
        
        var storage_path = param.split( '/' );

        var container = storage;

        for( var i = 0; i < storage_path.length - 1; i++ ) {
            if ( !( storage_path[i] in container ) ) {
                container[storage_path[i]] = {};
            }
            container = container[storage_path[i]];
        }
        
        container[storage_path.pop()] = value;
    }
    
    /**
     * 
     */
    this.getAll = function() {
        return storage;
    }
    
    return Registry;
}