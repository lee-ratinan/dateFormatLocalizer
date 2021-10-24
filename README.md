# dateFormatLocalizer

[![GitHub last commit](https://img.shields.io/github/last-commit/lee-ratinan/dateFormatLocalizer)](https://github.com/lee-ratinan/dateFormatLocalizer/commits/main)
[![GitHub](https://img.shields.io/github/license/lee-ratinan/dateFormatLocalizer)](https://github.com/lee-ratinan/dateFormatLocalizer/blob/main/LICENSE)
[![GitHub all releases](https://img.shields.io/github/downloads/lee-ratinan/dateFormatLocalizer/total)](https://github.com/lee-ratinan/dateFormatLocalizer/releases)
[![GitHub issues](https://img.shields.io/github/issues/lee-ratinan/dateFormatLocalizer)](https://github.com/lee-ratinan/dateFormatLocalizer/issues)

This JS/PHP library formats date into localized formats such as ROC/Reiwa/BE calendars.

## How to Use

### PHP

#### Constructor and `settings()`

Add the calendar type, locale code, and format code in either constructor or `settings()`.

**Parameters**

  * `calendar` Calendar of the output date format
  * `locale` Locale of the output date format in RFC5646 format
  * `format` Format of the date string output, either N, S, or L

#### `prepare_date()` and `format_date()`

Prepare the output date format in the calendar, locale, and format as specified in the constructor or `settings()`.

**Parameters**

  * `date_string` The date string in ISO8601 format

**Return**

`prepare_date()` will set the date in the class property `date_formatted` while `format_date()` will return such string.

#### `get_formatted_date()`

After calling `prepare_date()`, this function return the property `date_formatted` to the caller. 

#### Available Settings

  * Calendars
    * GREGORIAN: `DateFormatLocalizer::CALENDAR_GREGORIAN`
    * JAPANESE: `DateFormatLocalizer::CALENDAR_JAPANESE`
    * TAIWANESE: `DateFormatLocalizer::CALENDAR_TAIWANESE`
    * THAI: `DateFormatLocalizer::CALENDAR_THAI`
  * Locales
    * EN-US: `DateFormatLocalizer::LOCALE_ENGLISH_US`
    * EN-UK: `DateFormatLocalizer::LOCALE_ENGLISH_UK`
    * JA-JP: `DateFormatLocalizer::LOCALE_JAPANESE`
    * ZH-TW: `DateFormatLocalizer::LOCALE_CHINESE_TAIWAN`
    * ZH-CN: `DateFormatLocalizer::LOCALE_CHINESE_CHINA`
    * TH-TH: `DateFormatLocalizer::LOCALE_THAI`
  * Formats
    * N: `DateFormatLocalizer::FORMAT_NUMBERS`
    * S: `DateFormatLocalizer::FORMAT_SHORT`
    * L: `DateFormatLocalizer::FORMAT_LONG`

#### Example

```PHP
$obj = new DateFormatLocalizer();
$obj->settings('GREGORIAN', 'EN-US', 'S');
$obj->prepare_date('2021-11-15');
$json = json_encode($obj, JSON_PRETTY_PRINT);

/*
 * This will print all public properties of the class
 * Output:
 * {
 *     "date_iso8601": "2021-11-15",
 *     "date_int": 1636934400,
 *     "date_formatted": "Nov 15, 2021",
 *     "set_calendar": "GREGORIAN",
 *     "set_locale": "EN-US",
 *     "set_format": "S",
 *     "errors": []
 * }
 */
echo '<pre>' . $json . '</pre>';

/*
 * This will return and print only formatted string
 * Output: Nov 15, 2021
 */
echo $obj->get_formatted_date();
```

When the date is invalid, the class return `****-**-**`.

```PHP
$obj = new DateFormatLocalizer();
$obj->settings('GREGORIAN', 'EN-US', 'S');

/*
 * This will return invalid date format
 * Output: ****-**-**
 */
echo $obj->format_date('2021-13-32');

/*
 * This will print all public properties of the class
 * Output:
 * {
 *     "date_iso8601": "****-**-**",
 *     "date_int": 0,
 *     "date_formatted": "****-**-**",
 *     "set_calendar": "GREGORIAN",
 *     "set_locale": "EN-US",
 *     "set_format": "S",
 *     "errors": [
 *         "Date input is invalid."
 *     ]
 * }
 */
$json = json_encode($obj, JSON_PRETTY_PRINT);
echo '<pre>' . $json . '</pre>';
```

### JavaScript

This is the jQuery plugin, so jQuery JS has to be included into the HTML file first. Then, include the `DateFormatLocalizer.js` or the minified `DateFormatLocalizer.min.js`.

**Method 1:** Add `data-calendar`, `data-locale`, `data-format`, and `data-date` as the data attributes of the target element and call `.DateFormatLocalizer()` in JavaScript.

HTML:

```HTML
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="../src/js/DateFormatLocalizer.js"></script>
<div id="format-date" data-calendar="GREGORIAN" data-locale="EN-US" data-format="S" data-date="2021-11-15"></div>
```

JavaScript:

```JavaScript
$(function () {
  $('#format-date').DateFormatLocalizer();
});
```

Output:

```
Nov 15, 2021
```

**Method 2:** Only add the `data-date` in the target element and pass the `calendar`, `locale`, and `format` in the jQuery function.

HTML:

```HTML
<div id="format-date" data-date="2021-11-15"></div>
```

JavaScript:

```JavaScript
$(function () {
  $('#format-date').DateFormatLocalizer({
    'calendar': 'GREGORIAN',
    'locale': 'EN-US',
    'format': 'S'
  });
});
```

Output:

```
Nov 15, 2021
```

#### Available Settings

  * Calendars
    * GREGORIAN
    * JAPANESE
    * TAIWANESE
    * THAI
  * Locales
    * EN-US
    * EN-UK
    * JA-JP
    * ZH-TW
    * ZH-CN
    * TH-TH
  * Formats
    * N (numeric)
    * S (short)
    * L (long)

## Calendars

### Gregorian

The most popular Gregorian calendar supports all valid dates. 

### Japanese

This calendar supports all Modern Japanese eras starting from Meija Era and not a day prior to 23 Oct 1868. Here are the dates:

| First date  | Era (English) | Era (Japanese) |
|-------------|---------------|----------------|
| 23 Oct 1868 | Meiji         | 明治            |
| 30 Jul 1912 | Taishō        | 大正            |
| 25 Dec 1926 | Shōwa         | 昭和            |
| 08 Jan 1989 | Heisei        | 平成            |
| 01 May 2019 | Reiwa         | 令和            |

The Japanese calendar supports only `EN-US`, `EN-UK`, and `JA-JP`.

### Taiwanese Minguo (ROC) Calendar / 中華民國曆 / 民國紀年

This calendar is popular in Taiwan. Starting from 1912 as its first year, the calendar never supports any date priority to this year.

The Taiwanese calendar supports only `EN-US`, `EN-UK`, and `ZH-TW`.

### Thai Buddhist Calendar / พุทธศักราช

Because of the unique rules, the Buddhist calendar is diverse. This library supports the Thai version of the Buddhist calendar starting from 1941 (or 2484 BE).

The Japanese calendar supports only `EN-US`, `EN-UK`, and `TH-TH`.