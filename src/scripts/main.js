import { initCarousels } from '@/scripts/lib/carousels'
import { initCollapsibles } from '@/scripts/lib/collapsibles'
import { COLORS, LINK_ANIMATION_DURATION } from '@/scripts/lib/constants'
import { initLinksBackgrounds, watchNewLinkBackgrounds } from '@/scripts/lib/link-background'
import { initMainNavigationMenu } from '@/scripts/lib/main-navigation-menu'
import { animationTimeout } from '@/scripts/utils/animation-timeout'
import { isMobile } from '@/scripts/utils/detect-mobile'

document.documentElement.classList.replace('no-js', 'js')
window.addEventListener('DOMContentLoaded', main)

/**
 * Every link which is not part of the main navigation menu.
 * We need to :
 * - set their tabindex attribute to -1 when the main nav is open, so they are not focusable ;
 * - set their tabindex attribute to 0 when the main nav is closed, so they are focusable.
 */
const NON_MAIN_NAV_LINKS_SELECTORS = [
  'main a',
  'main button',
  'footer a',
]

const DELAYED_LINKS = [
  'a:not(.tag, #nav-toggler)',
]

const DIRECT_LINKS_SELECTORS = [
  'header h1.site-logo',
  'header .site-logo',
  'main a:not(.post-card__inner, .siblings-pagination__item a)',
  'main .search__submit input',
  'main button:not(.collapsible__summary)',
  'footer.site-footer a',
  '.tag',
]

const HEADER_LINKS_SELECTORS = {
  parentSelector: '.site-header nav a',
  childSelector: 'span:not(.current-page-icon)',
}

const COLLAPSIBLE_LINKS_SELECTORS = {
  parentSelector: '.collapsible__summary',
  childSelector: '.collapsible__summary-content .is-link-with-background',
}

const CARD_LINKS_SELECTORS = {
  parentSelector: '.post-card__inner',
  childSelector: '.post-card__title',
}

const PAGINATION_LINKS_SELECTORS = {
  parentSelector: '.siblings-pagination__item a',
  childSelector: '.siblings-pagination__label-content',
}

function getDeepBackground({
  childSelector,
  parentSelector,
}) {
  return [...document.querySelectorAll(parentSelector)]
    .map((parent) => {
      return {
        hoverTarget: parent,
        backgroundElements: [...parent.querySelectorAll(childSelector)],
      }
    })
}

function main() {
  const navToggler = document.getElementById('nav-toggler')

  const links = document.querySelectorAll(DIRECT_LINKS_SELECTORS.join(','))

  const headerNavLinks = getDeepBackground(HEADER_LINKS_SELECTORS)
  const paginationLinks = getDeepBackground(PAGINATION_LINKS_SELECTORS)
  const collapsibles = getDeepBackground(COLLAPSIBLE_LINKS_SELECTORS)
  const cards = getDeepBackground(CARD_LINKS_SELECTORS)

  const linksWithBackground = [
    navToggler,
    ...headerNavLinks,
    ...collapsibles,
    ...paginationLinks,
    ...cards,
    ...links,
  ]

  document.querySelectorAll(DELAYED_LINKS.join(', ')).forEach((link) => {
    link.addEventListener('click', (event) => {
      if (isMobile()) {
        event.preventDefault()
        event.stopPropagation()
        animationTimeout(() => {
          const href = link.getAttribute('href')
          if (href) {
            if (link.getAttribute('target') === '_blank') {
              window.open(href, '_blank')
            }
            else {
              window.location.href = href
            }
          }
        }, LINK_ANIMATION_DURATION)
      }
    })
  })

  const allSelectors = [
    COLLAPSIBLE_LINKS_SELECTORS,
    CARD_LINKS_SELECTORS,
    HEADER_LINKS_SELECTORS,
    PAGINATION_LINKS_SELECTORS,
    ...DIRECT_LINKS_SELECTORS,
  ]

  const nonMainNavLinks = document.querySelectorAll(NON_MAIN_NAV_LINKS_SELECTORS.join(','))
  initMainNavigationMenu({
    navToggler,
    openDelay: isMobile() ? LINK_ANIMATION_DURATION : 0,
    closeDelay: isMobile() ? LINK_ANIMATION_DURATION : 0,
    onOpen: () => {
      nonMainNavLinks.forEach((link) => {
        link?.setAttribute?.('tabindex', '-1')
      })
    },
    onClose: () => {
      nonMainNavLinks.forEach((link) => {
        link?.setAttribute?.('tabindex', '0')
      })
    },
  })

  const palette = initLinksBackgrounds([navToggler, ...linksWithBackground], COLORS)
  watchNewLinkBackgrounds(allSelectors, palette)

  initCarousels()
  initCollapsibles()
}
