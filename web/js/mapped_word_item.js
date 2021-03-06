/**
 * 
 * @param data
 * @param position
 * @returns {MappedWord}
 */
function MappedWordItem( data, position ) {
	
	WordItem.call( this, data, position );
	
	/**
	 * 
	 */
	this.getLength = function() {
		return data.length;
	};
	
	this.getNumber = function() {
		return position.number;
	};
}

MappedWordItem.prototype = new WordItem;