<?php

/**
 * Script to clean up unused fields in page or file content files
 * Compares fields present in the content file
 * with fields defined in the blueprint
 * and removes all undefined fields
 * @tags
 * @phpcs:disable PSR1.Files.SideEffects
 */

$kirbyConfig = include __DIR__ . '/../kirby.config.php';

$kirby = new Kirby($kirbyConfig);

// Authenticate as almighty
$kirby->impersonate('kirby');

// Define your collection
// Don't use `$site->index()` for thousands of pages
$collection = $kirby->site()->index();

// set the fields to be ignored
$ignore = ['uuid', 'title', 'slug', 'template', 'sort'];

// call the script for all languages if multilang
if ($kirby->multilang() === true) {
  $languages = $kirby->languages();
  foreach ($languages as $language) {
    cleanUp($collection, $ignore, $language->code());
  }
} else {
  cleanUp($collection, $ignore);
}

function cleanUp($collection, $ignore = null, string $lang = null)
{
  foreach ($collection as $item) {
        // get all fields in the content file
    $contentFields = $item->content($lang)->fields();

        // unset all fields in the `$ignore` array
    foreach ($ignore as $field) {
      if (array_key_exists($field, $contentFields) === true) {
        unset($contentFields[$field]);
      }
    }

        // get the keys
    $contentFields = array_keys($contentFields);

        // get all field keys from blueprint
    $blueprintFields = array_keys($item->blueprint()->fields());

        // get all field keys that are in $contentFields but not in $blueprintFields
    $fieldsToBeDeleted = array_diff($contentFields, $blueprintFields);

        // update page only if there are any fields to be deleted
    if (count($fieldsToBeDeleted) > 0) {
            // flip keys and values and set new values to null
      $data = array_map(fn ($value) => null, array_flip($fieldsToBeDeleted));

            // try to update the page with the data
      try {
        $item->update($data, $lang);
        echo Html::tag('p', 'The content file for ' . $item->id() . ' was updated');
      } catch (Exception $e) {
        echo Html::tag('p', $item->id() . ': ' . $e->getMessage());
      }
    } else {
      echo Html::tag('p', 'Nothing to clean up in ' . $item->id());
    }
  }
}
