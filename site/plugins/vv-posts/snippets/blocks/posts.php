<?php extract(kirby()->controller('posts.json', compact('page', 'site'))); ?>
<div class="posts" id="publications" data-replacementtop="true">
  <div class="posts__header">
    <div class="posts__title">
      <div>
        <h2>
          Publications
        </h2>
        <?php echo $currentPageIndicator ?>
      </div>
      <a class="posts__search" href="/recherche" title="Rechercher dans les publications">
        <span class="posts__search-icon"></span>
      </a>
    </div>
    <?php snippet('postcategories'); ?>
  </div>
  <div class="posts__content">
    <?php echo $postsList ?>
  </div>
  <div class="posts__footer">
    <?php echo $pagination ?>
  </div>
</div>
<?php echo vite()->js("scripts/posts.js");?>
