<?php

use Kirby\Cms\Page;

class PostPage extends Page
{
  public function metaDefaults(string $lang = null): array
  {
    $content = $this->content($lang);
    $cover = $content->cover()->toFile();
    $slug = $this->uri();
    $ogImage = url("og/{$slug}.png");
    $twImage = url("tw/{$slug}.png");
    $schemaImage = url("schema/{$slug}.png");

    $description = Str::unhtml($content->abstract()->value());

    $imagesTags = $cover ? [
      'og:image' => $ogImage,
      "og:image:width" => 1200,
      "og:image:height" => 628,
      'twitter:image' => $twImage,
      'schema:image' => $schemaImage,
      [
        'tag' => 'meta',
        'attributes' => [
          "id" => "schema_image",
          "content" => "{$schemaImage}",
          "itemprop" => "image",
        ],
      ]
    ] : [];

    return A::merge($imagesTags, [
      'metaDescription' => $description,
    ]);
  }
}
