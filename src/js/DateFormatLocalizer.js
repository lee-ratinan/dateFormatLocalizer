/**
 * Author Nat Lee (c) 2021
 * Free to use
 * https://github.com/lee-ratinan/dateFormatLocalizer
 */
(function ($) {
    $.fn.dateFormatLocalizer = function(options) {
        let settings = $.extend({
            calendar_code: 'GREGORIAN',
            locale_code: 'EN-US',
            format_code: 'S',
            date_string: null
        }, options);
        return this.each(function() {
            formatDate($(this), settings.calendar_code, settings.locale_code, settings.format_code, settings.date_string);
        });
    };
    function formatDate(element, calendar_code, locale_code, format_code, date_string) {
        // todo: validate inputs and format data accordingly
    }
}(jQuery));