<article class="post__content">
  <?php snippet('post-nav-back') ?>
  <div class="post__reading-time">
    <p>
      <?php echo $readingTime ?>
    </p>
  </div>
  <?php if ($author) : ?>
  <div class="post__author">
    <?php echo $author ?>
  </div>
  <?php endif ?>
  <?php if ($abstract) : ?>
  <div class="post__abstract">
    <?php echo $abstract ?>
  </div>
  <?php endif ?>
  <?php if ($cover) : ?>
  <div class="post__cover">
    <?php echo $cover ?>
  </div>
  <?php endif ?>
  <div class="post__content">
    <?php echo $content ?>
  </div>
  <?php if ($postscriptum) : ?>
  <div class="post__post-scriptum">
    <?php echo $postscriptum ?>
  </div>
  <?php endif ?>
  <?php if ($hasFootnotes) : ?>
  <div class="post__footnotes">
    <h4>Notes</h4>
    <?php echo $footnotes ?>
  </div>
  <?php endif ?>
</article>
