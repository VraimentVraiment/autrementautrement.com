<?php

$kirbyConfig = include __DIR__ . '/../kirby.config.php';

$kirby = new Kirby($kirbyConfig);

echo $kirby->render();
