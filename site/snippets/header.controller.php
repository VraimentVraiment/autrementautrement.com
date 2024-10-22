<?php

use Kirby\Http\Params;

return function ($page, $site, $kirby, $from, $contrast) {

  $contrast ??= false;

  $isHomePage = $page->isHomePage();
  $logoTag = Html::a(
      $site->url(),
      [svg('assets/aa-logo.svg')],
      [
        'class' => 'site-logo',
        'aria-current' => $isHomePage ? 'page' : null,
        "tabindex" => $isHomePage ? '-1' : '0',
        'aria-label' => 'Retour à l\'accueil',
      ]
  );

  $menuIconClosed = svg('assets/menu-menu.svg');
  $menuIconOpen = "<div class='i-ri-close-fill'></div>";

  if (isset($from)) {
    $menuHref = $from;
  } else {
    $params = new Params([
      'from' => $page->url(),
    ]);
    $menuHref = '/menu/' . $params->toString();
  }

  $navTogglerAttrs = attr([
    'href' => $menuHref,
    'id' => 'nav-toggler',
    'aria-label' => 'Ouvrir le menu de navigation',
    'aria-haspopup' => 'true',
    'aria-controls' => 'main-nav',
    'tabindex' => '0',
  ]);

  return compact([
    'contrast',
    'menuHref',
    'navTogglerAttrs',
    'isHomePage',
    'logoTag',
    'menuIconClosed',
    'menuIconOpen',
  ]);
};
