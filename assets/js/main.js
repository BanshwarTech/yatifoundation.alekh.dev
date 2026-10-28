/* Yati Foundation — front-end interactions (vanilla JS, no jQuery) */
(function () {
    "use strict";

    /* ---- Preloader ---- */
    window.addEventListener("load", function () {
        var pre = document.getElementById("js-preloader");
        if (pre) pre.classList.add("loaded");
    });

    /* ---- Sticky header shadow ---- */
    var header = document.getElementById("siteHeader");
    function onScroll() {
        if (!header) return;
        header.classList.toggle("scrolled", window.scrollY > 20);
    }
    window.addEventListener("scroll", onScroll, { passive: true });
    onScroll();

    /* ---- Back to top ---- */
    var backToTop = document.getElementById("backToTop");
    if (backToTop) {
        function updateBackToTop() {
            backToTop.classList.toggle("is-visible", window.scrollY > 360);
        }
        window.addEventListener("scroll", updateBackToTop, { passive: true });
        updateBackToTop();
        backToTop.addEventListener("click", function () {
            window.scrollTo({
                top: 0,
                behavior: window.matchMedia("(prefers-reduced-motion: reduce)").matches ? "auto" : "smooth"
            });
        });
    }

    /* ---- Mobile nav toggle ---- */
    var toggle = document.getElementById("navToggle");
    var nav = document.getElementById("mainNav");
    if (toggle && nav) {
        toggle.addEventListener("click", function () {
            var open = nav.classList.toggle("open");
            toggle.setAttribute("aria-expanded", open ? "true" : "false");
            toggle.innerHTML = open ? '<i class="fa fa-times"></i>' : '<i class="fa fa-bars"></i>';
        });
        nav.querySelectorAll("a.nav-link").forEach(function (link) {
            link.addEventListener("click", function () {
                nav.classList.remove("open");
                toggle.setAttribute("aria-expanded", "false");
                toggle.innerHTML = '<i class="fa fa-bars"></i>';
            });
        });
    }

    /* ---- Smooth homepage hero cross-fade ---- */
    var heroCarousel = document.getElementById("heroCarousel");
    if (heroCarousel) {
        var heroSlides = Array.from(heroCarousel.querySelectorAll(".carousel-item"));
        var heroDots = Array.from(heroCarousel.querySelectorAll("[data-hero-slide-to]"));
        var heroIndex = Math.max(0, heroSlides.findIndex(function (slide) { return slide.classList.contains("active"); }));
        var heroTimer = null;
        var heroCleanupTimers = new WeakMap();
        var heroPaused = false;
        var heroDuration = 8500;
        var heroFadeDuration = 1250;

        function scheduleHero() {
            window.clearTimeout(heroTimer);
            if (heroPaused || heroSlides.length < 2) return;
            heroTimer = window.setTimeout(function () { showHero(heroIndex + 1); }, heroDuration);
        }

        function showHero(targetIndex) {
            if (heroSlides.length < 2) return;
            var nextIndex = (targetIndex + heroSlides.length) % heroSlides.length;
            if (nextIndex === heroIndex) { scheduleHero(); return; }
            var previous = heroSlides[heroIndex];
            var next = heroSlides[nextIndex];
            window.clearTimeout(heroCleanupTimers.get(previous));
            window.clearTimeout(heroCleanupTimers.get(next));
            next.classList.remove("is-leaving");
            previous.classList.remove("active");
            previous.classList.add("is-leaving");
            next.classList.add("active");
            heroCleanupTimers.set(previous, window.setTimeout(function () {
                previous.classList.remove("is-leaving");
                heroCleanupTimers.delete(previous);
            }, heroFadeDuration));
            heroDots.forEach(function (dot, index) {
                var active = index === nextIndex;
                dot.classList.toggle("active", active);
                if (active) dot.setAttribute("aria-current", "true");
                else dot.removeAttribute("aria-current");
            });
            heroIndex = nextIndex;
            scheduleHero();
        }

        heroCarousel.querySelectorAll("[data-hero-prev]").forEach(function (button) {
            button.addEventListener("click", function () { showHero(heroIndex - 1); });
        });
        heroCarousel.querySelectorAll("[data-hero-next]").forEach(function (button) {
            button.addEventListener("click", function () { showHero(heroIndex + 1); });
        });
        heroDots.forEach(function (dot) {
            dot.addEventListener("click", function () { showHero(Number(dot.getAttribute("data-hero-slide-to")) || 0); });
        });
        heroCarousel.addEventListener("mouseenter", function () { heroPaused = true; window.clearTimeout(heroTimer); });
        heroCarousel.addEventListener("mouseleave", function () { heroPaused = false; scheduleHero(); });
        heroCarousel.addEventListener("focusin", function () { heroPaused = true; window.clearTimeout(heroTimer); });
        heroCarousel.addEventListener("focusout", function (event) {
            if (!heroCarousel.contains(event.relatedTarget)) { heroPaused = false; scheduleHero(); }
        });
        scheduleHero();
    }

    /* ---- Animated counters ---- */
    function animateCounter(el) {
        var target = parseFloat(el.getAttribute("data-target")) || 0;
        var suffix = el.getAttribute("data-suffix") || "";
        var dur = 1600, start = null;
        function step(ts) {
            if (!start) start = ts;
            var p = Math.min((ts - start) / dur, 1);
            var eased = 1 - Math.pow(1 - p, 3);
            el.textContent = Math.floor(eased * target).toLocaleString() + suffix;
            if (p < 1) requestAnimationFrame(step);
            else el.textContent = target.toLocaleString() + suffix;
        }
        requestAnimationFrame(step);
    }

    /* ---- Scroll reveal + counter trigger ---- */
    var io;
    if ("IntersectionObserver" in window) {
        io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                entry.target.classList.add("in");
                if (entry.target.classList.contains("stat-num")) {
                    animateCounter(entry.target);
                }
                io.unobserve(entry.target);
            });
        }, { threshold: 0.18 });

        document.querySelectorAll(".reveal, .stat-num").forEach(function (el) {
            io.observe(el);
        });
    } else {
        document.querySelectorAll(".reveal").forEach(function (el) { el.classList.add("in"); });
        document.querySelectorAll(".stat-num").forEach(animateCounter);
    }

    /* ---- Donate amount chips ---- */
    var chips = document.querySelectorAll(".amount-chip");
    var amountInput = document.getElementById("amount");
    chips.forEach(function (chip) {
        chip.addEventListener("click", function () {
            chips.forEach(function (c) { c.classList.remove("active"); });
            chip.classList.add("active");
            if (amountInput) {
                amountInput.value = chip.getAttribute("data-amount");
                amountInput.dispatchEvent(new Event("input", { bubbles: true }));
            }
        });
    });
    var currencyHint = document.getElementById("amountCurrencyHint");
    if (amountInput && currencyHint) {
        var usdToInr = Number(currencyHint.getAttribute("data-usd-to-inr"));
        var updateCurrencyHint = function () {
            var amount = Number(amountInput.value);
            currencyHint.textContent = amount > 0 && usdToInr > 0
                ? "Approx. $" + (amount / usdToInr).toFixed(2) + " USD; payment is charged as \u20B9" + amount.toLocaleString("en-IN") + " INR."
                : "Approximate USD equivalent only; payments are charged in INR (1 USD \u2248 \u20B9" + usdToInr.toFixed(2) + ").";
        };
        amountInput.addEventListener("input", function () {
            chips.forEach(function (chip) { chip.classList.toggle("active", Number(chip.getAttribute("data-amount")) === Number(amountInput.value)); });
            updateCurrencyHint();
        });
        updateCurrencyHint();
    }

    /* ---- Gallery lightbox ---- */
    var lightbox = document.getElementById("lightbox");
    if (lightbox) {
        var lbImg = lightbox.querySelector("img");
        document.querySelectorAll("[data-lightbox]").forEach(function (item) {
            item.addEventListener("click", function (e) {
                e.preventDefault();
                lbImg.src = item.getAttribute("data-lightbox");
                lightbox.classList.add("open");
            });
        });
        lightbox.addEventListener("click", function () { lightbox.classList.remove("open"); });
    }
})();
