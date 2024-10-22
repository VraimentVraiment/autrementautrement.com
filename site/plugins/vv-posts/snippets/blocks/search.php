<?php $queryNeeded = true; ?>
<?php extract(kirby()->controller('posts.json', compact('page', 'site', 'queryNeeded'))); ?>
<div class="search">
  <div class="search__header">
    <?php snippet('post-nav-back') ?>
    <div class="search__content" data-replacementtop="true" data-offset="24">
      <p class="search__info">Rechercher un terme dans le titre ou le contenu des articles</p>
      <form class="search__form" method="get">
        <input type="search" aria-label="Recherche" name="<?php echo $queryParam ?>" value="<?php echo html($query) ?>">
        <div class="search__submit">
          <input type="submit" value="Rechercher">
        </div>
      </form>
    </div>
  </div>
  <div class="search__results">
    <?php echo $searchResultCount ?>
    <div class="search__results-inner">
      <?php echo $postsList ?>
    </div>
  </div>
  <?php echo $pagination; ?>
</div>
<?php echo vite()->js("scripts/posts.js");?>