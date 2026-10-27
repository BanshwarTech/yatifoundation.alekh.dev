(function () {
    "use strict";

    document.querySelectorAll(".app-toast").forEach(function (toast) {
        var closeButton = toast.querySelector(".app-toast-close");
        var hideTimer;

        function dismiss() {
            toast.classList.remove("is-visible");
            window.setTimeout(function () { toast.remove(); }, 240);
        }

        window.requestAnimationFrame(function () { toast.classList.add("is-visible"); });
        hideTimer = window.setTimeout(dismiss, 5200);
        if (closeButton) {
            closeButton.addEventListener("click", function () {
                window.clearTimeout(hideTimer);
                dismiss();
            });
        }
        toast.addEventListener("mouseenter", function () {
            window.clearTimeout(hideTimer);
            toast.classList.add("is-paused");
        });
        toast.addEventListener("mouseleave", function () {
            toast.classList.remove("is-paused");
            hideTimer = window.setTimeout(dismiss, 1800);
        });
    });
})();
