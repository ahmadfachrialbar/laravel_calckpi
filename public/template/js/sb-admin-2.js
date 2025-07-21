(function ($) {
    "use strict"; // Start of use strict

    // ======= Toggle Sidebar (Desktop & Mobile) =======
    $("#sidebarToggle, #sidebarToggleTop").on("click", function (e) {
        if ($(window).width() <= 768) {
            // 👉 Mobile: gunakan mobile-open & overlay
            $("#accordionSidebar").toggleClass("mobile-open");
            $(".mobile-overlay").toggleClass("show");
        } else {
            // 👉 Desktop: gunakan bawaan SB Admin
            $("body").toggleClass("sidebar-toggled");
            $(".sidebar").toggleClass("toggled");
            if ($(".sidebar").hasClass("toggled")) {
                $(".sidebar .collapse").collapse("hide");
            }
        }
    });

    // ======= Close Sidebar Saat Resize =======
    $(window).resize(function () {
        if ($(window).width() > 768) {
            // Kembali normal saat desktop
            $("#accordionSidebar").removeClass("mobile-open");
            $(".mobile-overlay").removeClass("show");
        } else {
            // Tutup collapse menu saat mobile
            $(".sidebar .collapse").collapse("hide");
        }
    });

    // ======= Mobile Overlay =======
    if (!$(".mobile-overlay").length) {
        $("body").append('<div class="mobile-overlay"></div>');
    }

    $(document).on("click", ".mobile-overlay", function () {
        $("#accordionSidebar").removeClass("mobile-open");
        $(".mobile-overlay").removeClass("show");
    });

    // ======= Prevent Scroll Sidebar di Desktop Fixed =======
    $("body.fixed-nav .sidebar").on(
        "mousewheel DOMMouseScroll wheel",
        function (e) {
            if ($(window).width() > 768) {
                var e0 = e.originalEvent,
                    delta = e0.wheelDelta || -e0.detail;
                this.scrollTop += (delta < 0 ? 1 : -1) * 30;
                e.preventDefault();
            }
        }
    );

    // ======= Scroll to Top Button =======
    $(document).on("scroll", function () {
        var scrollDistance = $(this).scrollTop();
        if (scrollDistance > 100) {
            $(".scroll-to-top").fadeIn();
        } else {
            $(".scroll-to-top").fadeOut();
        }
    });

    // ======= Smooth Scroll =======
    $(document).on("click", "a.scroll-to-top", function (e) {
        var $anchor = $(this);
        $("html, body")
            .stop()
            .animate(
                {
                    scrollTop: $($anchor.attr("href")).offset().top,
                },
                1000,
                "easeInOutExpo"
            );
        e.preventDefault();
    });
})(jQuery); // End of use strict

