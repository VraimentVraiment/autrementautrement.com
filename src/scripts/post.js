window.addEventListener('DOMContentLoaded', main)

function main() {
  const header = document.querySelector('header')
  const btnToTop = document.querySelector('.post-nav-to-top')

  update()
  window.addEventListener('scroll', () => {
    update()
  })

  function update() {
    const headerHeight = header.getBoundingClientRect().height

    const scrollY = window.scrollY
    if (scrollY > headerHeight) {
      header.classList.remove('site-header--contrast')
      header.classList.add('site-header--fixed')
      if (btnToTop) {
        btnToTop.style.display = 'block'
      }
    }
    else {
      header.classList.add('site-header--contrast')
      header.classList.remove('site-header--fixed')
      if (btnToTop) {
        btnToTop.style.display = 'none'
      }
    }
  }
}
