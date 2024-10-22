<?php

// phpcs:disable Generic.Files.LineLength.TooLong

/**
 * Matomo Opt-Out iframe
 **/

$matomoUrl = option('sylvainjule.matomo.url');
$iframeOptions = '?module=CoreAdminHome&action=optOut&language=fr&backgroundColor=&fontColor=&fontSize=&fontFamily=Helvetica';
?>
<iframe style="border: 0; height: 300px; width: 100%; max-width: 600px;"
  src="<?php echo $matomoUrl . '/index.php' . $iframeOptions; ?>">
</iframe>
