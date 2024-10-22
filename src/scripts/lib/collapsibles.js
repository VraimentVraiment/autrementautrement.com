export function initCollapsibles() {
  const collapsibles = document.querySelectorAll('.collapsible')
  collapsibles.forEach((collapsible) => {
    const button = collapsible.querySelector('button.collapsible__summary')
    button.addEventListener('click', () => {
      collapsible.classList.toggle('collapsible--expanded')
    })
  })
}
