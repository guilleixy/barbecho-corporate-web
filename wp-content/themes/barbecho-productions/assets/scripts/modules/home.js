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


  const entranceTimeline = gsap.timeline({ paused: true });

  entranceTimeline.to(thumbnail, {
    scale: 1,
    duration: 0.35,
    ease: 'power2.out',
  }, 0);

  entranceTimeline.to(title, {
    xPercent: 0,
    duration: 0.4,
    ease: 'power2.out',
  }, 0.1);

  const exitTimeline = gsap.timeline({ paused: true });

  exitTimeline.to(title, {
    xPercent: -105,
    duration: 0.35,
    ease: 'power2.in',
  }, 0);

  exitTimeline.to(thumbnail, {
    scale: reducedScale,
    duration: 0.35,
    ease: 'power2.in',
  }, 0.1);

  ScrollTrigger.create({
    trigger: project,
    start: 'center center',
    end: '+=100%',
    pin: true,
    scrub: false,
    onEnter: () => entranceTimeline.play(),
    onLeave: () => exitTimeline.play(),
    onEnterBack: () => exitTimeline.reverse(),
    onLeaveBack: () => {
      exitTimeline.reverse();
      entranceTimeline.reverse();
    },
  });
}

export const initHome = () => {
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    return;
  }

  initClaimSectionEnd()
  gsap.utils.toArray('.project-showcase').forEach(animateProjectShowcase)
}
