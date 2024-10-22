<?php

return function ($site, $page) {
  $type = $site->getPostType($page->type()->value())?->name();
  $title = $page->title();
  $readingTime = $page->readingTime();
  $author = $page->content()->author()->collectFootnotes();
  $abstract = $page->content()->abstract()->collectFootnotes();
  $postscriptum = $page->content()->postscriptum()->collectFootnotes();
  $date = $page->date()->toDate('d MMMM YYYY');

  $cover = snippet('figure', [
    'file' => $page->content()->cover()->toFile(),
    'options' => [
      'imgAttributes' => [
        'shared' => [
        ],
      ]
    ],
  ], true);

  $content = snippet('layouts', [
    'layouts' => $page->content()->content()->toLayouts(),
  ], true);

  $collection = $page->siblings()->listed()->sortBy('date', 'desc');
  $pagination = snippet('siblings-pagination', [
    'hasPrev' => $page->hasPrev($collection),
    'hasNext' => $page->hasNext($collection),
    'prev' => $page->prev($collection),
    'next' => $page->next($collection),
    'prevLabel' => Html::span([Html::span('Article précédent', ['class' => 'siblings-pagination__label-header']), Html::span($page->prev($collection)?->title(), ['class' => 'siblings-pagination__label-content'])], ['class' => 'siblings-pagination__label']),
    'nextLabel' => Html::span([Html::span('Article suivant', ['class' => 'siblings-pagination__label-header']) . Html::span($page->next($collection)?->title(), ['class' => 'siblings-pagination__label-content'])], ['class' => 'siblings-pagination__label']),
    'attrs' => [
    ],
  ], true);

  $hasFootnotes = count(Footnotes::footnotes($purge = false, $unwrapped = true) ?? []) > 0;
  $footnotes = Footnotes::footnotes();

  return [
    'post' => compact([
      'type',
      'title',
      'date',
      'readingTime',
      'author',
      'abstract',
      'postscriptum',
      'cover',
      'content',
      'pagination',
      'footnotes',
      'hasFootnotes',
    ])
  ];
};
