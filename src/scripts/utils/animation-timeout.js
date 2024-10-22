export function animationTimeout(callback, duration) {
  let start

  const step = (timeStamp) => {
    if (start === undefined) {
      start = timeStamp
    }

    if (timeStamp - start < duration) {
      window.requestAnimationFrame(step)
    }

    else {
      callback()
    }
  }

  window.requestAnimationFrame(step)
}
