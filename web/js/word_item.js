/**
 * Word in crossword
 * 
 * @param data
 * @param position
 * 
 * @returns {WordItem}
 */
function WordItem( data, position ) {

	/**
     * 
     */
	var intersections = [];

	/**
     * 
     */
	this.getLength = function() {
		return data.text.length;
	};
	
	/**
     * 
     */
	this.getPosition = function() {
		return position;
	};
	
	/**
     * 
     */
	this.setStartPoint = function( start_point ) {
		position.x = parseInt( start_point.x );
		position.y = parseInt( start_point.y );
	};

	/**
     * 
     */
	this.setDirection = function( direction ) {
		position.direction = direction == 'horizontal' ? 'horizontal' : 'vertical'; 
	};
	
	/**
     * 
     */
	this.getId = function() {
		if ( 'id' in data ) {
			return parseInt( data.id );
		}
		return 0;
	};
	
	/**
     * 
     */
	this.getDirection = function() {
		return position.direction;
	};

	/**
     * 
     */
	this.getDefinition = function() {
		return data.definition;
	};

	/**
     * 
     */
	this.setDefinition = function( definition ) {
		data.definition = definition;
	};
	
	/**
     * 
     */
	this.isHorizontal = function() {
		return position.direction == 'horizontal';
	};
	
	/**
     * 
     */
	this.addIntersection = function( point, word_item ) {
		intersections[intersections.length] = {
			point	: point,
			item	: word_item
		};
	};
	
	/**
     * 
     */
	this.hasIntersections = function() {
		return intersections.length > 0;
	};
	
	/**
     * 
     */
	this.getIntersections = function() {
		return intersections;
	};
	
	/**
     * 
     */
	this.getText = function() { 
		return data.text;
	};
	
	/**
     * 
     */
	this.setText = function( text ) { 
		data.text = text;
	};
	
	/**
     * 
     */
	this.getData = function() {
		return {
			id			: this.getId(),
			text		: this.getText(),
			definition	: this.getDefinition(),
			direction	: this.getDirection(),
			x			: position.x,
			y			: position.y
		};
	};
	
	/**
     * @return { x: x, y: y };
     */
	this.getStartPoint = function() {
		return new Point( position.x, position.y );
	};
	
	/**
     * @return { x: x, y: y };
     */
	this.getEndPoint = function() {
		
		if ( this.isHorizontal() ) {
			return new Point( position.x + parseInt( this.getLength() - 1 ), position.y );
		} else {
			return new Point( position.x, position.y + parseInt( this.getLength() - 1 ) );
		}
	};
	
	/**
     * Get word letterin point 
     */
	this.getLetter = function( point ) {
		if ( this.isHorizontal() ) {
			return data.text[point.x - position.x]; 
		} else {
			return data.text[point.y - position.y]; 
		}
	};
	
	if ( position ) {
		this.setStartPoint( position );
	}
    
	/**
     *
     * @param word_item
     * @return bool
     */
	this.equal = function( word_item ) {
		return word_item.getText() == this.getText();
	}
}	