var AdminMenu = {
    openSection: function(nr) {
        var $currentSection = $('.admin_section[data-nr="' + nr + '"]');
        var $currentIcon = $('.admin_section_icon[data-nr="' + nr + '"]');

        // Close all other sections
        $('.admin_section').not($currentSection).slideUp(300);
        $('.admin_section_icon').not($currentIcon).removeClass('nav-expanded');

        // Toggle the current section
        if ($currentSection.is(':visible')) {
            $currentSection.slideUp(300);
            $currentIcon.removeClass('nav-expanded');
        } else {
            $currentSection.slideDown(300);
            $currentIcon.addClass('nav-expanded');
        }
    }
};
