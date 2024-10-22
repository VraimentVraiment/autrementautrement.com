import { LEAVE_PAGE_DELAY } from '@/scripts/lib/constants'
import { animationTimeout } from '@/scripts/utils/animation-timeout'
import { isMobile } from '@/scripts/utils/detect-mobile'

export function initMainNavigationMenu({
  openDelay = 0,
  closeDelay = 0,
  navToggler,
  onBeforeOpen = () => { },
  onOpen = () => { },
  onClose = () => { },
}) {
  navToggler.addEventListener('click', (e) => {
    e.preventDefault()
    e.stopPropagation()
    if (document.documentElement.classList.contains('nav-open')) {
      if (closeDelay === 0) {
        closeNav()
      }
      else {
        animationTimeout(() => {
          closeNav()
        }, closeDelay)
      }
    }
    else {
      onBeforeOpen?.()
      if (openDelay === 0) {
        openNav()
      }
      else {
        animationTimeout(() => {
          openNav()
        }, openDelay)
      }
    }
  })

  // const header = document.querySelector('header')
  // const homePageLogo = header.querySelector('h1')
  // homePageLogo?.addEventListener('click', () => {
  //   if (header.classList.contains('open')) {
  //     toggleNavDisplay(header, navToggler, links)
  //   }
  // })

  function openNav() {
    if (!document.documentElement.classList.contains('nav-open')) {
      animationTimeout(() => {
        onOpen?.()
        document.documentElement.classList.add('nav-open')
        navToggler.setAttribute('aria-expanded', 'true')
        if (isMobile()) {
          navToggler.blur()
        }
      }, LEAVE_PAGE_DELAY)
    }
  }

  function closeNav() {
    if (document.documentElement.classList.contains('nav-open')) {
      onClose?.()
      document.documentElement.classList.remove('nav-open')
      navToggler.setAttribute('aria-expanded', 'false')
      if (isMobile()) {
        navToggler.blur()
      }
    }
  }

  return {
    openNav,
    closeNav,
  }
}
