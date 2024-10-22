<?php snippet('html', slots: true) ?>
  <?php slot('main') ?>
    <?php snippet('layouts', ['layouts' => $page->layout()->toLayouts()]); ?>
  <?php endslot() ?>
  <?php slot('footer') ?>
    <?php snippet('layouts', ['layouts' => $site->footer()->toLayouts()]); ?>
  <?php endslot() ?>
<?php endsnippet();