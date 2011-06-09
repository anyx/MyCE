<?php slot('title') ?>
<?= __('Construct crossword') ?> &laquo;<?= $crossword->getTitle(); ?>&raquo;
<?php end_slot(); ?>

<p>
    <?= __('Just add type word, select diraction and drag him to the crossword area') ?>
</p>


<div class="constructor">
    <div class="right-panel">
        <div class="words-panel">
            
            <div id="form-status" class="info">
                <div class="hint">
                    <span class="text"></span>
                    <div class="angle"></div>
                </div>
                <i class="icon"></i>
            </div>
            
            <form class="word-form">
                <dl class="form">

                    <dt>
                    <label for="word"><?= __('Word') ?></label>
                    <input type="button" value="<?=__('Clear')?>" class="clear-button" />
                    </dt>
                    <dd class="form-item text">
                        <input type="text" name="word" maxlength="255" id="word" />
                    </dd>

                    <dt>
                    <label for="word-definition"><?= __('Definition') ?></label>
                    </dt>
                    <dd class="form-item text">
                        <textarea name="word-definition" id="word-definition"></textarea>
                    </dd>
                </dl>

                <div title="<?= __('Direction') ?>" class="direction-selector">
                    <input type="radio" name="direction" value="horizontal" id="direction-horizontal" checked="checked"/>
                    <label for="direction-horizontal"><?= __('Horizontal') ?></label>

                    <input type="radio" name="direction" value="vertical" id="direction-vertical"/>
                    <label for="direction-vertical"><?= __('Vertical') ?></label>
                </div>

            </form>

            <div class="word-preview">
            </div>
        </div>

        <input type="button" value="<?=__("Save Crossword")?>" id="save-button" class="save-button" />
    </div>

    <div class="d-crossword-area">
    </div>
    <script type="text/javascript">
	
        $(function(){
        <? if (count($word_items) > 0): ?>
            <? foreach ($word_items as $word_item): ?>
                var word_item = new WordItem(
                {
                    text	: "<?= $word_item['word'] ?>",
                    definition	: "<?= $word_item['definition'] ?>",
                    id		: <?= $word_item['id'] ?>
                },
                {
                    x 		: <?= $word_item['x'] ?>,
                    y           : <?= $word_item['y'] ?>,
                    direction	: "<?= $word_item->isHorizontal() ? 'horizontal' : 'vertical' ?>"
                }
            );
            context.get( 'Constructor/CrosswordArea').getCrossword().addItem( word_item );
            <? endforeach; ?>
        <? endif; ?>
        context.get( 'Constructor/CrosswordArea').showCrossword();
    });
    
    <?slot('after_context')?>
        context.set( 'Lang/Constructor', {
            successSave           : "<?=__( 'Crossword saved successfully' )?>",
            wordLengthError       : "<?=__( 'Word\'s length is too short' )?>",
            definitionLengthError : "<?=__( 'Word\'s definition length is too short' )?>",
            infoMessage           : "<?=__( 'In this place you can see current constructor status' )?>"
        });
    <? end_slot()?>

    </script>
</div>