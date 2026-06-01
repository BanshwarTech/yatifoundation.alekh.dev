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

    /* ---- Animated counters ---- */
    function animateCounter(el) {
        var target = parseFloat(el.getAttribute("data-target")) || 0;
        var dur = 1600, start = null;
        function step(ts) {
            if (!start) start = ts;
            var p = Math.min((ts - start) / dur, 1);
            var eased = 1 - Math.pow(1 - p, 3);
            el.textContent = Math.floor(eased * target).toLocaleString();
            if (p < 1) requestAnimationFrame(step);
            else el.textContent = target.toLocaleString();
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
            if (amountInput) amountInput.value = chip.getAttribute("data-amount");
        });
    });

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
