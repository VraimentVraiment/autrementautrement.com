<?php

load([
  'PostPage' => 'models/post.php',
], __DIR__);

Kirby::plugin('vv/posts', [

  "collections" => [
    'posts' => function () {
      return site()->find('articles')->children();
    },
    'post-categories' => function () {
      return site()->content()->postcategories()->toStructure();
    },
    'post-types' => function () {
      return site()->content()->posttypes()->toStructure();
    },
  ],

  'blueprints' => [
    'pages/posts' => __DIR__ . '/blueprints/pages/posts.yml',
    'pages/post' => __DIR__ . '/blueprints/pages/post.yml',
    'sections/posts' => __DIR__ . '/blueprints/sections/posts.yml',
    'blocks/posts' => __DIR__ . '/blueprints/blocks/posts.yml',
    'blocks/postcategories' => __DIR__ . '/blueprints/blocks/post-categories.yml',
    'fields/post-categories' => __DIR__ . '/blueprints/fields/post-categories.yml',
    'fields/punchlinecolor' => __DIR__ . '/blueprints/fields/punchlinecolor.yml',
  ],

  'pageModels' => [
    'post' => PostPage::class,
    'map-post' => PostPage::class
  ],

  'templates' => [
    'post' => __DIR__ . '/templates/post.php',
    'post.png' => __DIR__ . '/templates/post.png.php',
    'map-post.png' => __DIR__ . '/templates/post.png.php',
    'posts' => __DIR__ . '/templates/posts.php',
    'posts.json' => __DIR__ . '/templates/posts.json.php',
  ],
  'controllers' => [
    'post' => require_once __DIR__ . '/controllers/post.php',
    'posts.json' => require_once __DIR__ . '/controllers/posts.json.php',
  ],

  'snippets' => [
    'post-container' => __DIR__ . '/snippets/post-container.php',
    'blocks/posts' => __DIR__ . '/snippets/blocks/posts.php',
    'post-header' => __DIR__ . '/snippets/post-header.php',
    'post-footer' => __DIR__ . '/snippets/post-footer.php',
    'post-content' => __DIR__ . '/snippets/post-content.php',
    'posts-list' => __DIR__ . '/snippets/posts-list.php',
    'postcategories' => __DIR__ . '/snippets/post-categories.php',
    'post-card' => __DIR__ . '/snippets/post-card.php',
    'post-card.controller' => __DIR__ . '/controllers/post-card.php',
    'post-nav-back' => __DIR__ . '/snippets/post-nav-back.php',
    'post-nav-to-top' => __DIR__ . '/snippets/post-nav-to-top.php',
    'blocks/search' => __DIR__ . '/snippets/blocks/search.php',
    'search-results-count' => __DIR__ . '/snippets/search-results-count.php',
  ],

  'pageMethods' => [
    'readingTime' => function () {
      $wordPerMinute = 250;
      $content = $this->content()->content()->blocks()->toBlocks();
      $wordCount = str_word_count(strip_tags($content));
      $readingTime = ceil($wordCount / $wordPerMinute);
      return $readingTime . ' min de lecture';
    },

    'generateSchemaImg' => function () {
      $file = $this->content()->cover()->toFile();
      if ($file) {
        $this->generateImg(
            $width = 1200,
            $height = 628,
            $imagePath = $file->root(),
            $backgroundColorHex = [243, 237, 227]
        );
      }
    },

    'generateOgImage' => function () {
      $file = $this->content()->cover()->toFile();
      if ($file) {
        $this->generateImg(
            $width = 1200,
            $height = 628,
            $imagePath = $file->root(),
            $backgroundColorHex = [243, 237, 227]
        );
      }
    },

    'generateTwImage' => function () {
      $file = $this->content()->cover()->toFile();
      if ($file) {
        $this->generateImg(
            $width = 1200,
            $height = 675,
            $imagePath = $file->root(),
            $backgroundColorHex = [243, 237, 227]
        );
      }
    },

    'generateImg' => function ($width, $height, $imagePath, $backgroundColorHex) {

      // Determine the image type and create the image resource accordingly
      $imageType = exif_imagetype($imagePath);
      switch ($imageType) {
        case IMAGETYPE_PNG:
            $image = imagecreatefrompng($imagePath);
            break;
        case IMAGETYPE_JPEG:
            $image = imagecreatefromjpeg($imagePath);
            break;
        case IMAGETYPE_GIF:
            $image = imagecreatefromgif($imagePath);
            break;
        case IMAGETYPE_WEBP:
            $image = imagecreatefromwebp($imagePath);
            break;
        case IMAGETYPE_AVIF:
            $image = imagecreatefromavif($imagePath);
            break;
        default:
            die('Unsupported image type.');
      }

      $srcWidth = imagesx($image);
      $srcHeight = imagesy($image);
      $dstWidth = $width;
      $dstHeight = $height;
      $srcRatio = $srcWidth / $srcHeight;
      $dstRatio = $dstWidth / $dstHeight;

      // Resize the image to fit within the canvas
      if ($srcWidth > $dstWidth || $srcHeight > $dstHeight) {
        if ($srcRatio > ($dstRatio)) {
          $dstHeight = (int)($width / $srcRatio);
        } else {
          $dstWidth = (int)($height * $srcRatio);
        }
      }

      $dstX = (int)(($width - $dstWidth) / 2);
      $dstY = (int)(($height - $dstHeight) / 2);

      $canvas = imagecreatetruecolor($width, $height);
      $backgroundColor = imagecolorallocate($canvas, $backgroundColorHex[0], $backgroundColorHex[1], $backgroundColorHex[2]);
      imagefill($canvas, 0, 0, $backgroundColor);

      // Create a temporary image for the resized version
      $resizedImage = imagecreatetruecolor($dstWidth, $dstHeight);
      imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $dstWidth, $dstHeight, $srcWidth, $srcHeight);

      // Apply the "multiply" effect manually
      for ($y = 0; $y < $height; $y++) {
        for ($x = 0; $x < $width; $x++) {
            $bgColor = imagecolorat($canvas, $x, $y);
            $bgRed = ($bgColor >> 16) & 0xFF;
            $bgGreen = ($bgColor >> 8) & 0xFF;
            $bgBlue = $bgColor & 0xFF;

          if ($x >= $dstX && $x < $dstX + $dstWidth && $y >= $dstY && $y < $dstY + $dstHeight) {
              $imgColor = imagecolorat($resizedImage, $x - $dstX, $y - $dstY);
              $imgRed = ($imgColor >> 16) & 0xFF;
              $imgGreen = ($imgColor >> 8) & 0xFF;
              $imgBlue = $imgColor & 0xFF;

              // Multiply blend mode formula
              $finalRed = (int)(($bgRed * $imgRed) / 255);
              $finalGreen = (int)(($bgGreen * $imgGreen) / 255);
              $finalBlue = (int)(($bgBlue * $imgBlue) / 255);

              $finalColor = imagecolorallocate($canvas, $finalRed, $finalGreen, $finalBlue);
              imagesetpixel($canvas, $x, $y, $finalColor);
          }
        }
      }

      kirby()->response()->type('image/png');
      imagepng($canvas);
      imagedestroy($canvas);
      imagedestroy($resizedImage);
      imagedestroy($image);
    }
  ],

  'siteMethods' => [
    'getCategoryTag' => function ($category) {
      return site()->getParamTag(
          $url = '/#publications',
          $key = $category->slug()->value(),
          $label = $category->name(),
          $paramName = 'category'
      );
    },
    'hasCategory' => function () {
      return get('category') !== null || param('category') !== null;
    },
    'getPostType' => function ($slug) {
      return collection('post-types')
        ->filter(function ($type) use ($slug) {
          return $type->slug() == $slug;
        })->first();
    },
  ],

  'routes' => [
    [
      'pattern' => 'og/(:all).png',
      'action'  => function ($slug) {
        $page = page($slug);
        if ($page) {
          go($page->url() . '.png?type=og');
        }
      }
    ],
    [
      'pattern' => 'tw/(:all).png',
      'action'  => function ($slug) {
        $page = page($slug);
        if ($page) {
          go($page->url() . '.png?type=tw');
        }
      }
    ],
    [
      'pattern' => 'schema/(:all).png',
      'action'  => function ($slug) {
        $page = page($slug);
        if ($page) {
          go($page->url() . '.png?type=schema');
        }
      }
    ],
  ],
]);
