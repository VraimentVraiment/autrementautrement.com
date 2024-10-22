import { LINK_ANIMATION_DURATION } from '@/scripts/lib/constants'
import { animationTimeout } from '@/scripts/utils/animation-timeout'
import { observeAddedNodes } from '@/scripts/utils/observe-added-nodes'
import { RandomizedQueue } from '@/scripts/utils/randomized-queue'

const DEBOUNCE_DELAY = 100

export function initLinksBackgrounds(links, colors) {
  const palette = new RandomizedQueue(colors)
  links.forEach(link => createLinkBackground(link, palette))
  return palette
}

export function watchNewLinkBackgrounds(selectors, palette) {
  observeAddedNodes(
    selectors.map((selector) => {
      if (selector.parentSelector) {
        return selector.parentSelector
      }
      return selector
    }),
    (link) => {
      const parents = selectors.filter((selector) => {
        return selector.parentSelector
      })
      const parent = parents.find((selector) => {
        return link.matches(selector.parentSelector)
      })
      if (parent) {
        createLinkBackground({
          hoverTarget: link,
          backgroundElements: [...link.querySelectorAll(parent.childSelector)],
        }, palette)
      }
      else {
        createLinkBackground(link, palette)
      }
    },
  )
}

/**
 * If only one element is passed as first argument,
 * it will be used as both hover target and background element.
 * --
 * If two elements are passed as { hoverTarget, backgroundElements }
 * the first one will be used as the hover target,
 * the second as a list of elements to animate.
 * --
 * If two elements are passed as { hoverTarget, backgroundElement }
 * the first one will be used as the hover target,
 * the second as a single element to animate.
 */
export function createLinkBackground(link, palette) {
  const hoverTarget = link.hoverTarget ?? link
  const effectSubject = link.backgroundElements ?? link.backgroundElement ?? link
  if (!effectSubject) {
    return
  }
  const backgroundElements = Array.isArray(effectSubject) ? effectSubject : [effectSubject]

  let debounceTimer
  backgroundElements.forEach((el) => {
    el.classList.add('link-with-background')
  })

  const mouseenter = () => {
    clearTimeout(debounceTimer)
    debounceTimer = setTimeout(() => {
      const color = palette.next
      backgroundElements.forEach((el) => {
        if (!el.classList.contains('--enter')) {
          el.style.setProperty('--background-color', color)
          el.classList.add('--enter')
          el.classList.remove('--leave')
        }
      })
    }, DEBOUNCE_DELAY)
  }

  const mouseleave = () => {
    clearTimeout(debounceTimer)
    debounceTimer = setTimeout(() => {
      backgroundElements.forEach((el) => {
        if (el.classList.contains('--enter')) {
          el.classList.remove('--enter')
          el.classList.add('--leave')

          animationTimeout(() => {
            if (el.classList.contains('--leave')) {
              el.classList.remove('--leave')
            }
          }, LINK_ANIMATION_DURATION)
        }
      })
    }, DEBOUNCE_DELAY)
  }

  hoverTarget.addEventListener('mouseenter', mouseenter)
  hoverTarget.addEventListener('mouseleave', mouseleave)
  hoverTarget.addEventListener('focus', mouseenter)
  hoverTarget.addEventListener('blur', mouseleave)
}
