/**
 *
 * @param a1
 * @param a2
 * @param b1
 * @param b2
 */
getLinesIntersection = function( a1, a2, b1, b2 ) {

    var da = ( a1.x - b1.x ) * ( b2.y - b1.y ) - ( a1.y - b1.y ) * ( b2.x - b1.x );
    var db = ( a1.x - a2.x ) * ( a1.y - b1.y ) - ( a1.y - a2.y ) * ( a1.x - b1.x );
    var d  = ( a1.x - a2.x ) * ( b2.y - b1.y ) - ( a1.y - a2.y ) * ( b2.x - b1.x );

    if ( Math.abs( d ) > 0,001 ) {
        var ta = da / d;
        var tb = db / d;
        if ( ( 0 <= ta ) && ( ta <= 1 ) && ( 0 <= tb ) && ( tb <= 1 ) ) {
            return new Point( a1.x + ta * ( a2.x - a1.x ), a1.y + ta * ( a2.y - a1.y ) ); 
        }
    }
    return null;
};