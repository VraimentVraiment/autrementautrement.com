<?php

/** phpcs:disable PSR1.Files.SideEffects.FoundWithSymbols */

use Kirby\Uuid\Uuid;

$urlsMap = json_decode(F::read(__DIR__ . '/old-urls-map.json'), true);

return [

  'smartypants' => true,
  'sylvainjule.footnotes.back'  => '<span></span>',

  'routes' => [
    [
      'pattern' => 'publications',
      'action'  => function () {
        return go('/#publications');
      }
    ],
    [
      'pattern' => 'articles',
      'action'  => function () {
        return go('/#publications');
      }
    ],
    [
      'pattern' => 'menu',
      'action'  => function () {
          return Page::factory([
            'slug' => 'static-menu',
            'template' => 'static-menu',
            'model' => 'static-menu',
            'content' => [
              'title' => 'Menu statique',
              'uuid'  => Uuid::generate(),
            ]
          ]);
      }
    ],
    /**
     * Redirect old URLs to new ones
     */
    ...A::map($urlsMap, function ($record) {
      return [
        'pattern' => $record["old"],
        'action'  => function () use ($record) {
          return go($record["new"]);
        }
      ];
    }),
  ],

  'date.handler' => 'intl',
  'locale' => 'fr_FR.utf-8',

  'shallowred.html-sitemap.ignore' => [
    "error",
  ],

  'languages' => true,
  'languages.detect' => true,

  'tobimori.seo.canonicalBase' => 'https://autrementautrement.com',
  'tobimori.seo.lang' => 'fr_FR',

  'shallowred.navigation-menus' => [
    'menus' => [
      'primary' => [
        'name' => 'primaryNavigation',
        'label' => 'Menu de navigation principal',
        'id' => 'main-nav',
        'ariaLabel' => 'Menu principal',
      ],
      'secondary' => [
        'name' => 'secondaryNavigation',
        'label' => 'Menu de navigation secondaire',
        'id' => 'sec-nav',
        'ariaLabel' => 'Menu secondaire',
      ],
    ]
  ],

  'timnarr.imagex' => [
    'cache' => true,
    'customLazyloading' => false,
    'formats' => ['avif', 'webp'],
    'includeInitialFormat' => false,
    'noSrcsetInImg' => false,
    'relativeUrls' => false,
  ],

  "afbora.kirby-minify-html" => [
    "enabled" => true,
    "options" => [
      "doRemoveOmittedQuotes" => false,
      "doRemoveOmittedHtmlTags" => false
    ]
  ],

  'thumbs' => [
    'srcsets' => [
      'default' => [ // preset for jpeg and png
        '400w'  => ['width' =>  400, 'crop' => true, 'quality' => 80],
        '800w'  => ['width' =>  800, 'crop' => true, 'quality' => 80],
        '1200w' => ['width' => 1200, 'crop' => true, 'quality' => 80],
      ],
      'default-webp' => [ // preset for webp
        '400w'  => ['width' =>  400, 'crop' => true, 'quality' => 75, 'format' => 'webp', 'sharpen' => 10],
        '800w'  => ['width' =>  800, 'crop' => true, 'quality' => 75, 'format' => 'webp', 'sharpen' => 10],
        '1200w' => ['width' => 1200, 'crop' => true, 'quality' => 75, 'format' => 'webp', 'sharpen' => 10],
      ],
      'default-avif' => [ // preset for avif
        '400w'  => ['width' =>  400, 'crop' => true, 'quality' => 65, 'format' => 'avif', 'sharpen' => 25],
        '800w'  => ['width' =>  800, 'crop' => true, 'quality' => 65, 'format' => 'avif', 'sharpen' => 25],
        '1200w' => ['width' => 1200, 'crop' => true, 'quality' => 65, 'format' => 'avif', 'sharpen' => 25],
      ],
    ],
  ],

  'ready' => function () {

      return [
        'sylvainjule.matomo' => option('secrets.sylvainjule.matomo'),
        'sylvainjule.matomo.area.label' => 'Audience'
      ];
  },
];
