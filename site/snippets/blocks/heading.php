<?php /** @var \Kirby\Cms\Block $block */ ?>
<?php $level = $block->level()->or('h2') ?>
<?php $attrs = [
  'class' => $block->size()->value() ? 'heading--' . $block->size()->value() : null,
]; ?>
<<?php echo $level ?> <?php echo attr($attrs) ?>><?php echo $block->text() ?></<?php echo $level ?>>