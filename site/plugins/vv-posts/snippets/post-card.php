<div class="post-card" data-id="<?php echo $id ?>" data-order="<?php echo $order ?>">
  <a <?php echo attr([
  'href' => $href,
  'class' => 'post-card__inner'
]) ?>>
    <div class="post-card__cover">
      <?php echo $cover ?>
    </div>
    <div class="post-card__content">
      <p class="post-card__type">
        <?php echo $type ?>
      </p>
      <h3 class="post-card__title is-link-with-background">
        <?php echo $title ?>
      </h3>
      <p class="post-card__date">
        <?php echo $date ?>
      </p>
    </div>
  </a>
</div>
