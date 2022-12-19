let App = (function()
{
    // THIS object
    let self = {};

    /**
     * Handle sticky navbar
     * @return void
     */
    self.stickyNav = function()
    {
        const body       = document.body;
        const scrollUp   = 'scroll-up';
        const scrollDown = 'scroll-down';

        let lastScroll = 0;

        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;

            if(currentScroll <= 0)
            {
                body.classList.remove(scrollUp);
                return;
            }

            // Down
            if(currentScroll > lastScroll && !body.classList.contains(scrollDown))
            {
                body.classList.remove(scrollUp);
                body.classList.add(scrollDown);
            }
            // Up
            else if(currentScroll < lastScroll && body.classList.contains(scrollDown))
            {
                body.classList.remove(scrollDown);
                body.classList.add(scrollUp);
            }

            lastScroll = currentScroll;
        });
    }

    /**
     * Initialize owlCarousel
     * @return void
     */
    self.owlCarousel = function()
    {
        $('[owl-carousel="main"]').owlCarousel({
            nav: false,
            loop: true,
            margin: 16,
            responsive: {
                0: { items: 1 }
            }
        });
    }

    /**
     * Initialize actions
     * @return void
     */
    self.init = function()
    {
        self.stickyNav();
        self.owlCarousel();
    }

    /**
     * Fire whole thing
     * @return void
     */
    self.__start__ = function()
    {
        // Call APP
        self.init();
    }

    return self;
}());

// Call APP when content is loaded
(document.readyState !== 'loading') ? App.__start__() : document.addEventListener('DOMContentLoaded', function() { App.__start__(); });
