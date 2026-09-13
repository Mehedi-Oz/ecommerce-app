/* ============================================================== */
/* Custom admin scripts                                           */
/* ============================================================== */

$(function() {
    /* Expand/collapse a truncated description when its "Show more" link is clicked */
    $(document).on('click', '.description-toggle', function() {
        var $clamp = $(this).closest('td').find('.description-clamp');
        $clamp.toggleClass('expanded');
        $(this).text($clamp.hasClass('expanded') ? 'Show less' : 'Show more');
    });
});