/**
 * Point. No Comments
 * 
 * @param x
 * @param y
 * @returns {Point}
 */
function Point( x, y ) {
	
	this.x = x;
	
	this.y = y;
	
	/**
	 * 
	 */
	this.equal = function( point ) {
		return point.x == this.x && point.y == this.y;
	};
	
	this.clone = function(){
		return new this.constructor( this.x, this.y );
	};
}