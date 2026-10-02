import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger)

const initFadeUp = () => {
  gsap.utils.toArray('.js-fade-up').forEach((element) => {
    gsap.from(element, {
      autoAlpha: 0,
      y: 40,
      duration: 0.8,
      ease: 'power2.out',
      scrollTrigger: {
        trigger: element,
        start: 'top 85%',
      }
    })
  })
}

export const initAnimations = () => {
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    return;
  }

  initFadeUp()
}
