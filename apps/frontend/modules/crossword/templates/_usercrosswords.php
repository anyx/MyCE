<?php use_helper('Text') ?>
<?php use_helper('Date') ?>

<h4 class="subtitle"><?= __('Created crosswords') ?> (<?=count($pager)?>)</h4>

<? if ($pager->count() == 0): ?>
    <?= __('You not create crossword yet.') ?> <?= link_to('Whant now?', 'crossword/new') ?>
    <? return; ?>
<? endif; ?>

<? $solutions = $sf_data->getRaw('solutions') ?>
<?php if( !empty( $crosswords ) && $crosswords->count() > 0 ): ?>
<table class="user-crosswords table" cellspacing="0">
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
        <?php foreach ( $crosswords as $crossword ): ?>
            <tr>
                <td class="name-container">
                    <a href="<?php echo url_for('@crossword_resolve?id=' . $crossword->getId()) ?>" class="title" title="<?= __('Resolve') ?>">
                        <?php echo $crossword->getTitle() ?>
                    </a>
                    <div class="description">
                        <?php echo truncate_text($crossword->getDescription(), 512) ?>
                    </div>
                </td>
                <td class="text-center"><?php echo format_date($crossword->getCreatedAt()) ?></td>
                <td class="text-center">
                    <? if (is_array($solutions) && array_key_exists($crossword->getId(), $solutions)): ?>
                        <span class="right-count"><?= $solutions[$crossword->getId()]['right'] ?></span> / <span class="wrong-count"><?= $solutions[$crossword->getId()]['wrong'] ?></span>
                    <? else: ?>
                        <?= __('Solutions not found') ?> 	 
                    <? endif; ?>
                </td>
                <td class="text-center"><?= $crossword->getIsPublic() ? __('yes') : __('no') ?></td>
                <td>
                    <?php if ($crossword->getIsActivated()): ?>
                        <div class="active-icon" title="<?= __('active') ?>"></div>
                    <?php else: ?>    
                        <div class="inactive-icon" title="<?= __('inactive') ?>"></div>
                    <?php endif; ?>
                </td>
                <td class="text-center">
                    <a href="<?php echo url_for('crossword/edit?id=' . $crossword->getId()) ?>" title="<?= __('Edit') ?>">
                        <?= __('Edit') ?>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else:?>
<div class="info message"><?=__('Crosswords not found')?></div>
<?php endif;?>
<?php
$paramName = $page_param;

$showLink = function( $number ) use ( $paramName ) {
            return url_for('@profile') . '?' . $paramName . '=' . $number;
        }
?>

<?php if ( $pager->haveToPaginate() ): ?>
    <div class="pagination">
        
        <a href="<?= $showLink(1) ?>" title="<?= __('First page') ?>">&larrb;</a>
        <a href="<?= $showLink($pager->getPreviousPage()) ?>" title="Previous page">&DoubleLeftArrow;</a>

        <?php foreach ($pager->getLinks() as $page): ?>
            <?php if ($page == $pager->getPage()): ?>
                <span class="current-page"><?php echo $page ?></span>
            <?php else: ?>
                <a href="<?=$showLink( $page )?>"><?php echo $page ?></a>
            <?php endif; ?>
        <?php endforeach; ?>

        <a href="<?= $showLink($pager->getNextPage()) ?>" title="Next page" >&DoubleRightArrow;</a>
        <a href="<?= $showLink($pager->getLastPage()) ?>" title="Last page" >&rarrb;</a>
        
    </div>
<?php endif; ?>

<?php 
/*
  <?php if ($pager->haveToPaginate()): ?>
  - page <strong><?php echo $pager->getPage() ?>/<?php echo $pager->getLastPage() ?></strong>
  <?php endif; ?>
  </div>
 */ ?>

<a href="<?php echo url_for('crossword/new') ?>">New</a>