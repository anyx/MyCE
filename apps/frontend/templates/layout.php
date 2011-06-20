<!DOCTYPE html>
<html>
    <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>
        <link rel="shortcut icon" href="/favicon.ico" />
        <?php include_stylesheets() ?>
        <?php include_javascripts() ?>

        <?php include_component('front', 'jscontext', array()); ?>
        <script type="text/javascript">
            
        <?php include_slot('after_context') ?>
            
        </script>
    </head>
    <body>
        <div class="top-panel-wrapper">	
            <div class="top-panel b-layout">
                <div class="user-panel">
                    <?php
                    $user = sfContext::getInstance()->getUser();
                    ?>
                    <? if ($user->isAuthenticated()): ?>
                        <?php
                        $authService = $user->getAttribute('auth_service');
                        ?>
                        <?php $authUser = $user->getGuardUser() ?>
                        <? if (!empty($authService)): ?>
                            <img src="/images/services/small/<?= $authService ?>.png" class="auth-icon" alt="<?= ucfirst($authService) ?>" title="<?= __('Authorized with') ?> <?= ucfirst($authService) ?>"/>
                        <? endif; ?>

                        <?=link_to(
                                $authUser->getName(),
                                'profile',
                                array(),
                                array(
                                'title' => __('user profile'),
                                'class' => 'text-white'
                                )
                        );?>

                        <span class="right">
                            <?= link_to('logout', 'logout') ?>
                        </span>
                            
                    <? else: ?>
                            
                        <?= __('Guest') ?>
                        <span class="right">
                        <?= link_to('login', 'login') ?>
                        </span>
                            
                    <? endif; ?>
                </div>

                <div class="search-panel">
                    <input type="text" name="serach" value="search..."/>
                </div>

            </div>
        </div>

        <div class="b-layout">

            <div class="heading">
                <h1 class="site-name"><a href="<?= url_for('homepage') ?>"><?= __('My Crossword') ?></a></h1>

                <div class="menu-block">
                    <ul class="menu">
                        <li><a href="#">Create crossword</a></li>
                        <li><a href="#">Most Popular</a></li>
                        <li><a href="#">About</a></li>
                    </ul>
                </div>
            </div>

            <div class="content-block">

                <?php if ( has_slot( 'help_panel' ) ):?>
                    <div class="helpPanel">
                        <?php include_slot( 'help_panel' ); ?>
                    </div>
                <?php endif;?>
                
                <div class="content <?=!has_slot( 'help_panel' ) ? : 'with-help' ;?>">

                <h2 class="title"><? include_slot('title') ?></h2>
                
                <?php if ( $sf_user->hasFlash( 'notice' ) ): ?>
                  <div class="flash notice"><?php echo $sf_user->getFlash( 'notice' ) ?></div>
                <?php endif; ?>

                <?php if ( $sf_user->hasFlash('error') ): ?>
                  <div class="flash error"><?php echo $sf_user->getFlash( 'error') ?></div>
                <?php endif; ?>
                
                <?php echo $sf_content ?>
                </div>
            </div>
            
            <div class="footer">
                
            </div>
        </div>
    </body>
</html>