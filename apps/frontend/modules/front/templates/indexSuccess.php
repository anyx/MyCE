<h2 class="welcome"><?=__('Welcome!')?></h2>

<div class="icon-cat"></div>

<div class="block-on-main">
	<h3 class="big-text"><?=__('Crosswords online') ?></h3>
	<span class="slogan"><?=__('Welcome to the MyCrossords! This is online crossword editor. Now you can:')?></span>
	<ul class="variants">
		<li>
			<?=link_to( 'Create', 'crossword/new' )?> <?=__('crosswords')?>
		</li>
		<li>
			<?=link_to( 'Solve', 'crossword/list' )?> <?=__('friends crosswords')?>
		</li>
		<li><?=__('Share self solutions')?></li>
	</ul>
</div>


<div class="main-crosswords">
	
	<div class="main-block">
		<h4><?=__( 'Popular crosswords' )?></h4>
		<?php include_component('crossword', 'popularcrosswords', array( 'count' => 5 )) ?>  
	</div>
	
	<div class="main-block">
		<h4><?=__( 'New' )?></h4>
		 <?php include_component('crossword', 'newcrosswords', array( 'count' => 5 )) ?>   
	</div>
	
	<div class="main-block">
		<h4><?=__( 'Tags' )?></h4>
	</div>
</div>
