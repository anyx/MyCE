<?slot( 'title' )?>
<?=__( 'Profile user' )?> <?=$user->getName()?>
<?end_slot();?>

<?include_component('crossword', 'usercrosswords', array( 'user_id' => $user->getId() )) ?>   
