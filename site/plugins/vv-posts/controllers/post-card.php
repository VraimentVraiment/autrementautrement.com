<?php

return function ($post) {
  $typeKey = $post->type()->value();
  $id = $post->id();
  $order = $post->siblings()
    ->sortBy('date', 'desc')
    ->indexOf($post);

  $type = site()->getPostType($typeKey)?->name();
  $href = $post->url();
  $title = $post->title();
  $date = $post->date()->toDate('d MMMM YYYY');
  $cover = snippet('figure', [
    'noCaption' => true,
    'file' => $post->content()->cover()->toFile(),
    'options' => [
      'ratio' => '4/3',
      'imgAttributes' => [
        'shared' => [
          'class' => '',
          'alt' => '',
        ],
      ]
    ],
  ], true);
  return compact([
    'id',
    'order',
    'href',
    'type',
    'post',
    'cover',
    'title',
    'date',
  ]);
};
