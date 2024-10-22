<?php

$type = get('type');

if ($type === 'schema') {
  page()->generateSchemaImg();
} elseif ($type === 'tw') {
  page()->generateTwImage();
} else {
  page()->generateOgImage();
}
