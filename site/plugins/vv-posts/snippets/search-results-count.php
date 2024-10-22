<div class="search-results-count">
  <?php if ($query && $itemsCount > 0) : ?>
  <p>
    <span class="search-query__label">
    <?php echo $itemsCount ?> résultat<?php echo $itemsCount > 1 ? 's' : '' ?> trouvés pour le terme
    </span>
    <b class="search-query__value">
      « <?php echo html($query) ?> »
    </b>
  </p>
    <?php echo $currentPageIndicator ?>
  <?php elseif ($query) : ?>
  <p>Aucun résultat trouvé pour le terme <b>« <?php echo html($query) ?> »</b></p>
  <?php endif ?>
</div>
