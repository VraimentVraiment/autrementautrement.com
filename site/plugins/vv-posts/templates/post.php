<?php snippet('post-container', slots: true,) ?>
<?php slot('post') ?>
    <?php snippet('post-header', $post) ?>
    <?php snippet('post-content', $post) ?>
    <?php snippet('post-footer', $post) ?>
  <?php endslot() ?>
<?php endsnippet();
