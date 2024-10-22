export function initNavigation({ navToggler, links }) {
  const header = document.querySelector('header')
  const homePageLogo = header.querySelector('h1')

  function toggleNavDisplay() {
    if (!header.classList.contains('open')) {
      header.classList.add('open')
      document.body.classList.add('overflow-hidden')
      document.documentElement.classList.add('overflow-hidden')
      navToggler.setAttribute('aria-expanded', 'true')
      links.forEach((link) => {
        link?.setAttribute?.('tabindex', '0')
      })
    }
    else {
      header.classList.remove('open')
      document.body.classList.remove('overflow-hidden')
      document.documentElement.classList.remove('overflow-hidden')
      navToggler.setAttribute('aria-expanded', 'false')
      links.forEach((link) => {
        link?.setAttribute?.('tabindex', '-1')
      })
    }
  }

  navToggler.addEventListener('click', () => {
    toggleNavDisplay()
  })

  homePageLogo?.addEventListener('click', () => {
    if (header.classList.contains('open')) {
      toggleNavDisplay()
    }
  })
}
