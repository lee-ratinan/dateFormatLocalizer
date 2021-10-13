# dateFormatLocalizer
This JS/PHP library formats date into localized formats such as ROC/Reiwa/BE calendars

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
    * L:  `DateFormatLocalizer::FORMAT_LONG`

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