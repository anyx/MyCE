<?php 
if ( empty( $crosswords ) ) {
	return false;
}
?>
<ul>
<?foreach( $crosswords as $crossword ):?>
	<li><?=link_to( $crossword->getTitle(),'@constructor_resolve?id=' . $crossword->getId() )?></li> 
<?endforeach?>
</ul>