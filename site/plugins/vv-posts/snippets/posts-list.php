<ul class="posts-list">
  <?php foreach ($posts as $post) : ?>
  <li class="posts-list__item">
    <?php snippet('post-card', compact('post')) ?>
  </li>
  <?php endforeach; ?>
</ul>
