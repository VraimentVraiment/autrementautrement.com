import { observeAddedNodes } from '@/scripts/utils/observe-added-nodes'

export function initCarousels() {
  const carousels = document.querySelectorAll('.carousel')
  carousels.forEach(initCarousel)
}

export function watchNewCarousels() {
  observeAddedNodes('.carousel', initCarousel)
}

function initCarousel(carousel) {
  const inner = carousel.querySelector('.carousel-inner')
  const items = [...inner.querySelectorAll('.carousel-item')]
  const prevBtn = carousel.querySelector('.carousel-control-prev')
  const nextBtn = carousel.querySelector('.carousel-control-next')

  let currentIndex = 0
  const totalItems = items.length

  let timeSinceUpdate = 0
  setInterval(() => {
    timeSinceUpdate += 200
  }, 200)

  function updateCarousel() {
    const newTransformValue = `translateX(-${100 * currentIndex}%)`
    inner.style.transform = newTransformValue
    timeSinceUpdate = 0
  }

  const prevImg = () => {
    const targetIndex = currentIndex - 1
    if (targetIndex < 0) {
      // insert last item at the beginning
      const lastItem = items[totalItems - 1]
      inner.insertBefore(lastItem, items[0])
      items.sort((a, b) => a.compareDocumentPosition(b) & Node.DOCUMENT_POSITION_FOLLOWING ? -1 : 1)
      inner.classList.add('instant')
      currentIndex += 1
      updateCarousel()
    }
    setTimeout(() => {
      inner.classList.remove('instant')
      currentIndex -= 1
      updateCarousel()
    }, 0)
  }

  const nextImg = () => {
    const targetIndex = currentIndex + 1
    if (targetIndex >= totalItems) {
      // insert first item at the end
      const firstItem = items[0]
      inner.appendChild(firstItem)
      items.sort((a, b) => a.compareDocumentPosition(b) & Node.DOCUMENT_POSITION_FOLLOWING ? -1 : 1)
      inner.classList.add('instant')
      currentIndex -= 1
      updateCarousel()
    }
    setTimeout(() => {
      inner.classList.remove('instant')
      currentIndex += 1
      updateCarousel()
    }, 60)
  }

  prevBtn.addEventListener('click', prevImg)

  nextBtn.addEventListener('click', nextImg)

  // Autoplay functionality
  const autoplay = carousel.dataset.autoplay === 'true'
  const interval = Number.parseInt(carousel.dataset.interval, 10) || 500

  if (autoplay) {
    setInterval(() => {
      if (timeSinceUpdate < interval) {
        return
      }
      currentIndex = (currentIndex + 1) % totalItems
      updateCarousel()
    }, 200)
  }

  // Swipe gesture functionality
  let startX = 0
  let endX = 0

  inner.addEventListener('touchstart', (event) => {
    startX = event.touches[0].clientX
  })

  inner.addEventListener('touchmove', (event) => {
    endX = event.touches[0].clientX
  })

  const SWIPE_THRESHOLD = 50
  inner.addEventListener('touchend', () => {
    if (startX - endX > SWIPE_THRESHOLD) {
      nextImg()
    }
    else if (endX - startX > SWIPE_THRESHOLD) {
      prevImg()
    }
  })
}
