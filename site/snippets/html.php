<!DOCTYPE html>
<html lang="<?php echo $kirby->language(); ?>" class="no-js">
<?php snippet('head'); ?>

<body class="site-body <?php echo ($contrast ?? false) ? 'site-body--contrast' : ''; ?>">
  <?php snippet('header', ['contrast' => $contrast ?? false]); ?>
  <main <?php
  echo attr([
    'class' => ($page->isHomePage() ? 'main__home' : '') . ' main__' . $page->template(),
  ]);
  ?>>
    <?php if ($main = $slots->main()) : ?>
      <?php echo $main ?>
    <?php endif ?>
  </main>
  <footer class="site-footer">
    <div class="site-footer__inner">
      <?php if ($footer = $slots->footer()) : ?>
        <?php echo $footer ?>
      <?php endif ?>
    </div>
  </footer>
  <?php echo vite()->js("vite.entry.js");?>
  <?php echo vite()->js('scripts/pages/' . $page->id() . '/index.js', try: true);?>
  <?php snippet('matomo');?>
  <?php snippet('seo/schemas'); ?>
</body>

</html>
