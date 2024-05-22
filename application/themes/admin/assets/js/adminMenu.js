var AdminMenu = {
    openSection: function(nr) {
        // Close all other sections
        $('.admin_section').slideUp(300);
        $('.admin_section_icon').removeClass('nav-expanded');

        // Toggle the current section
        var $currentSection = $('.admin_section[nr="' + nr + '"]');
        var $currentIcon = $('.admin_section_icon[nr="' + nr + '"]');
        if ($currentSection.css('display') !== 'block') {
            $currentSection.slideDown(300);
            $currentIcon.addClass('nav-expanded');
        }
    }
};
