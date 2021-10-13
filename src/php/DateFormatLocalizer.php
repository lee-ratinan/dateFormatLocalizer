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
            $this->errors[] = $this->error_messages['E001'];
            return;
        }
        $this->date_int = $date_int;
        $this->date_iso8601 = $date_validate;
        // PREPARE DATE
        switch ($this->calendar)
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
            default:
                $this->format_gregorian_calendar();
        }
    }

    /**
     * Format Japanese calendar
     */
    private function format_japanese_calendar()
    {
        $this->date_formatted = '';
    }

    /**
     * Format Thai Buddhist calendar
     */
    private function format_thai_calendar()
    {
        $this->date_formatted = '';
    }

    /**
     * Format Taiwanese ROC calendar
     */
    private function format_taiwanese_calendar()
    {
        $year = intval(date('Y', $this->date_int))-1911;
        if (1 > $year)
        {
            $this->date_formatted = '****-**-**';
            $this->errors[] = $this->error_messages['E002'];
            return;
        }
        if (self::LOCALE_ENGLISH_US == $this->set_locale || self::LOCALE_ENGLISH_UK == $this->set_locale)
        {
            switch ($this->set_format)
            {
                case self::FORMAT_NUMBERS:
                    $this->date_formatted = 'ROC ' . date('d/m/', $this->date_int) . $year;
                    break;
                case self::FORMAT_SHORT:
                    $this->date_formatted = 'ROC ' . date('j M ', $this->date_int) . $year;
                    break;
                case self::FORMAT_LONG:
                    $this->date_formatted = 'ROC ' . date('j F ', $this->date_int) . $year;
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
                    $this->date_formatted = date('y.m.d', $this->date_int);
                    break;
                case self::FORMAT_SHORT:
                case self::FORMAT_LONG:
                    $this->date_formatted = date('y年m月d日', $this->date_int);
                    break;
            }
        } elseif (in_array($this->set_locale, [self::LOCALE_CHINESE_TAIWAN, self::LOCALE_CHINESE_CHINA]))
        {
            switch ($this->set_format)
            {
                case self::FORMAT_NUMBERS:
                    $this->date_formatted = date('y-m-d', $this->date_int);
                    break;
                case self::FORMAT_SHORT:
                case self::FORMAT_LONG:
                    $this->date_formatted = date('y年m月d日', $this->date_int);
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