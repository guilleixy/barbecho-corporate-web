import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import SplitText from "gsap/SplitText";

gsap.registerPlugin(ScrollTrigger, SplitText)

const animateHero = (hero) => {
  const title = hero.querySelector('.js-hero-title');
  const lineVertical = hero.querySelector('.js-hero-line-vertical');
  const lineHorizontal = hero.querySelector('.js-hero-line-horizontal');
  const topRight = hero.querySelector('.js-hero-top-right')
  const bottomLeft = hero.querySelector('.js-hero-bottom-left')
  const bottomRight = hero.querySelector('.js-hero-bottom-right')

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
  const headerLogoWidth = window.getComputedStyle(document.querySelector('.header'))
    .getPropertyValue('--header-logo-width')
    .trim();

  const intro = gsap.timeline({
    scrollTrigger: {
      trigger: hero,
      start: `top ${headerOffset}px`,
      end: '+=100%',
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
  intro.to(lineHorizontal, {
    top: '-0.3%',
    ease: 'power2.inOut'
  }, 0.05);
}

  if (lineVertical) {
    intro.to(lineVertical, {
      left: `calc(100% - ${headerLogoWidth})`,
      ease: 'power2.inOut'
    }, 0.05);
  }

  // if (split.chars) {
  //   intro.to(split.chars, {
  //     fontSize: '900px',
  //     ease: 'power2.out',
  //   }, 0);
  // }

  if (split.chars) {
    intro.to(split.chars, {
      fontSize: '2000px',
      //y: 500,
      ease: 'none',
      stagger: { each: 0.01, from: 'start' },
    }, 0)
  }

  if (title) {
    intro.to(title, {
      y: 1300,
      // x: -1000,
      ease: 'none',
    }, 0)
  }

  // if (thumbnail) {
  //   intro.to(thumbnail, {
  //     height: '100%',
  //     width: '100%',
  //     ease: 'power2.out',
  //   }, 0.1)
  // }

  intro.to(topRight, {
    y: '-100%',
    x: '100%',
    ease: 'power2.out'
  }, 0.1);

  intro.to(bottomRight, {
    x: '100%',
    ease: 'power2.out'
  }, 0.1);

  intro.to(bottomLeft, {
    top: 0,
    left: 0,
    width: `calc(100% - ${headerLogoWidth})`,
    height: '100%',
    ease: 'power2.inOut'
  }, 0.05);
}

const animateClaimSection = () => {
  const section = document.querySelector('.claim-section');

  if (!section) {
    return;
  }

  const images = Array.from(section.querySelectorAll('.claim-section__image'));

  if (!images.length) {
    return;
  }

  gsap.set(images, { opacity: 0 });
  images.forEach((image, index) => {
    gsap.set(image, { zIndex: index + 1 });
  });

  ScrollTrigger.create({
      trigger: section,
      start: 'top top',
      end: '+=300%',
      pin: true,
      scrub: true,
      markers: true,
      onEnter: () => {
        gsap.set(images, { opacity: 0 });
        gsap.set(images[0], { opacity: 1 });
        images.forEach((image, index) => {
          image.classList.toggle('claim-section__image--active', index === 0);
        });
      },
      onEnterBack: () => {
        gsap.set(images, { opacity: 0 });
        gsap.set(images[0], { opacity: 1 });
        images.forEach((image, index) => {
          image.classList.toggle('claim-section__image--active', index === 0);
        });
      },
      onLeaveBack: () => {
        gsap.set(images, { opacity: 0 });
        images.forEach((image) => {
          image.classList.remove('claim-section__image--active');
        });
      },
      onUpdate: (trigger) => {
        const position = trigger.progress * (images.length - 1);
        const lowerIndex = Math.floor(position);
        const upperIndex = Math.ceil(position);
        const interpolation = position - lowerIndex;
        const isLastFrame = lowerIndex === images.length - 1;
        const isFinalTransition = upperIndex === images.length - 1 && !isLastFrame;
        const maxVisibleImages = 16;

        images.forEach((image, index) => {
          let opacity = 0;

          if (isLastFrame) {
            opacity = index === lowerIndex ? 1 : 0;
          } else if (isFinalTransition) {
            const oldestVisibleIndex = Math.max(
              0,
              lowerIndex - maxVisibleImages + 1
            );

            if (index >= oldestVisibleIndex && index <= lowerIndex) {
              opacity = 1 - interpolation;
            } else if (index === upperIndex) {
              opacity = interpolation;
            }
          } else {
            const oldestVisibleIndex = Math.max(
              0,
              lowerIndex - maxVisibleImages + 1
            );

            if (index >= oldestVisibleIndex && index < lowerIndex) {
              opacity = 1;
            } else if (index === lowerIndex) {
              opacity = 1;
            } else if (index === upperIndex) {
              opacity = interpolation;
            }
          }

          gsap.set(image, { opacity });
          image.classList.toggle('claim-section__image--active', opacity > 0);
        });
      },
  });
}

export const initHero = () => {
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    return;
  }

  gsap.utils.toArray('.js-hero').forEach(animateHero)
  animateClaimSection();
}
