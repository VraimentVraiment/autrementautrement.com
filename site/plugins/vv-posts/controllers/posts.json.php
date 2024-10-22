<?php

return function ($site, $page, $queryNeeded = false) {

  $collectionName = 'posts';

  $taxonomies = [
    [
      'paramName' => 'category',
      'collectionParamName' => 'categories',
    ]
  ];

  $queryParam = 'q';
  $queryFields = 'title|content';

  $paginationParam = 'p';
  $paginationLimit = 5;
  $paginationRange = 5;

  /** Get the collection */
  $collection = collection($collectionName);

  /** Filter with user search, if any */
  $query = get($queryParam);
  if ($query) {
    $collection = $collection
      ->search($query, $queryFields);
  } elseif ($queryNeeded) {
    /** If a query is needed but not provided, return an empty collection */
    $collection = $collection->empty();
  }

  /** Filter by taxonomies */
  foreach ($taxonomies as $taxonomy) {
    $param = get($taxonomy['paramName']) ?? param($taxonomy['paramName']);
    if ($param) {
      $collection = $collection
        ->filterBy($taxonomy['collectionParamName'], $param, ',');
    }
  }

  /** Sort by date */
  $collection = $collection
      ->sortBy('Date', 'desc');

  /** Get total count before pagination */
  $itemsCount = $collection->count();

  /** Paginate the collection */
  $collection = $collection->paginate([
    'limit'    => $paginationLimit,
    'method'   => 'query',
    'variable' => $paginationParam,
  ]);

  /** Compute items HTML */
  $postsList = snippet('posts-list', [
    'posts' => $collection,
  ], true);

  /** Compute pagination HTML */
  $pagination = snippet('collection-pagination', [
    'collection' => $collection,
    'range' => $paginationRange,
  ], true);

  $currentPageIndicator = snippet('current-page-indicator', [
    'collection' => $collection,
  ], true);

  /** Compute search results count HTML */
  $searchResultCount = snippet('search-results-count', [
    'query' => $query,
    'itemsCount' => $itemsCount,
    'currentPageIndicator' => $currentPageIndicator,
  ], true);

  /** Prepare replacements for js */
  $replacements = [
    [
      'containerSelector' => '.posts-list',
      'itemSelector' => '.posts-list__item',
      'itemInnerSelector' => '.post-card',
      'data' => $postsList,
      'isotope' => true,
    ],
    [
      'containerSelector' => '.collection-pagination ul',
      'itemSelector' => '.collection-pagination__item',
      'data' => $pagination,
    ],
    [
      'containerSelector' => '.current-page-indicator',
      'outerHTML' => true,
      'data' => $currentPageIndicator,
    ],
    [
      'containerSelector' => '.search-results-count',
      'outerHTML' => true,
      'data' => $searchResultCount,
    ],
  ];

  return [
    'posts' => $collection,

    'query' => $query,
    'queryParam' => $queryParam,

    'pagination' => $pagination,
    'searchResultCount' => $searchResultCount,
    'postsList' => $postsList,
    'currentPageIndicator' => $currentPageIndicator,

    'replacements' => $replacements,
  ];
};
