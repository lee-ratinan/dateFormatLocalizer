<?php

/**
 * Class DateFormatLocalizer
 */
class DateFormatLocalizer {

    /**
     * CALENDAR
     */
    const CALENDAR_GREGORIAN = 'GREGORIAN';
    const CALENDAR_JAPANESE = 'JAPANESE';
    const CALENDAR_TAIWANESE = 'TAIWANESE';
    const CALENDAR_THAI = 'THAI';

    /**
     * LOCALE
     */
    const LOCALE_ENGLISH_US = 'EN-US';
    const LOCALE_ENGLISH_UK = 'EN-UK';
    const LOCALE_JAPANESE = 'JA-JP';
    const LOCALE_CHINESE_TAIWAN = 'ZH-TW';
    const LOCALE_CHINESE_CHINA = 'ZH-CN';
    const LOCALE_THAI = 'TH-TH';

    /**
     * FORMAT
     */
    const FORMAT_NUMBERS = 'N';
    const FORMAT_SHORT = 'S';
    const FORMAT_LONG = 'L';

    /**
     * OTHERS
     */
    const DATE_FORMAT_ISO8601 = 'Y-m-d';
    const INVALID_DATE_FORMAT = '****-**-**';

    private $supported_calendar = [
        self::CALENDAR_GREGORIAN,
        self::CALENDAR_JAPANESE,
        self::CALENDAR_TAIWANESE,
        self::CALENDAR_THAI
    ];
    private $supported_locale = [
        self::LOCALE_ENGLISH_US,
        self::LOCALE_ENGLISH_UK,
        self::LOCALE_JAPANESE,
        self::LOCALE_CHINESE_TAIWAN,
        self::LOCALE_CHINESE_CHINA,
        self::LOCALE_THAI
    ];
    private $supported_format = [
        self::FORMAT_NUMBERS,
        self::FORMAT_SHORT,
        self::FORMAT_LONG
    ];
    private $error_messages = [
        'E001' => 'Date input is invalid.',
        'E002' => 'Input date is not supported by the calendar.'
    ];

    /**
     * @var string $date_iso8601 ISO8601 date string (input) - YYYY-MM-DD
     */
    public $date_iso8601;

    /**
     * @var int $date_int Date in integer format
     */
    public $date_int;

    /**
     * @var string $date_formatted Formatted date
     */
    public $date_formatted;

    /**
     * @var string $set_calendar Calendar setting: supported calendar
     */
    public $set_calendar;

    /**
     * @var string $set_locale Locale setting: RFC5646 (ISO639-ISO3166 language code and country code)
     */
    public $set_locale;

    /**
     * @var string $format Format setting: Numbers, Short, or Long
     */
    public $set_format;

    /**
     * @var string[] $errors Error message(s)
     */
    public $errors = [];

