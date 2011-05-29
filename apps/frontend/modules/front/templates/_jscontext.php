<?php
$configuration = sfContext::getInstance()->getConfiguration();
?>
<script type="text/javascript">
    var context = Registry.getInstance();
    
    context.set( 'Site/Path', '<?=$configuration->getEnvironment() == 'dev' ? 'frontend_dev.php/' : '' ?>');
<?  
  $routeName = sfContext::getInstance()->getRouting()->getCurrentRouteName();
  $aRoutes = sfContext::getInstance()->getRouting()->getRoutes();
  $currentRoute  = $aRoutes[$routeName];
  
  $routeParams = $currentRoute->getParameters();
  unset( $routeParams['module'], $routeParams['action'] );
  
  if ( !empty ( $routeParams ) ) {
      foreach ( $routeParams as $param => $value ) {
      ?>
          context.set( 'Page/Params', <?=json_encode( $routeParams )?> );
      <?
      }
  }
?>
</script>
