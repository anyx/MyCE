<?php slot('title') ?>
 <?= __( 'Crosswords by tag ' )?> &laquo;<?=$tag->getName()?>&raquo;
<?php end_slot()?>

<?if ( !empty( $crossowords ) ):?>
Not found
<?php return;?>
<?endif;?>

<div class="right-panel">
<?php include_component('fzTag', 'canvasTagCloud',
                    array(
                        'limit' => 25,
                        'height' => 300,
                        'width' => 300,
                        'maxSpeed' => 0.02,
                        'minSpeed' => 0.00,
                        'decel' => 0.95,
                        'minBrightness' => 0.1,
                        'textColour' => "#000000",
                        'textHeight' => 15,
                        'textFont' => "Helvetica, Arial, sans-serif",
                        'outlineColour' => "#000000",
                        'outlineThickness' => 1,
                        'outlineOffset' => 5,
                        'pulsateTo' => 1.0,
                        'pulsateTime' => 3,
                        'depth' => 0.5,
                        'initial' => null,
                        'freezeActive' => false,
                        'reverse' => false,
                        'hideTags' => true,
                        'zoom' => 1.0,
                        'shadow' => "#000000",
                        'shadowBlur' => 0,
                        'shadowOffset' => '[0,0]',
                        'weight' => true,
                        'weightMode' => "size",
                        'weightSize' => 1.0,
                        'weightGradient' => array('0' => '#f00', '0.33' => '#ff0', '0.66' => '#0f0', '1' =>'#00f'),
                        ));  ?>
</div>

<dl class="tag-list">
<?foreach ( $crosswords as $crossword ):?>
	<dt><?= link_to( $crossword, 'crossword_resolve', array( 'id' => $crossword->getId() ) )?></dt>
	<dd><?=$crossword->getDescription()?></dd>
<?endforeach;?>
</dl>                