    /**
     * MONTHS IN LANGUAGES
     */
    private $months_full_thai = [
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
    private $months_abbr_thai = [
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
     * DateFormatLocalizer constructor.
     * @param string $calendar
     * @param string $locale
     * @param string $format
     */
    public function __construct($calendar = '', $locale = '', $format = '')
    {
        $this->settings($calendar, $locale, $format);
    }

    /**
     * Add settings and validate inputs
     * @param $calendar
     * @param $locale
     * @param $format
     */
    public function settings($calendar, $locale, $format)
    {
        if (in_array($calendar, $this->supported_calendar))
        {
            $this->set_calendar = $calendar;
        }
        if (in_array($locale, $this->supported_locale))
        {
            $this->set_locale = $locale;
        }
        if (in_array($format, $this->supported_format))
        {
            $this->set_format = $format;
        }
        // RESET FORMAT TO DEFAULT FORMAT IF NOT SUPPORTED BY CALENDAR
        switch ($this->set_calendar)
        {
            case self::CALENDAR_JAPANESE:
                if ( ! in_array($this->set_locale, [self::LOCALE_JAPANESE, self::LOCALE_ENGLISH_UK, self::LOCALE_ENGLISH_US]))
                {
                    $this->set_locale = self::LOCALE_JAPANESE;
                }
                break;
            case self::CALENDAR_TAIWANESE:
                if ( ! in_array($this->set_locale, [self::LOCALE_CHINESE_TAIWAN, self::LOCALE_ENGLISH_UK, self::LOCALE_ENGLISH_US]))
                {
                    $this->set_locale = self::LOCALE_CHINESE_TAIWAN;
                }
                break;
            case self::CALENDAR_THAI:
                if ( ! in_array($this->set_locale, [self::LOCALE_THAI, self::LOCALE_ENGLISH_UK, self::LOCALE_ENGLISH_US]))
                {
                    $this->set_locale = self::LOCALE_THAI;
                }
                break;
        }
    }

    /**
     * Return formatted date according to the formats in settings and the date input
     * @param string $date_string ISO8601 date string to be formatted
     * @return string Formatted date
     */
    public function format_date($date_string)
    {
        $this->prepare_date($date_string);
        return $this->date_formatted;
    }

    /**
     * Just return formatted date after the date is prepared
     * @return string Formatted date
     */
    public function get_formatted_date()
    {
        return $this->date_formatted;
    }

    /**
     * Set $date_formatted according to the formats in settings and the date input
     * @param string $date_string ISO8601 date string to be formatted
     */
    public function prepare_date($date_string)
    {
        $date_int = strtotime($date_string);
        $date_validate = date(self::DATE_FORMAT_ISO8601, $date_int);
        if ($date_string != $date_validate)
        {
            // DATE IS INVALID
            $this->date_int = 0;
            $this->date_iso8601 = self::INVALID_DATE_FORMAT;
            $this->date_formatted = self::INVALID_DATE_FORMAT;
            $this->errors[] = $this->error_messages['E001'];
            return;
        }
        $this->date_int = $date_int;
        $this->date_iso8601 = $date_validate;
        // PREPARE DATE
        switch ($this->set_calendar)
        {
            case self::CALENDAR_JAPANESE:
                $this->format_japanese_calendar();
                break;
            case self::CALENDAR_THAI:
                $this->format_thai_calendar();
                break;
            case self::CALENDAR_TAIWANESE:
                $this->format_taiwanese_calendar();
                break;
            case self::CALENDAR_GREGORIAN:
                $this->format_gregorian_calendar();
                break;
        }
    }

    /**
     * Format Japanese calendar
     * Calendar starts from 23 October 1868
     * Start date of each era in Modern Japan:
     * 1868-10-23 Meiji  明治 (M)
     * 1912-07-30 Taishō 大正 (T)
     * 1926-12-25 Shōwa  昭和 (S)
     * 1989-01-08 Heisei 平成 (H)
     * 2019-05-01 Reiwa  令和 (R)
     */
    private function format_japanese_calendar()
    {
        $date_string = $this->date_iso8601;
        if ($date_string < '1868-10-23')
        {
            $this->date_formatted = self::INVALID_DATE_FORMAT;
            $this->errors[] = $this->error_messages['E002'];
            return;
        }
        $year_ad = date('Y', $this->date_int);
        $era_name = ['en' => 'Reiwa', 'ja' => '令和'];
        $year = $year_ad-2018;
        if ($date_string < '1912-07-30')
        {
            $era_name = ['en' => 'Meiji', 'ja' => '明治'];
            $year = $year_ad-1867;
        } elseif ($date_string < '1926-12-25')
        {
            $era_name = ['en' => 'Taishō', 'ja' => '大正'];
            $year = $year_ad-1911;
        } elseif ($date_string < '1989-01-08')
        {
            $era_name = ['en' => 'Shōwa', 'ja' => '昭和'];
            $year = $year_ad-1925;
        } elseif ($date_string < '2019-05-01')
        {
            $era_name = ['en' => 'Heisei', 'ja' => '平成'];
            $year = $year_ad-1988;
        }
        if (self::LOCALE_ENGLISH_US == $this->set_locale || self::LOCALE_ENGLISH_UK == $this->set_locale)
        {
            switch ($this->set_format)
            {
                case self::FORMAT_NUMBERS:
                    $this->date_formatted = date('d/m/', $this->date_int) . substr($era_name['en'], 0, 1) . $year;
                    break;
                case self::FORMAT_SHORT:
                    $this->date_formatted = date('j M ', $this->date_int) . substr($era_name['en'], 0, 1) . $year;
                    break;
                case self::FORMAT_LONG:
                    $this->date_formatted = date('j F ', $this->date_int) . $era_name['en'] . ' ' . $year;
            }
        } else {
            switch ($this->set_format)
            {
                case self::FORMAT_NUMBERS:
                    $this->date_formatted = mb_substr($era_name['ja'], 0, 1) . $year . date('.m.d', $this->date_int);
                    break;
                case self::FORMAT_SHORT:
                case self::FORMAT_LONG:
                    $this->date_formatted = $era_name['ja'] . $year . date('年m月d日', $this->date_int);
                    break;
            }
        }
    }

    /**
     * Format Thai Buddhist calendar
     * Calendar starts from 1 January 1941 (2484 BE)
     */
    private function format_thai_calendar()
    {
        $year = intval(date('Y', $this->date_int));
        if (1941 > $year)
        {
            $this->date_formatted = self::INVALID_DATE_FORMAT;
            $this->errors[] = $this->error_messages['E002'];
            return;
        }
        $year += 543;
        $month = date('n', $this->date_int);
        $month_index = intval(date('n', $this->date_int))-1;
        $date = date('j', $this->date_int);
        if (self::LOCALE_ENGLISH_US == $this->set_locale)
        {
            switch ($this->set_format)
            {
                case self::FORMAT_NUMBERS:
                    $this->date_formatted = "$month/$date/$year BE";
                    break;
                case self::FORMAT_SHORT:
                    $this->date_formatted = date('M', $this->date_int) . " $date, $year BE";
                    break;
                case self::FORMAT_LONG:
                    $this->date_formatted = date('F', $this->date_int) . " $date, $year BE";
                    break;
            }
        } elseif (self::LOCALE_ENGLISH_UK == $this->set_locale)
        {
            switch ($this->set_format)
            {
                case self::FORMAT_NUMBERS:
                    $this->date_formatted = "$date/$month/$year BE";
                    break;
                case self::FORMAT_SHORT:
                    $this->date_formatted = $date . date(' M ', $this->date_int) . "$year BE";
                    break;
                case self::FORMAT_LONG:
                    $this->date_formatted = $date . date(' F ', $this->date_int) . "$year BE";
                    break;
            }
        } else {
            switch ($this->set_format)
            {
                case self::FORMAT_NUMBERS:
                    $this->date_formatted = "$date/$month/$year";
                    break;
                case self::FORMAT_SHORT:
                    $this->date_formatted = $date . ' ' . $this->months_abbr_thai[$month_index] . ' ' . $year;
                    break;
                case self::FORMAT_LONG:
                    $this->date_formatted = 'วันที่ '. $date . ' ' . $this->months_full_thai[$month_index] . ' พ.ศ. ' . $year;
                    break;
            }
        }
    }

    /**
     * Format Taiwanese ROC calendar
     * Calendar starts from 1 January 1912
     */
    private function format_taiwanese_calendar()
    {
        $year = intval(date('Y', $this->date_int))-1911;
        if (1 > $year)
        {
            $this->date_formatted = self::INVALID_DATE_FORMAT;
            $this->errors[] = $this->error_messages['E002'];
            return;
        }
        if (self::LOCALE_ENGLISH_US == $this->set_locale || self::LOCALE_ENGLISH_UK == $this->set_locale)
        {
            switch ($this->set_format)
            {
                case self::FORMAT_NUMBERS:
                    $this->date_formatted = date('d/m/', $this->date_int) . $year . ' ROC';
                    break;
                case self::FORMAT_SHORT:
                    $this->date_formatted = date('j M ', $this->date_int) . $year . ' ROC';
                    break;
                case self::FORMAT_LONG:
                    $this->date_formatted = date('j F ', $this->date_int) . $year . ' ROC';
                    break;
            }
        } else {
            switch ($this->set_format)
            {
                case self::FORMAT_NUMBERS:
                    $this->date_formatted = $year . date('.m.d', $this->date_int);
                    break;
                case self::FORMAT_SHORT:
                    $this->date_formatted = $year . date('年m月d日', $this->date_int);
                    break;
                case self::FORMAT_LONG:
                    $this->date_formatted = '民國' . $year . date('年m月d日', $this->date_int);
                    break;
            }
        }
    }

    /**
     * Format Gregorian calendar
     */
    private function format_gregorian_calendar()
    {
        if (self::LOCALE_ENGLISH_US == $this->set_locale)
        {
            switch ($this->set_format)
            {
                case self::FORMAT_NUMBERS:
                    $this->date_formatted = date('m/d/y', $this->date_int);
                    break;
                case self::FORMAT_SHORT:
                    $this->date_formatted = date('M j, Y', $this->date_int);
                    break;
                case self::FORMAT_LONG:
                    $this->date_formatted = date('F j, Y', $this->date_int);
                    break;
            }
        } elseif (self::LOCALE_ENGLISH_UK == $this->set_locale)
        {
            switch ($this->set_format)
            {
                case self::FORMAT_NUMBERS:
                    $this->date_formatted = date('d/m/y', $this->date_int);
                    break;
                case self::FORMAT_SHORT:
                    $this->date_formatted = date('j M Y', $this->date_int);
                    break;
                case self::FORMAT_LONG:
                    $this->date_formatted = date('j F Y', $this->date_int);
                    break;
            }
        } elseif (self::LOCALE_JAPANESE == $this->set_locale)
        {
            switch ($this->set_format)
            {
                case self::FORMAT_NUMBERS:
                    $this->date_formatted = date('Y.m.d', $this->date_int);
                    break;
                case self::FORMAT_SHORT:
                case self::FORMAT_LONG:
                    $this->date_formatted = date('Y年m月d日', $this->date_int);
                    break;
            }
        } elseif (in_array($this->set_locale, [self::LOCALE_CHINESE_TAIWAN, self::LOCALE_CHINESE_CHINA]))
        {
            switch ($this->set_format)
            {
                case self::FORMAT_NUMBERS:
                    $this->date_formatted = date('Y-m-d', $this->date_int);
                    break;
                case self::FORMAT_SHORT:
                case self::FORMAT_LONG:
                    $this->date_formatted = date('Y年m月d日', $this->date_int);
                    break;
            }
        } elseif (self::LOCALE_THAI == $this->set_locale)
        {
            $d = date('j', $this->date_int);
            $mi = date('n', $this->date_int)-1;
            $y = date('Y', $this->date_int);
            switch ($this->set_format)
            {
                case self::FORMAT_NUMBERS:
                    $this->date_formatted = date('d/m/y', $this->date_int);
                    break;
                case self::FORMAT_SHORT:
                    $this->date_formatted = $d . ' ' . $this->months_abbr_thai[$mi] . ' ' . $y;
                    break;
                case self::FORMAT_LONG:
                    $this->date_formatted = $d . ' ' . $this->months_full_thai[$mi] . ' ' . $y;
                    break;
            }
        }
    }
}