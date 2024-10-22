<?php $startOpen ??= false; ?>
<div
<?php
echo attr([
  'class' => 'collapsible' . ($startOpen ? ' collapsible--expanded' : ''),
])?>
>
  <button type="button" class="collapsible__summary">
    <div class="collapsible__summary-content">
      <?php if ($summary = $slots->summary()) : ?>
        <?php echo $summary ?>
      <?php endif ?>
    </div>
    <div class="collapsible__summary-icon">
      <span class="i-ri-arrow-down-s-line"></span>
    </div>
  </button>
  <div class="collapsible__content">
    <?php if ($content = $slots->content()) : ?>
      <?php echo $content ?>
    <?php endif ?>
  </div>
</div>
