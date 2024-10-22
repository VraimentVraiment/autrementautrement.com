<?php

require __DIR__ . '/vendor/autoload.php';

$secrets = [];
if (file_exists(__DIR__ . '/kirby.secrets.php')) {
  $secrets = include __DIR__ . '/kirby.secrets.php';
}

return [

  'urls' => [
    'index'  => $base_url =  "https://" . $_SERVER['SERVER_NAME'],
    'assets' => $base_url . '/assets',
    'media'  => $base_url . '/media',
  ],

  'roots' => [
    'base'       => __DIR__,

    'content'    => __DIR__ . '/content',

    'site'       => $site = __DIR__ . '/site',
    'config'     => $site . '/config',
    'languages'  => $site . '/config/languages',
    'blueprints' => $site . '/blueprints',

    'index'      => $public  = __DIR__ . '/www',
    'assets'     => $public . '/assets',
    'media'      => $public . '/media',

    'storage'    => $storage = __DIR__ . '/storage',
    'accounts'   => $storage . '/accounts',
    'cache'      => $storage . '/cache',
    'sessions'   => $storage . '/sessions',
    'plugins'    => $storage . '/plugins',
  ],

  'options' => [

    "secrets" => $secrets,

    'afbora.loader.roots' => [
      $storage . '/plugins',
      $site . '/plugins'
    ],
  ]
];
