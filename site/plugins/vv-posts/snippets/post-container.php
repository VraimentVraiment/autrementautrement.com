<?php snippet('html', ['contrast' => true], slots: true,) ?>
  <?php slot('main') ?>
  <div class="post">
    <?php if ($post = $slots->post()) : ?>
      <?php echo $post ?>
    <?php endif ?>
  </div>
  <?php endslot() ?>
  <?php slot('footer') ?>
    <?php snippet('layouts', ['layouts' => $site->footer()->toLayouts()]); ?>
    <?php echo vite()->js("scripts/post.js");?>
  <?php endslot() ?>
<?php endsnippet();
