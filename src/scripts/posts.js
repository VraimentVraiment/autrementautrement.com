import { LINK_ANIMATION_DURATION } from '@/scripts/lib/constants'
import { animationTimeout } from '@/scripts/utils/animation-timeout'
import { observeAddedNodes } from '@/scripts/utils/observe-added-nodes'
import { CollectionManager } from '@storage/plugins/kirby-collection-manager/lib/index.js'
import { setTagsState } from '@storage/plugins/kirby-tags/lib/tags.js'

window.addEventListener('DOMContentLoaded', main)

const CONTENT_ROUTE = `/articles.json`

const USE_ISOTOPE = false
async function main() {
  const tags = document.querySelectorAll('.tag')
  setTagsState(tags)
  const collectionManager = new CollectionManager({
    contentRoute: CONTENT_ROUTE,
    useIsotope: USE_ISOTOPE,
    afterReplace: () => {
      setTagsState(tags)
    },
  })

  tags?.forEach(tag => collectionManager.listenTaxonomyEvent(tag, {
    onTouchEnd: () => {
      animationTimeout(() => {
        tag.focus()
        animationTimeout(() => {
          tag.blur()
        })
      }, LINK_ANIMATION_DURATION)
    },
  }))
  if (USE_ISOTOPE) {
    await collectionManager.loadIsotope()
  }

  const links = document.querySelectorAll('.collection-pagination__item a')
  const listenPagination = link => collectionManager.listenPaginationEvent(link)
  links?.forEach(listenPagination)
  observeAddedNodes('.collection-pagination__item a', listenPagination)

  const forms = document.querySelectorAll('form.search__form')
  forms?.forEach(form => collectionManager.listenSearchEvent(form))
}
