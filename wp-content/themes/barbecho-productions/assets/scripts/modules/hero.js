import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import SplitText from "gsap/SplitText";

gsap.registerPlugin(ScrollTrigger, SplitText)

const animateHero = (hero) => {
  const title = hero.querySelector('.js-hero-title');
  const lineVertical = hero.querySelector('.js-hero-line-vertical');
  const lineHorizontal = hero.querySelector('.js-hero-line-horizontal');

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

  const intro = gsap.timeline({
    scrollTrigger: {
      trigger: hero,
      start: 'top top',
      end: '+=40%',
      pin: true,
      scrub: true,
    }
  })

  if (lineHorizontal) {
    intro.to(lineHorizontal, { scaleX: 0, ease: 'power2.inOut' }, 0);
    intro.to(lineHorizontal, { y: -100, ease: 'power2.inOut' }, 0);
  }

  if (lineVertical) {
    intro.to(lineVertical, { scaleY: 0, ease: 'power2.inOut' }, 0);
    intro.to(lineVertical, { x: 100, ease: 'power2.inOut' }, 0);
  }

  gsap.to(split.chars, {
    yPercent: -110,
    ease: 'none',
    stagger: { each: 0.03, from: 'start' },
    scrollTrigger: {
      trigger: hero,
      start: () => intro.scrollTrigger.end - window.innerHeight * 0.2,
      end: () => intro.scrollTrigger.end + window.innerHeight * 0.2,
      scrub: true,
    }
  })

}

export const initHero = () => {
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    return;
  }

  gsap.utils.toArray('.js-hero').forEach(animateHero)
}
