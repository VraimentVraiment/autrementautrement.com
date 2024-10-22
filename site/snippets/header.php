<header class="site-header" <?php echo $contrast ? 'site-header--contrast' : ''; ?>>
  <div class="site-header__inner">
    <?php echo $logoTag; ?>
    <a <?php echo $navTogglerAttrs ?>>
      <span class="nav-toggler__closed">
        <?php echo $menuIconClosed; ?>
      </span>
      <span class="nav-toggler__open">
        <?php echo $menuIconOpen; ?>
      </span>
    </a>
    <?php snippet('navigation-menu', ['key' => 'primary']); ?>
  </div>
</header>
