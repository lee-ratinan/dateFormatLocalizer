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
                date_object = new Date(date_string + 'T00:00:00Z');
            if (isNaN(date_object.getTime()) || date_string !== date('Y-m-d', date_object.getTime() / 1000)) {
                $(this).html(error_messages['E001']);
            } else {
                formatDate($(this), calendar_code, locale_code, format_code, date_object);
            }
        });
    };
    let error_messages = {
        'E001': '[INVALID DATE]',
        'E002': '[DATE NOT SUPPORTED]'
    };
    let months_full_thai = [
        'มกราคม',
        'กุมภาพันธ์',
        'มีนาคม',
        'เมษายน',
        'พฤษภาคม',
        'มิถุนายน',
        'กรกฎาคม',
        'สิงหาคม',
        'กันยายน',
        'ตุลาคม',
        'พฤศจิกายน',
        'ธันวาคม',
    ];
    let months_abbr_thai = [
        'ม.ค.',
        'ก.พ.',
        'มี.ค.',
        'เม.ย.',
        'พ.ค.',
        'มิ.ย.',
        'ก.ค.',
        'ส.ค.',
        'ก.ย.',
        'ต.ค.',
        'พ.ย.',
        'ธ.ค.',
    ];
    /**
     * Route the formatting function according to the calendar
     * @param element
     * @param calendar_code
     * @param locale_code
     * @param format_code
     * @param date_object
     * @return void
     */
    let formatDate = function (element, calendar_code, locale_code, format_code, date_object) {
        if ('GREGORIAN' === calendar_code) {
            formatGregorianCalendar(element, locale_code, format_code, date_object);
        } else if ('JAPANESE' === calendar_code) {
            formatJapaneseCalendar(element, locale_code, format_code, date_object);
        } else if ('TAIWANESE' === calendar_code) {
            formatTaiwaneseCalendar(element, locale_code, format_code, date_object);
        } else if ('THAI' === calendar_code) {
            formatThaiCalendar(element, locale_code, format_code, date_object);
        }
    };
    /**
     * Format date in Japanese calendar
     * @param element
     * @param locale_code
     * @param format_code
     * @param date_object
     * @return void
     */
    let formatJapaneseCalendar = function (element, locale_code, format_code, date_object) {
        let date_int = date_object.getTime() / 1000,
            date_string = date('Y-m-d', date_int);
        if (date_string < '1868-10-23') {
            element.html(error_messages['E002']);
            return;
        }
        let year_ad = date('Y', date_int),
            era_name = {'en': 'Reiwa', 'ja': '令和'},
            year = year_ad - 2018;
        if (date_string < '1912-07-30') {
            era_name = {'en': 'Meiji', 'ja': '明治'};
            year = year_ad - 1867;
        } else if (date_string < '1926-12-25') {
            era_name = {'en': 'Taishō', 'ja': '大正'};
            year = year_ad - 1911;
        } else if (date_string < '1989-01-08') {
            era_name = {'en': 'Shōwa', 'ja': '昭和'};
            year = year_ad - 1925;
        } else if (date_string < '2019-05-01') {
            era_name = {'en': 'Heisei', 'ja': '平成'};
            year = year_ad - 1988;
        }
        if ('EN-US' === locale_code || 'EN-UK' === locale_code) {
            if ('N' === format_code) {
                element.html(date('d/m/', date_int) + era_name['en'].substr(0, 1) + year);
            } else if ('S' === format_code) {
                element.html(date('j M ', date_int) + era_name['en'].substr(0, 1) + year);
            } else {
                element.html(date('j F ', date_int) + era_name['en'] + year);
            }
        } else {
            if ('N' === format_code) {
                element.html(era_name['ja'].substr(0, 1) + year + date('.m.d', date_int));
            } else {
                element.html(era_name['ja'] + year + date('年m月d日', date_int));
            }
        }
    };
    /**
     * Format date in Taiwanese ROC calendar
     * @param element
     * @param locale_code
     * @param format_code
     * @param date_object
     * @return void
     */
    let formatTaiwaneseCalendar = function (element, locale_code, format_code, date_object) {
        let y = date_object.getFullYear() - 1911;
        let date_int = date_object.getTime() / 1000;
        if (1 > y) {
            element.html(error_messages['E002']);
            return;
        }
        if ('EN-US' === locale_code || 'EN-UK' === locale_code) {
            if ('N' === format_code) {
                element.html(date('d/m/', date_int) + y + ' ROC');
            } else if ('S' === format_code) {
                element.html(date('j M ', date_int) + y + ' ROC');
            } else {
                element.html(date('j F ', date_int) + y + ' ROC');
            }
        } else {
            if ('N' === format_code) {
                element.html(y + date('.m.d', date_int));
            } else if ('S' === format_code) {
                element.html(y + date('年m月d日', date_int));
            } else {
                element.html('民國' + y + date('年m月d日', date_int));
            }
        }
    };
    /**
     * Format date in Thai calendar
     * @param element
     * @param locale_code
     * @param format_code
     * @param date_object
     * @return void
     */
    let formatThaiCalendar = function (element, locale_code, format_code, date_object) {
        let year = date_object.getFullYear(),
            date_int = date_object.getTime() / 1000;
        if (1941 > year) {
            element.html(error_messages['E002']);
            return;
        }
        year += 543;
        let mm = date('n', date_int),
            mi = date_object.getMonth(),
            dd = date_object.getDate();
        if ('EN-US' === locale_code) {
            if ('N' === format_code) {
                element.html(mm + '/' + dd + '/' + year + ' BE');
            } else if ('S' === format_code) {
                element.html(date('M j, ', date_int) + year + ' BE');
            } else {
                element.html(date('F j, ', date_int) + year + ' BE');
            }
        } else if ('EN-UK' === locale_code) {
            if ('N' === format_code) {
                element.html(dd + '/' + mm + '/' + year + ' BE');
            } else if ('S' === format_code) {
                element.html(date('j M ', date_int) + year + ' BE');
            } else {
                element.html(date('j F ', date_int) + year + ' BE');
            }
        } else {
            if ('N' === format_code) {
                element.html(dd + '/' + mm + '/' + year);
            } else if ('S' === format_code) {
                element.html(dd + ' ' + months_abbr_thai[mi] + ' ' + year);
            } else {
                element.html(dd + ' ' + months_full_thai[mi] + ' พ.ศ. ' + year);
            }
        }
    };
    /**
     * Format date in Gregorian calendar
     * @param element
     * @param locale_code
     * @param format_code
     * @param date_object
     * @return void
     */
    let formatGregorianCalendar = function (element, locale_code, format_code, date_object) {
        let date_int = date_object.getTime() / 1000;
        if ('EN-US' === locale_code) {
            if ('N' === format_code) {
                element.html(date('m/d/y', date_int));
            } else if ('S' === format_code) {
                element.html(date('M j, Y', date_int));
            } else {
                element.html(date('F j, Y', date_int));
            }
        } else if ('EN-UK' === locale_code) {
            if ('N' === format_code) {
                element.html(date('d/m/y', date_int));
            } else if ('S' === format_code) {
                element.html(date('j M Y', date_int));
            } else {
                element.html(date('j F Y', date_int));
            }
        } else if ('JA-JP' === locale_code) {
            if ('N' === format_code) {
                element.html(date('Y.m.d', date_int));
            } else {
                element.html(date('Y年m月d日', date_int));
            }
        } else if ('ZH-CN' === locale_code || 'ZH-TW' === locale_code) {
            if ('N' === format_code) {
                element.html(date('Y-m-d', date_int));
            } else {
                element.html(date('Y年m月d日', date_int));
            }
        } else if ('TH-TH' === locale_code) {
            let d = date_object.getDate(),
                mi = date_object.getMonth(),
                y = date_object.getFullYear();
            if ('N' === format_code) {
                element.html(date('d/m/y', date_int));
            } else if ('S' === format_code) {
                element.html(d + ' ' + months_abbr_thai[mi] + ' ' + y);
            } else {
                element.html(d + ' ' + months_full_thai[mi] + ' ' + y);
            }
        }
    };
    /**
     * LOCUSTUS FUNCTION
     * Format date the same way as PHP date() function
     * @param format
     * @param timestamp
     * @returns string
     */
    let date = function (format, timestamp) {
        //  discuss at: https://locutus.io/php/date/
        // original by: Carlos R. L. Rodrigues (https://www.jsfromhell.com)
        // original by: gettimeofday
        //    parts by: Peter-Paul Koch (https://www.quirksmode.org/js/beat.html)
        // improved by: Kevin van Zonneveld (https://kvz.io)
        // improved by: MeEtc (https://yass.meetcweb.com)
        // improved by: Brad Touesnard
        // improved by: Tim Wiel
        // improved by: Bryan Elliott
        // improved by: David Randall
        // improved by: Theriault (https://github.com/Theriault)
        // improved by: Theriault (https://github.com/Theriault)
        // improved by: Brett Zamir (https://brett-zamir.me)
        // improved by: Theriault (https://github.com/Theriault)
        // improved by: Thomas Beaucourt (https://www.webapp.fr)
        // improved by: JT
        // improved by: Theriault (https://github.com/Theriault)
        // improved by: Rafał Kukawski (https://blog.kukawski.pl)
        // improved by: Theriault (https://github.com/Theriault)
        //    input by: Brett Zamir (https://brett-zamir.me)
        //    input by: majak
        //    input by: Alex
        //    input by: Martin
        //    input by: Alex Wilson
        //    input by: Haravikk
        // bugfixed by: Kevin van Zonneveld (https://kvz.io)
        // bugfixed by: majak
        // bugfixed by: Kevin van Zonneveld (https://kvz.io)
        // bugfixed by: Brett Zamir (https://brett-zamir.me)
        // bugfixed by: omid (https://locutus.io/php/380:380#comment_137122)
        // bugfixed by: Chris (https://www.devotis.nl/)
        //      note 1: Uses global: locutus to store the default timezone
        //      note 1: Although the function potentially allows timezone info
        //      note 1: (see notes), it currently does not set
        //      note 1: per a timezone specified by date_default_timezone_set(). Implementers might use
        //      note 1: $locutus.currentTimezoneOffset and
        //      note 1: $locutus.currentTimezoneDST set by that function
        //      note 1: in order to adjust the dates in this function
        //      note 1: (or our other date functions!) accordingly
        //   example 1: date('H:m:s \\m \\i\\s \\m\\o\\n\\t\\h', 1062402400)
        //   returns 1: '07:09:40 m is month'
        //   example 2: date('F j, Y, g:i a', 1062462400)
        //   returns 2: 'September 2, 2003, 12:26 am'
        //   example 3: date('Y W o', 1062462400)
        //   returns 3: '2003 36 2003'
        //   example 4: var $x = date('Y m d', (new Date()).getTime() / 1000)
        //   example 4: $x = $x + ''
        //   example 4: var $result = $x.length // 2009 01 09
        //   returns 4: 10
        //   example 5: date('W', 1104534000)
        //   returns 5: '52'
        //   example 6: date('B t', 1104534000)
        //   returns 6: '999 31'
        //   example 7: date('W U', 1293750000.82); // 2010-12-31
        //   returns 7: '52 1293750000'
        //   example 8: date('W', 1293836400); // 2011-01-01
        //   returns 8: '52'
        //   example 9: date('W Y-m-d', 1293974054); // 2011-01-02
        //   returns 9: '52 2011-01-02'
        //        test: skip-1 skip-2 skip-5
        let jsdate, f
        // Keep this here (works, but for code commented-out below for file size reasons)
        // var tal= [];
        const txtWords = [
            'Sun', 'Mon', 'Tues', 'Wednes', 'Thurs', 'Fri', 'Satur',
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ]
        // trailing backslash -> (dropped)
        // a backslash followed by any character (including backslash) -> the character
        // empty string -> empty string
        const formatChr = /\\?(.?)/gi
        const formatChrCb = function (t, s) {
            return f[t] ? f[t]() : s
        }
        const _pad = function (n, c) {
            n = String(n)
            while (n.length < c) {
                n = '0' + n
            }
            return n
        }
        f = {
            // Day
            d: function () {
                // Day of month w/leading 0; 01..31
                return _pad(f.j(), 2)
            },
            D: function () {
                // Shorthand day name; Mon...Sun
                return f.l()
                    .slice(0, 3)
            },
            j: function () {
                // Day of month; 1..31
                return jsdate.getDate()
            },
            l: function () {
                // Full day name; Monday...Sunday
                return txtWords[f.w()] + 'day'
            },
            N: function () {
                // ISO-8601 day of week; 1[Mon]..7[Sun]
                return f.w() || 7
            },
            S: function () {
                // Ordinal suffix for day of month; st, nd, rd, th
                const j = f.j()
                let i = j % 10
                if (i <= 3 && parseInt((j % 100) / 10, 10) === 1) {
                    i = 0
                }
                return ['st', 'nd', 'rd'][i - 1] || 'th'
            },
            w: function () {
                // Day of week; 0[Sun]..6[Sat]
                return jsdate.getDay()
            },
            z: function () {
                // Day of year; 0..365
                const a = new Date(f.Y(), f.n() - 1, f.j())
                const b = new Date(f.Y(), 0, 1)
                return Math.round((a - b) / 864e5)
            },
            // Week
            W: function () {
                // ISO-8601 week number
                const a = new Date(f.Y(), f.n() - 1, f.j() - f.N() + 3)
                const b = new Date(a.getFullYear(), 0, 4)
                return _pad(1 + Math.round((a - b) / 864e5 / 7), 2)
            },
            // Month
            F: function () {
                // Full month name; January...December
                return txtWords[6 + f.n()]
            },
            m: function () {
                // Month w/leading 0; 01...12
                return _pad(f.n(), 2)
            },
            M: function () {
                // Shorthand month name; Jan...Dec
                return f.F()
                    .slice(0, 3)
            },
            n: function () {
                // Month; 1...12
                return jsdate.getMonth() + 1
            },
            t: function () {
                // Days in month; 28...31
                return (new Date(f.Y(), f.n(), 0))
                    .getDate()
            },
            // Year
            L: function () {
                // Is leap year?; 0 or 1
                const j = f.Y()
                return j % 4 === 0 & j % 100 !== 0 | j % 400 === 0
            },
            o: function () {
                // ISO-8601 year
                const n = f.n()
                const W = f.W()
                const Y = f.Y()
                return Y + (n === 12 && W < 9 ? 1 : n === 1 && W > 9 ? -1 : 0)
            },
            Y: function () {
                // Full year; e.g. 1980...2010
                return jsdate.getFullYear()
            },
            y: function () {
                // Last two digits of year; 00...99
                return f.Y()
                    .toString()
                    .slice(-2)
            },
            // Time
            a: function () {
                // am or pm
                return jsdate.getHours() > 11 ? 'pm' : 'am'
            },
            A: function () {
                // AM or PM
                return f.a()
                    .toUpperCase()
            },
            B: function () {
                // Swatch Internet time; 000..999
                const H = jsdate.getUTCHours() * 36e2
                // Hours
                const i = jsdate.getUTCMinutes() * 60
                // Minutes
                // Seconds
                const s = jsdate.getUTCSeconds()
                return _pad(Math.floor((H + i + s + 36e2) / 86.4) % 1e3, 3)
            },
            g: function () {
                // 12-Hours; 1..12
                return f.G() % 12 || 12
            },
            G: function () {
                // 24-Hours; 0..23
                return jsdate.getHours()
            },
            h: function () {
                // 12-Hours w/leading 0; 01..12
                return _pad(f.g(), 2)
            },
            H: function () {
                // 24-Hours w/leading 0; 00..23
                return _pad(f.G(), 2)
            },
            i: function () {
                // Minutes w/leading 0; 00..59
                return _pad(jsdate.getMinutes(), 2)
            },
            s: function () {
                // Seconds w/leading 0; 00..59
                return _pad(jsdate.getSeconds(), 2)
            },
            u: function () {
                // Microseconds; 000000-999000
                return _pad(jsdate.getMilliseconds() * 1000, 6)
            },
            // Timezone
            e: function () {
                // Timezone identifier; e.g. Atlantic/Azores, ...
                // The following works, but requires inclusion of the very large
                // timezone_abbreviations_list() function.
                /*              return that.date_default_timezone_get();
                 */
                const msg = 'Not supported (see source code of date() for timezone on how to add support)'
                throw new Error(msg)
            },
            I: function () {
                // DST observed?; 0 or 1
                // Compares Jan 1 minus Jan 1 UTC to Jul 1 minus Jul 1 UTC.
                // If they are not equal, then DST is observed.
                const a = new Date(f.Y(), 0)
                // Jan 1
                const c = Date.UTC(f.Y(), 0)
                // Jan 1 UTC
                const b = new Date(f.Y(), 6)
                // Jul 1
                // Jul 1 UTC
                const d = Date.UTC(f.Y(), 6)
                return ((a - c) !== (b - d)) ? 1 : 0
            },
            O: function () {
                // Difference to GMT in hour format; e.g. +0200
                const tzo = jsdate.getTimezoneOffset()
                const a = Math.abs(tzo)
                return (tzo > 0 ? '-' : '+') + _pad(Math.floor(a / 60) * 100 + a % 60, 4)
            },
            P: function () {
                // Difference to GMT w/colon; e.g. +02:00
                const O = f.O()
                return (O.substr(0, 3) + ':' + O.substr(3, 2))
            },
            T: function () {
                // The following works, but requires inclusion of the very
                // large timezone_abbreviations_list() function.
                /*              var abbr, i, os, _default;
                if (!tal.length) {
                  tal = that.timezone_abbreviations_list();
                }
                if ($locutus && $locutus.default_timezone) {
                  _default = $locutus.default_timezone;
                  for (abbr in tal) {
                    for (i = 0; i < tal[abbr].length; i++) {
                      if (tal[abbr][i].timezone_id === _default) {
                        return abbr.toUpperCase();
                      }
                    }
                  }
                }
                for (abbr in tal) {
                  for (i = 0; i < tal[abbr].length; i++) {
                    os = -jsdate.getTimezoneOffset() * 60;
                    if (tal[abbr][i].offset === os) {
                      return abbr.toUpperCase();
                    }
                  }
                }
                */
                return 'UTC'
            },
            Z: function () {
                // Timezone offset in seconds (-43200...50400)
                return -jsdate.getTimezoneOffset() * 60
            },

            // Full Date/Time
            c: function () {
                // ISO-8601 date.
                return 'Y-m-d\\TH:i:sP'.replace(formatChr, formatChrCb)
            },
            r: function () {
                // RFC 2822
                return 'D, d M Y H:i:s O'.replace(formatChr, formatChrCb)
            },
            U: function () {
                // Seconds since UNIX epoch
                return jsdate / 1000 | 0
            }
        }
        const _date = function (format, timestamp) {
            jsdate = (timestamp === undefined
                    ? new Date() // Not provided
                    : (timestamp instanceof Date)
                        ? new Date(timestamp) // JS Date()
                        : new Date(timestamp * 1000) // UNIX timestamp (auto-convert to int)
            )
            return format.replace(formatChr, formatChrCb)
        }
        return _date(format, timestamp)
    }
}(jQuery));