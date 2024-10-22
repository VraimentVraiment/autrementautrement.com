<!DOCTYPE html>
<html lang="<?php echo $kirby->language(); ?>" class="no-js">
<?php snippet('head'); ?>

<body class="static-menu-page">
  <?php snippet('header', ['from' => param('from')]); ?>
  <?php echo vite()->js("vite.entry.js");?>
  <?php snippet('matomo');?>
  <?php snippet('seo/schemas'); ?>
</body>

</html>
