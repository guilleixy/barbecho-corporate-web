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

  const reducedScale = 0.9;

  gsap.set(thumbnail, { scale: reducedScale, transformOrigin: "center center" });
  gsap.set(title, { xPercent: -105 });

  const transitionTimeline = gsap.timeline({
    scrollTrigger: {
      trigger: project,
      start: 'center center',
      end: '+=20%',
      pin: true,
      scrub: 0.25,
    },
  });

  transitionTimeline.to(thumbnail, {
    scale: 1,
    duration: 0.25,
    ease: 'power3.out',
  }, 0);

  transitionTimeline.to(title, {
    xPercent: 0,
    duration: 0.3,
    ease: 'power3.out',
  }, 0.1);

  transitionTimeline.to(title, {
    xPercent: -105,
    duration: 0.25,
    ease: 'power3.in',
  }, 0.75);

  transitionTimeline.to(thumbnail, {
    scale: reducedScale,
    duration: 0.25,
    ease: 'power3.in',
  }, 0.85);
}

export const initHome = () => {
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    return;
  }

  initClaimSectionEnd()
  gsap.utils.toArray('.project-showcase').forEach(animateProjectShowcase)
}
