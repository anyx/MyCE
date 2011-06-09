<?php use_helper( 'Text' ) ?>
<?php use_helper( 'Date' ) ?>

<h4><?= __('Created crosswords') ?></h4>

<? if ($crosswords->count() == 0): ?>
    <?= __('You not create crossword yet.') ?> <?= link_to('Whant now?', 'crossword/new') ?>
    <? return; ?>
<? endif; ?>

<? $solutions = $sf_data->getRaw('solutions') ?>

<table class="user-crosswords" cellspacing="0">
    <thead>
        <tr>
            <th class="text-left"><?= __('Title') ?>/<?= __('Description') ?></th>
            <th><?= __('Date create') ?></th>
            <th><?= __('Count solves') ?></th>
            <th><?= __('Is public') ?></th>
            <th><?= __('Is active') ?></th>
            <th><?= __('Manage') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $bOdd = false;?>
        <?php foreach ($crosswords as $crossword): ?>
        <?php $bOdd = !$bOdd;?>
            <tr class="<?=!$bOdd ? '' : 'odd'?>">
                <td>
                    <a href="<?php echo url_for('@constructor_resolve?id=' . $crossword->getId()) ?>" class="title" title="<?= __('Resolve') ?>">
                        <?php echo $crossword->getTitle() ?>
                    </a>
                    <div class="description">
                    <?php echo truncate_text( $crossword->getDescription(), 512 ) ?>
                    </div>
                </td>
                <td><?php echo format_date( $crossword->getCreatedAt() ) ?></td>
                <td class="text-center">
                    <? if (is_array($solutions) && array_key_exists($crossword->getId(), $solutions)): ?>
                        <span class="right-count"><?= $solutions[$crossword->getId()]['right'] ?></span> / <span class="wrong-count"><?= $solutions[$crossword->getId()]['wrong'] ?></span>
                    <? else: ?>
                        <?= __('Solutions not found') ?> 	 
                    <? endif; ?>
                </td>
                <td><?=$crossword->getIsPublic() ? __( 'yes' ) : __( 'no' ) ?></td>
                
                <td>
                <?php if ( $crossword->getIsActivated() ): ?>
                    <div class="active-icon" title="<?=__('active')?>"></div>
                <?php else: ?>    
                    <div class="inactive-icon" title="<?=__('inactive')?>"></div>
                <?php endif;?>
                </td>
                <td>
                    <a href="<?php echo url_for('crossword/edit?id=' . $crossword->getId()) ?>" title="<?= __('Edit') ?>">
                        <?= __('Edit') ?>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="<?php echo url_for('crossword/new') ?>">New</a>
