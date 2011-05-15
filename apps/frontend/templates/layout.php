<!DOCTYPE html>
<html>
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>
  	<div class="b-layout">
  	
	  	<div class="user-panel">
	  		<?php
	  		$user = sfContext::getInstance()->getUser();
	  		?>
	  		<?if ( $user->isAuthenticated() ):?>
	  			<?php 
		  		$authService = $user->getAttribute( 'auth_service' );
	  			?>
	  			<?php $authUser = $user->getGuardUser()?>
	  			<?if ( !empty( $authService ) ):?>
	  				<img src="/images/services/small/<?=$authService?>.png" class="auth-icon" alt="<?=ucfirst($authService )?>" title="<?=__( 'Authorized with' )?> <?=ucfirst($authService )?>"/>
	  			<?endif;?>
	  			
	  			<?=link_to(
	  				$authUser->getName(),
	  			 	'profile',
	  				array(),
	  				array( 
	  					'title' => __( 'user profile' ),
	  					'class' => 'text-white' 
	  				));
	  			?>
	  			
	  			<span class="right">
	  			<?=link_to( 'logout', 'logout' )?>
	  			</span>
	  		<?else:?>
	  			<?=__( 'Guest' )?>
	  			<span class="right">
	  				<?=link_to( 'login', 'login' )?>
	  			</span>
	  			
	  		<?endif;?>
	  	</div>
	  	
	  	<div class="search-panel">
	  		<input type="text" name="serach" value="search..."/>
	  	</div>
	
		<h1 class="site-name"><?=__( 'My Crossword' )?></h1>
	  	
	  	<div class="menu-block">
	  		<ul class="menu">
	  			<li><a href="#">Create crossword</a></li>
	  			<li><a href="#">Most Popular</a></li>
	  			<li><a href="#">About</a></li>
	  		</ul>
	  	</div>
	  	<div style="clear:both"></div>
	  	<div class="content-block">

	  	<h2 class="title"><?include_slot('title')?></h2>
	  	
	    <?php echo $sf_content ?>
	    </div>
	</div>
  </body>
</html>