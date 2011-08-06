<?php
if ( empty( $crosswords ) ) {
	return false;
}
?>
<ul>
<?foreach( $crosswords as $crossword ):?>
	<li><?=link_to( $crossword->getTitle(),'@crossword_resolve?id=' . $crossword->getId() )?></li> 
<?endforeach?>
</ul>