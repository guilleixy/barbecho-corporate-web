import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import SplitText from "gsap/SplitText";

gsap.registerPlugin(ScrollTrigger, SplitText)

const animateHero = (hero) => {
  const title = hero.querySelector('.js-hero-title');
  const lineVertical = hero.querySelector('.js-hero-line-vertical');
  const lineHorizontal = hero.querySelector('.js-hero-line-horizontal');
  const thumbnail = hero.querySelector('.js-hero-thumbnail');


  if (!title) {
    return
  }

  const split = SplitText.create(title, { type: 'chars' });

  gsap.from(split.chars, {
    y: 200,
    duration: 0.8,
    ease: 'power2.out',
    stagger: 0.05,
  });

  const mainElement = document.querySelector('main');
  const headerOffset = parseFloat(window.getComputedStyle(mainElement).marginTop);

  const intro = gsap.timeline({
    scrollTrigger: {
      trigger: hero,
      start: `top ${headerOffset}px`,
      end: '+=150%',
      pin: true,
      scrub: true,
    }
  });

  // VERSION 1
//   if (lineHorizontal) {
//     intro.to(lineHorizontal, { scaleX: 0, ease: 'power2.inOut' }, 0);
//     intro.to(lineHorizontal, { y: -100, ease: 'power2.inOut' }, 0);
//   }
//
//   if (lineVertical) {
//     intro.to(lineVertical, { scaleY: 0, ease: 'power2.inOut' }, 0);
//     intro.to(lineVertical, { x: 100, ease: 'power2.inOut' }, 0);
//   }

// VERSION CON IMG
if (lineHorizontal) {
  intro.to(lineHorizontal, { y: -1000, ease: 'power2.inOut' }, 0);
}

  if (lineVertical) {
    intro.to(lineVertical, { x: 2000, ease: 'power2.inOut' }, 0);
  }

  if (split.chars) {
    intro.to(split.chars, {
      yPercent: -300,
      ease: 'power2.out',
      stagger: { each: 0.02, from: 'start' },
    }, 0)
  }

  if (thumbnail) {
    intro.to(thumbnail, {
      height: '100%',
      width: '100%',
      ease: 'power2.out',
    }, 0.1)
  }

}

export const initHero = () => {
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    return;
  }

  gsap.utils.toArray('.js-hero').forEach(animateHero)
}
