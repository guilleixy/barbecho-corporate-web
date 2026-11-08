import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import SplitText from "gsap/SplitText";

gsap.registerPlugin(ScrollTrigger, SplitText)

const initClaimSectionEnd = () => {
  gsap.to(".claim-section-end", {
    clipPath: "polygon(0 0, 100% 0, 100% 100%, 0 100%)",
    scrollTrigger: {
      trigger: ".claim-section-end",
      start: "top 50%",
      end: "top 3%",
      scrub: true
    }
  });
}

const animateProjectShowcase = (project) => {
  const title = project.querySelector('.project-showcase__title');
  const thumbnail = project.querySelector('.project-showcase__thumbnail__wrapper');

  if (!title || !thumbnail) {
    return;
  }

  const reducedScale = 0.95;

  gsap.set(thumbnail, { scale: reducedScale, transformOrigin: "center center" });
  gsap.set(title, { xPercent: -105 });


  // TODO revisar el scrub porque estas animaciones no deberían de tener
  const projectShowcaseTimeline = gsap.timeline({
    scrollTrigger: {
      trigger: project,
      start: 'center center',
      end: '+=40%',
      pin: true,
      scrub: true,
    }
  })

  projectShowcaseTimeline.to(thumbnail, {
    scale: 1,
    duration: 0.3,
    ease: 'power2.out',
    scrub: false,
  }, 0)

  projectShowcaseTimeline.to(title, {
    xPercent: 0,
    duration: 0.5,
    ease: 'power2.out',
    scrub: false,
  }, 0.1)

  projectShowcaseTimeline.to(title, {
    xPercent: -105,
    duration: 0.5,
    ease: 'power2.out',
    scrub: false,
  }, 0.9)

  projectShowcaseTimeline.to(thumbnail, {
    scale: reducedScale,
    duration: 0.3,
    ease: 'power2.out',
    scrub: false,
  }, 1)
}

export const initHome = () => {
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    return;
  }

  initClaimSectionEnd()
  gsap.utils.toArray('.project-showcase').forEach(animateProjectShowcase)
}
