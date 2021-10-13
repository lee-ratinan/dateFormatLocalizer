/**
 * Author Nat Lee (c) 2021
 * Free to use
 * https://github.com/lee-ratinan/dateFormatLocalizer
 */
(function ($) {
    $.fn.dateFormatLocalizer = function (options) {
        let settings = $.extend({
            calendar_code: 'GREGORIAN',
            locale_code: 'EN-US',
            format_code: 'S',
            date_string: null
        }, options);
        return this.each(function () {
            // CALENDAR
            let calendar_code = $(this).data('calendar') || settings.calendar_code;
            if (calendar_code !== 'GREGORIAN' && calendar_code !== 'JAPANESE' && calendar_code !== 'TAIWANESE' && calendar_code !== 'THAI') {
                calendar_code = 'GREGORIAN';
            }
            // LOCALE
            let locale_code = $(this).data('locale') || settings.locale_code;
            if (locale_code !== 'EN-US' && locale_code !== 'EN-UK' && locale_code !== 'JA-JP' &&
                locale_code !== 'ZH-TW' && locale_code !== 'ZH-CN' && locale_code !== 'TH-TH') {
                locale_code = 'EN-US';
            }
            // FORMAT
            let format_code = $(this).data('format') || settings.format_code;
            if (format_code !== 'N' && format_code !== 'S' && format_code !== 'L') {
                format_code = 'S';
            }
            // VALIDATE LOCALE
            if (calendar_code === 'JAPANESE') {
                if (locale_code !== 'JA-JP' && locale_code !== 'EN-US' && locale_code !== 'EN-UK') {
                    locale_code = 'JA-JP';
                }
            } else if (calendar_code === 'TAIWANESE') {
                if (locale_code !== 'ZH-TW' && locale_code !== 'EN-US' && locale_code !== 'EN-UK') {
                    locale_code = 'ZH-TW';
                }
            } else if (calendar_code === 'THAI') {
                if (locale_code !== 'TH-TH' && locale_code !== 'EN-US' && locale_code !== 'EN-UK') {
                    locale_code = 'TH-TH';
                }
            }
            // CHECK DATE > ISO8601
            let date_string = $(this).data('date') || settings.date_string,
                date_object = new Date(date_string + 'T00:00:00Z'),
                date_validator = date_object.toISOString().substr(0, 10);
            if (date_string === date_validator) {
                formatDate($(this), calendar_code, locale_code, format_code, date_string);
            }
        });
    };
    let formatDate = function (element, calendar_code, locale_code, format_code, date_string) {
        if ('GREGORIAN' === calendar_code) {
            formatGregorianCalendar(element, locale_code, format_code, date_string);
        } else if ('JAPANESE' === calendar_code) {
            formatJapaneseCalendar(element, locale_code, format_code, date_string);
        } else if ('TAIWANESE' === calendar_code) {
            formatTaiwaneseCalendar(element, locale_code, format_code, date_string);
        } else if ('THAI' === calendar_code) {
            formatThaiCalendar(element, locale_code, format_code, date_string);
        }
    };
    let formatJapaneseCalendar = function (element, locale_code, format_code, date_string) {
        let string = date_string;
        element.html(string);
    };
    let formatTaiwaneseCalendar = function (element, locale_code, format_code, date_string) {
        let string = date_string;
        element.html(string);
    };
    let formatThaiCalendar = function (element, locale_code, format_code, date_string) {
        let string = date_string;
        element.html(string);
    };
    let formatGregorianCalendar = function (element, locale_code, format_code, date_string) {
        let string = date_string;
        element.html(string);
    };
}(jQuery));