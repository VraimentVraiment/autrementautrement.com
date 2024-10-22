<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php snippet('seo/head'); ?>
  <link rel="sitemap" type="application/xml" title="Sitemap" href="<?php echo $site->url() . "/sitemap.xml"; ?>">
  <link rel="icon" href="<?php echo $kirby->url("assets") . "/favicon.svg"; ?>">
  <?php echo vite()->css("vite.entry.js"); ?>
</head>
