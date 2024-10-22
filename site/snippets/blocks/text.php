<?php
/** @var \Kirby\Cms\Block $block */
?>
<?php
$size = $block->size()->value();
$attrs = [
  'class' => $size ? 'text--' . $block->size()->value() : null,
];
$text = $block->text()->collectFootnotes();
if ($size) {
  $text = preg_replace('/<p>/', '<p ' . attr($attrs) . '>', $text);
}
echo $text;
