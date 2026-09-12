<script src="{{ asset('assets/frontend/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/tiny-slider.js') }}"></script>
<script src="{{ asset('assets/frontend/js/glightbox.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/main.js') }}"></script>
<script type="text/javascript">
    //========= Hero Slider
    if (document.querySelector('.hero-slider')) {
        tns({
            container: '.hero-slider',
            slideBy: 'page',
            autoplay: true,
            autoplayButtonOutput: false,
            mouseDrag: true,
            gutter: 0,
            items: 1,
            nav: false,
            controls: true,
            controlsText: ['<i class="lni lni-chevron-left"></i>', '<i class="lni lni-chevron-right"></i>'],
        });
    }

    //======== Brand Slider
    if (document.querySelector('.brands-logo-carousel')) {
        tns({
            container: '.brands-logo-carousel',
            autoplay: true,
            autoplayButtonOutput: false,
            mouseDrag: true,
            gutter: 15,
            nav: false,
            controls: false,
            responsive: {
                0: {
                    items: 1,
                },
                540: {
                    items: 3,
                },
                768: {
                    items: 5,
                },
                992: {
                    items: 6,
                }
            }
        });
    }
</script>
<script>
    (function () {
        const daysEl = document.querySelector('#days');
        const hoursEl = document.querySelector('#hours');
        const minutesEl = document.querySelector('#minutes');
        const secondsEl = document.querySelector('#seconds');
        const expiredEl = document.querySelector('.offer-expired-alert');

        if (!daysEl || !hoursEl || !minutesEl || !secondsEl) {
            return;
        }

        const finaleDate = new Date("February 15, 2023 00:00:00").getTime();

        const pad = (value) => (value <= 9 ? `0${value}` : `${value}`);

        const timer = () => {
            const diff = finaleDate - new Date().getTime();

            if (diff < 0) {
                daysEl.textContent = '00';
                hoursEl.textContent = '00';
                minutesEl.textContent = '00';
                secondsEl.textContent = '00';

                if (expiredEl) {
                    expiredEl.style.display = 'block';
                }

                return;
            }

            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor(diff % (1000 * 60 * 60 * 24) / (1000 * 60 * 60));
            const minutes = Math.floor(diff % (1000 * 60 * 60) / (1000 * 60));
            const seconds = Math.floor(diff % (1000 * 60) / 1000);

            daysEl.textContent = days <= 99 ? (days <= 9 ? `00${days}` : `0${days}`) : days;
            hoursEl.textContent = pad(hours);
            minutesEl.textContent = pad(minutes);
            secondsEl.textContent = pad(seconds);
        };

        timer();
        setInterval(timer, 1000);
    })();
</script>