import gsap from "gsap";

let gltl = gsap.timeline({ delay: 1 });
let sparks = gsap.utils.toArray(".spark");
let xDist = "100vw";
let tapped = false;

let roTL = gsap.timeline({
    defaults: {
        duration: 1,
        ease: "sine.inOut",
    },
});
let rot = 90;

let tl = gsap.timeline({
    delay: 0,
});
export default {
    data() {
        return {
            stage: null,
            hero: null,
        };
    },
    methods: {
        animInCuboids() {
            tl.from(
                ".hero__cuboid",
                {
                    rotateY: 270,
                    duration: 5,
                    ease: "power4",
                    stagger: 0.2,
                    transformOrigin: "center center",
                },
                0
            )
                .from(
                    ".hero__cuboid",
                    {
                        x: xDist,
                        duration: 4,
                        stagger: 0.4,
                        ease: "power4",
                    },
                    0
                )
                .from(
                    ".hero__cuboid",
                    {
                        rotationZ: 90,
                        stagger: 0.2,
                        duration: 6,
                        ease: "power4",
                    },
                    0
                )
                .from(
                    ".hero",
                    {
                        scale: 2.5,
                        duration: 9,
                        ease: "power4",
                    },
                    0
                )
                .to(
                    ".face--right img",
                    {
                        opacity: 0,
                        duration: 1.5,
                        ease: "power4",
                        stagger: 0.4,
                    },
                    0
                )
                .to(
                    ".face--back img",
                    {
                        opacity: 0,
                        duration: 5,
                        ease: "power4",
                        stagger: 0.4,
                    },
                    0
                )
                .to(
                    ".face--left img",
                    {
                        opacity: 0,
                        duration: 5,
                        ease: "power4",
                        stagger: 0.4,
                    },
                    0.5
                )
                .from(
                    ".face--front img",
                    {
                        scale: 1.5,
                        transformOrigin: "right top",
                        duration: 9,
                        ease: "power3.out",
                    },
                    1.5
                );

            return tl;
        },
        animateLogo() {
            gsap.set(sparks, {
                transformOrigin: "center center",
                scale: 0.25,
                opacity: 0,
            });
            tl = gsap.timeline();
            tl.from(".disney", {
                opacity: 0,
                ease: "none",
                duration: 2,
            })
                .fromTo(
                    ".mask-arc",
                    {
                        drawSVG: "100% 100%",
                    },
                    {
                        drawSVG: "100%",
                        duration: 1,
                        ease: "power2.in",
                    },
                    0.5
                )
                .from(
                    ".glow",
                    {
                        scale: 0,
                        duration: 0.7,
                        ease: "sine.in",
                    },
                    0.5
                )
                .from(
                    ".glow",
                    {
                        motionPath: {
                            path: ".glow-path",
                            align: ".glow-path",
                            alignOrigin: [0.5, 0.5],
                            autoRotate: true,
                        },
                        duration: 1,
                        ease: "power2.in",
                    },
                    0.5
                )
                .set(
                    ".glow",
                    {
                        opacity: 0,
                    },
                    "-=0.5"
                )
                .from(
                    ".plus",
                    {
                        scale: 0,
                        duration: 0.7,
                        ease: "elastic(1, 0.7)",
                        transformOrigin: "center center",
                    },
                    "-=0.55"
                )
                .fromTo(
                    ".plus-glow",
                    {
                        scale: 0,
                        transformOrigin: "center center",
                    },
                    {
                        scale: 3.0,
                        opacity: 1,
                        ease: "sine.inOut",
                        duration: 0.1,
                    },
                    "-=0.70"
                )
                .to(
                    ".plus-glow",
                    {
                        // scale: 0,
                        opacity: 0,
                        duration: 1.3,
                        ease: "power2",
                    },
                    "-=0.7"
                );

            return tl;
        },

        sparkle() {
            let stl = gsap.timeline();
            sparks.forEach((target, i) => {
                let tl = gsap.timeline();

                tl.set(target, {
                    opacity: 1,
                }).to(target, {
                    duration: 1.5,
                    physics2D: {
                        velocity: "random(100, 400)",
                        angle: "random(360, 0)",
                        gravity: 100,
                    },
                    scale: 0,
                    opacity: 0,
                    ease: "sine",
                });

                stl.add(tl, 0);
            });
            return stl;
        },
        addRotAnim() {
            roTL.to(".hero__cuboid--1", {
                keyframes: [
                    {
                        x: "-75%",
                        ease: "power4.inOut",
                    },
                    {
                        rotationY: -rot,
                        delay: -1,
                        ease: "power4.inOut",
                    },
                ],
            })
                .to(
                    ".hero__cuboid--1 .face--front img",
                    {
                        opacity: 0,
                        ease: "power2.inOut",
                    },
                    0
                )
                .from(
                    ".hero__cuboid--1 .face--right img",
                    {
                        opacity: 0,
                        ease: "power2.inOut",
                    },
                    0.1
                )
                .fromTo(
                    ".hero__cuboid--1 .face--back img",
                    {
                        opacity: 0,
                    },
                    {
                        opacity: 0.2,
                        ease: "power2.inOut",
                    },
                    0
                )
                .to(
                    ".hero__cuboid--2",
                    {
                        keyframes: [
                            {
                                x: "-25%",
                                ease: "power4.inOut",
                            },
                            {
                                rotationY: -rot,
                                delay: -1,
                                ease: "power4.inOut",
                            },
                        ],
                    },
                    0
                )
                .to(
                    ".hero__cuboid--2 .face--front img",
                    {
                        opacity: 0,
                        ease: "power2.inOut",
                    },
                    0
                )
                .from(
                    ".hero__cuboid--2 .face--right img",
                    {
                        opacity: 0,
                        ease: "power2.inOut",
                    },
                    0.1
                )
                .fromTo(
                    ".hero__cuboid--2 .face--back img",
                    {
                        opacity: 0,
                    },
                    {
                        opacity: 0.2,
                        ease: "power2.inOut",
                    },
                    0.1
                )
                .to(
                    ".hero__cuboid--3",
                    {
                        keyframes: [
                            {
                                x: "25%",
                                ease: "power4.inOut",
                            },
                            {
                                rotationY: rot,
                                delay: -1,
                                ease: "power4.inOut",
                            },
                        ],
                    },
                    0
                )
                .to(
                    ".hero__cuboid--3 .face--front img",
                    {
                        opacity: 0,
                        ease: "power2.inOut",
                    },
                    0
                )
                .from(
                    ".hero__cuboid--3 .face--left img",
                    {
                        opacity: 0,
                        ease: "power2.inOut",
                    },
                    0.1
                )
                .fromTo(
                    ".hero__cuboid--3 .face--back img",
                    {
                        opacity: 0,
                    },
                    {
                        opacity: 0.2,
                        ease: "power2.inOut",
                    },
                    0.1
                )
                .to(
                    ".hero__cuboid--4",
                    {
                        keyframes: [
                            {
                                x: "75%",
                                ease: "power4.inOut",
                            },
                            {
                                rotationY: rot,
                                delay: -1,
                                ease: "power4.inOut",
                            },
                        ],
                    },
                    0
                )
                .to(
                    ".hero__cuboid--4 .face--front img",
                    {
                        opacity: 0,
                        ease: "power2.inOut",
                    },
                    0
                )
                .from(
                    ".hero__cuboid--4 .face--left img",
                    {
                        opacity: 0,
                        ease: "power2.inOut",
                    },
                    0.05
                )
                .fromTo(
                    ".hero__cuboid--4 .face--back img",
                    {
                        opacity: 0,
                    },
                    {
                        opacity: 0.2,
                        ease: "power2.inOut",
                    },
                    0.1
                )
                .pause();
        },
        initEvents() {
            gsap.set(".face img", { opacity: 1 });
            this.addRotAnim();
            this.hero.addEventListener(
                "mouseenter",
                function (event) {
                    roTL.play();
                },
                false
            );
            this.hero.addEventListener(
                "mouseleave",
                function (event) {
                    roTL.reverse();
                },
                false
            );
            this.hero.addEventListener("touchstart", function (event) {
                if (!tapped) {
                    tapped = true;
                    roTL.play();
                } else {
                    tapped = false;
                    roTL.reverse();
                }
            });
        },
        init() {
            gsap.set(this.stage, { autoAlpha: 1 });
            gsap.set(".hero__inner", { z: -135 });
            setTimeout(() => {
                this.initEvents();
                roTL.reverse();
            }, 5000);
            gltl.add(this.animInCuboids()).add(this.sparkle(), "-=3.85");
        },
        resize() {
            let vw = window.innerWidth;
            let hw = this.hero.offsetWidth;
            if (vw / hw < 1.3) {
                xDist = "150vw";
            } else {
                xDist = "100vw";
            }
        },
    },
    mounted() {
        this.stage = document.querySelector(".stage");
        this.hero = document.querySelector(".hero");
        this.resize();
        this.init();
    },
};