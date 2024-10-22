/**
 * Observes the DOM for nodes added that match a specific selector and executes a callback for each matching node.
 *
 * @param {string} selector - The CSS selector to match the added nodes.
 * @param {Function} callback - The callback function to execute for each matching node. The callback receives the matching node as an argument.
 */
export function observeAddedNodes(selector, callback) {
  const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
      if (mutation.addedNodes.length) {
        mutation.addedNodes.forEach((node) => {
          if (node.nodeType === Node.ELEMENT_NODE) {
            const newNodes = node.querySelectorAll(selector)
            newNodes.forEach(callback)
          }
        })
      }
    })
  })

  observer.observe(document.body, {
    childList: true,
    subtree: true,
  })
}
