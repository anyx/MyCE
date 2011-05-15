<?slot( 'title' )?>
	<?=__( 'Authorization' )?>
<?end_slot();?>

<p>
	<?=__( 'If you have account in social services, you can use it to log in.' )?>
</p>

<p class="text-center">
	<?=__( 'Select service:' )?>
</p>

<ul class="list-services">
<?foreach ( $availableServices as $service ):?>
	<li class="service <?=$service?>">
		<a href="<?=url_for( '@auth_oauth?service=' . $service )?>">
			<img src="/images/services/big/<?=$service?>.png" title="<?=ucfirst( $service )?>"  alt="<?=ucfirst( $service )?>" />
			<span class="service-name"><?=__( $service )?></span>
		</a>
	</li>
<?endforeach;?>
</ul>

<div class="clear"></div>
<p>
<?=__( 'Also, you can ' )?> <?=link_to( 'register', 'register' )?> <?=__( 'to site' )?>.
</p>