// import Bowser from 'bowser'
/**
 * Bower does not seem to detect mobile at least on Firefox mobile
 */

export function isMobile() {
  // const parser = Bowser.getParser(navigator.userAgent)
  // return parser.getPlatformType() === 'mobile'
  return window.innerWidth < 768
}
