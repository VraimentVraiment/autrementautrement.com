<div class="post-categories">
  <?php snippet('collapsible', ['startOpen' => $site->hasCategory()], slots: true) ?>
  <?php slot('summary') ?>
  <h3 class="post-categories__title is-link-with-background">Filtrer par catégorie</h3>
  <?php endslot() ?>
  <?php slot('content') ?>
  <ul class="post-categories__list">
    <?php foreach (collection('post-categories') as $category) : ?>
    <li class="post-categories__item">
      <?php echo $site->getCategoryTag($category); ?>
    </li>
    <?php endforeach ?>
  </ul>
  <?php endslot() ?>
  <?php endsnippet() ?>
</div>
