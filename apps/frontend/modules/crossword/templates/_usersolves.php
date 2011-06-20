<h4 class="subtitle"><?= __('Solved crosswords') ?> (<?= count($pager) ?>)</h4>

<? if ($pager->count() == 0): ?>
    <?= __('You not solve crossword yet.') ?> <?= link_to('Whant now?', '@crosswords') ?>
    <? return; ?>
<? endif; ?>

<?
$findCrosswordById = function( $id ) use ( $crosswords ) {
        foreach ($crosswords as $crossword) {
            if ($crossword->getId() == $id) {
                return $crossword;
            }
        }

        return false;
}
?>

<?php if (!empty($pager) && $pager->count() > 0): ?>
    <table class="user-answers table" cellspacing="0">
        <thead>
            <tr>
                <th class="text-left"><?= __('Title') ?></th>
                <th><?= __('Date solve') ?></th>
                <th><?= __('Right') ?></th>
                <th><?= __('View') ?></th>
            </tr>
        </thead>
        <tbody>
    <?php foreach ($pager as $answer): ?>    
    <?
    $crossword = $findCrosswordById( $answer->getCrosswordId() );
    if ( !empty( $crossword ) ):
    ?>
                <tr>
                    <td><?=$crossword->getTitle();?></td>
                    <td><?=format_date($answer->getUpdatedAt()) ?></td>
                    <td><?=$answer->isCorrect() ? __('correct') : __('not correct') ?></td>
                    <td><?=link_to( 'resolve', '@crossword_resolve?id='.$crossword->getId())?></td>
                </tr>
   <? else:?>
   <? endif;?>             
    <?php endforeach; ?>    
        </tbody>    
    </table>
<?php endif; ?>