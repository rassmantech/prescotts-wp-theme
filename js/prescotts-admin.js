/**
 * Prescotts
 *
 * Globally used admin facing JS. Anything here should be used on multiple types of pages
 * Use the prescotts namespace when possible to avoid conflicts and preserve scope.
 */
var prescottsAdmin = {
    init: function() {
        prescottsAdmin.resetEmailCron();
    },

    resetEmailCron: function() {
        jQuery('#reset-email-cron').on('click', function() {
            console.log("click")
            jQuery.ajax({
                type: 'post',
                url: ajaxurl,
                data: {
                    'action': 'schedule_reminder_cron',
                },
                success: function(data) {
                    location.reload();
                },
            })
        })
    }
}
// Init
jQuery('document').ready(function() {
    prescottsAdmin.init();
});