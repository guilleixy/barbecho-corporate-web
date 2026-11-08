import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import SplitText from "gsap/SplitText";

gsap.registerPlugin(ScrollTrigger, SplitText)

const initFadeUp = () => {
  gsap.utils.toArray('.js-split-up').forEach((element) => {
    let split = SplitText.create(element, {type: "chars"});

    gsap.from(split.chars, {
      // autoAlpha: 0,
      y: 200,
      duration: 0.8,
      ease: 'power2.out',
      stagger: 0.05,
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
