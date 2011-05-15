/**
 * Word in crossword
 * 
 * @param word
 * @param x
 * @param y
 * @param id
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
		return parseInt( data.id );
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
	this.getData = function() {
		return {
			id			: data.id,
			word		: data.text,
			definition	: data.definition,
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
	this.getEndPoint = function(){
		
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
}

/**
 * Crossword
 * 
 * @returns {Crossword}
 */
function Crossword() {

	var items = [];

	/**
	 *
	 */
	this.getItems = function() {
		return items;
	};
	
	/**
	 * 
	 */
	this.clear = function(){
		items = [];
	};

	/**
	 * 
	 */
	this.getItemsData = function() {
		var items_data = [];
		
		items = this.getItems();
		
		for( var i = 0; i < items.length; i++ ) {
			items_data[items_data.length] = items[i].getData(); 
		}
		
		return items_data; 
	};
	
	/**
	 *
	 * @param direction
	 * @param invert
	 */
	this.getItemsByDirection = function( direction, invert ) {
	   var parallel_items = [];

	   if ( invert == undefined ) {
		   invert = true;
	   }

	   for( var i = 0; i < items.length; i++ ) {

		   if ( invert ) {
			   if ( items[i].getDirection() != direction ) {
				   parallel_items[parallel_items.length] = items[i];
			   }
		   } else {
			   if ( items[i].getDirection() == direction ) {
				   parallel_items[parallel_items.length] = items[i];
			   }
		   }
	   }
	   return parallel_items;
	};


	/**
	 *
	 * @param word
	 * @param x
	 * @param y
	 */
	this.addItem = function( word_item ) {
		if( this.canAddItem( word_item ) ) {
			items[items.length] = word_item;
		}
		return this;
	};

	/**
	 * Удаление элемента в массиве
	 * 
	 * @param text
	 */
	this.removeItem = function( text ) {
		
		for ( var i = 0; i < items.length; i++ ) {
			if ( text == items[i].getText() ) {
				items.splice( i, 1 );
				return true;
			}
		}
		return false;
	};

	/**
	 *
	 * @param word_item
	 * @param x
	 * @param y
	 */
	this.isItemInCell = function( word_item, point ) {
		
		var position = word_item.getStartPoint();
		
		if ( word_item.isHorizontal() && position.x <= point.x && ( position.x + word_item.getLength() - 1 ) >= point.x && position.y == point.y ) {
			return true;
		}

		if ( !word_item.isHorizontal() && position.y <= point.y && ( position.y + word_item.getLength() - 1 ) >= point.y && position.x == point.x ) {
			return true;
		}

		return false;
	};

	/**
	 *
	 * @param x1
	 * @param y1
	 * @param x2
	 * @param y2
	 * @param direction
	 */
	this.getItemsInBlock = function( items_group, start_point, end_point ) {
		
		var result_items = [];
		for( var i = start_point.x; i <= end_point.x; i++ ) {
			for( var j = start_point.y; j <= end_point.y; j++ ) {
				for ( var k = 0; k < items_group.length; k++ ) {
					if ( this.isItemInCell( items_group[k], {x : i, y : j } ) && result_items.indexOf( items_group[k] ) == -1 ) {
						result_items[result_items.length] = items_group[k];
					}
				}
			}
		}
		return result_items;
	};

	/**
	 *
	 * @param items_group
	 * @param block_start
	 * @param block_end
	 */
	this.getHorizontalItemsByEndingBlock = function( items_group, block_start, block_end ) {
		var found_items = [];
		for (var i = 0; i < items_group.length; i++ ) {
			var position = items_group[i].getPosition();
			if ( position.y >= block_start.y && position.y <= block_end.y && ( position.x + items_group[i].getLength() - 1 ) == block_end.x ) {
				found_items[found_items.length] = items_group[i];
			}
		}
		return found_items;
	};

	/**
	 *
	 * @param items_group
	 * @param block_start
	 * @param block_end
	 */
	this.getHorizontalItemsByBeginningBlock = function( items_group, block_start, block_end ) {
		var found_items = [];
		for (var i = 0; i < items_group.length; i++ ) {
			var position = items_group[i].getPosition();
			if ( position.y >= block_start.y && position.y <= block_end.y && position.x == block_start.x ) {
				found_items[found_items.length] = items_group[i];
			}
		}
		return found_items;
	};

	/**
	 *
	 * @param items_group
	 * @param block_start
	 * @param block_end
	 */
	this.getVerticalItemsByBeginningBlock = function( items_group, block_start, block_end ) {
		var found_items = [];
		for (var i = 0; i < items_group.length; i++ ) {
			var position = items_group[i].getPosition();
			if ( position.x >= block_start.x && position.x <= block_end.x && position.y == block_start.y ) {
				found_items[found_items.length] = items_group[i];
			}
		}
		return found_items;
	};

	/**
	 *
	 * @param items_group
	 * @param block_start
	 * @param block_end
	 */
	this.getVerticalItemsByEndingBlock = function( items_group, block_start, block_end ) {
		var found_items = [];
		for (var i = 0; i < items_group.length; i++ ) {
			var position = items_group[i].getPosition();
			if ( position.x >= block_start.x && position.x <= block_end.x && position.y + ( items_group[i].getLength() - 1 ) == block_end.y ) {
				found_items[found_items.length] = items_group[i];
			}
		}
		return found_items;
	};


	/**
	 *
	 * @param word_item
	 */
	this.checkIntersections = function( word_item ) {
		
		var perpendicular_items = this.getItemsByDirection( word_item.getDirection(), true );
		var start_point = word_item.getStartPoint();
		var end_point = word_item.getEndPoint();
		
		for( var i = 0; i < perpendicular_items.length; i++ ) {
			
			var position = perpendicular_items[i].getPosition();
			
			var intersection = getLinesIntersection(
									start_point,
									end_point,
									perpendicular_items[i].getStartPoint(),
									perpendicular_items[i].getEndPoint()
								);
			

			if ( intersection != null ) {
				var items = this.getItems();
				items = items.concat( [ word_item ] );
				var intersected_words = this.getItemsInBlock( items, intersection, intersection );
				var sLetter1 = intersected_words[0].getLetter( intersection ); 
				var sLetter2 = intersected_words[1].getLetter( intersection );
				
				if ( sLetter1 !== sLetter2 ) {
					return false;
				}
			}
		}
		return true;
	};

	/**
	 * 
	 * @param word
	 */
	this.canAddItem = function( word_item ) {

		var parallel_items = this.getItemsByDirection( word_item.getDirection(), false );
		var perpendicular_items = this.getItemsByDirection( word_item.getDirection(), true );

		//parallel words
		if ( word_item.isHorizontal() ) {
			
			var block_start = word_item.getStartPoint();
			block_start.y--;
			
			var block_end = word_item.getEndPoint();
			block_end.y++;
			
			var found_items = this.getItemsInBlock( parallel_items, block_start, block_end );
			if ( found_items.length > 0 ) {
				return false;
			}
			
			var left_point = word_item.getStartPoint();
			left_point.x--;

			var right_point = word_item.getEndPoint();
			right_point.x++;

			for ( var i = 0; i < items.length; i++ ) {
				if ( this.isItemInCell( items[i], left_point ) || this.isItemInCell( items[i], right_point ) ) {
					return false;
				}
			}
			
			var top_area_start = word_item.getStartPoint();
			top_area_start.y--;			
			var top_area_end = word_item.getEndPoint();
			top_area_end.y--;

			var bottom_area_start = word_item.getStartPoint();
			bottom_area_start.y++;

			bottom_area_end = word_item.getEndPoint();
			bottom_area_end.y++;
			
			found_items = found_items.concat( this.getVerticalItemsByEndingBlock( perpendicular_items, top_area_start, top_area_end ) );

			found_items = found_items.concat( this.getVerticalItemsByBeginningBlock( perpendicular_items, bottom_area_start, bottom_area_end ) );

			if ( found_items.length > 0 ) {
				return false;
			}
			
		} else {
			
			var block_start = word_item.getStartPoint();
			block_start.x--;

			var block_end = word_item.getEndPoint();
			block_end.x++;

			var found_items = this.getItemsInBlock( parallel_items, block_start, block_end );
			if ( found_items.length > 0 ) {
				return false;
			}

			var top_cell = word_item.getStartPoint();
			top_cell.y--;

			var bottom_cell = word_item.getEndPoint();
			bottom_cell.y++;

			for ( var i = 0; i < items.length; i++ ) {
				if ( this.isItemInCell( items[i], top_cell ) || this.isItemInCell( items[i], bottom_cell ) ) {
					return false;
				}
			}

			var left_area_start = word_item.getStartPoint();
			left_area_start.x--;

			var left_area_end = word_item.getEndPoint();
			left_area_end.x--;

			var right_area_start = word_item.getStartPoint();
			right_area_start.x++;

			var right_area_end = word_item.getEndPoint();
			right_area_end.x++;
				
			found_items = found_items.concat( this.getHorizontalItemsByEndingBlock( perpendicular_items, left_area_start, left_area_end ) );
			found_items = found_items.concat( this.getHorizontalItemsByBeginningBlock( perpendicular_items, right_area_start, right_area_end ) );

			if ( found_items.length > 0 ) {
				return false;
			}
		}

		return this.checkIntersections( word_item );
	};
}