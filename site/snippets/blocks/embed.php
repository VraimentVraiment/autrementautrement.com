<?php

if ($embed = $block->embed()->toEmbed()) :
  echo $embed->code();
endif;
