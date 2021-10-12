<?php

/**
 * Class DateFormatLocalizer
 */
class DateFormatLocalizer {

    const CALENDAR_GREGORIAN = 'GRE';
    const CALENDAR_THAI = 'THA';
    const CALENDAR_JAPANESE = 'JAP';
    const CALENDAR_MINGUO = 'ROC';

    const LANGUAGE_ENGLISH = 'EN';
    const LANGUAGE_CHINESE = 'ZH';
    const LANGUAGE_JAPANESE = 'JA';
    const LANGUAGE_KOREAN = 'KO';
    const LANGUAGE_THAI = 'TH';

    const COUNTRY_UNITED_STATES = 'US';
    const COUNTRY_UNITED_KINGDOM = 'UK';
    const COUNTRY_CHINA = 'CN';
    const COUNTRY_TAIWAN = 'TW';
    const COUNTRY_JAPAN = 'JP';
    const COUNTRY_KOREA = 'KR';
    const COUNTRY_THAILAND = 'TH';

    const FORMAT_LONG = 'L';
    const FORMAT_MEDIUM = 'M';
    const FORMAT_SHORT = 'S';

    const STRING_DASH = '-';

    private $supported_calendars = [
        self::CALENDAR_GREGORIAN => 'GREGORIAN',
        self::CALENDAR_THAI => 'THAI',
        self::CALENDAR_JAPANESE => 'JAPANESE',
        self::CALENDAR_MINGUO => 'MINGUO'
    ];

    private $supported_languages = [
        self::LANGUAGE_ENGLISH,
        self::LANGUAGE_CHINESE,
        self::LANGUAGE_JAPANESE,
        self::LANGUAGE_KOREAN,
        self::LANGUAGE_THAI
    ];

    private $supported_country = [
        self::COUNTRY_UNITED_STATES,
        self::COUNTRY_UNITED_KINGDOM,
        self::COUNTRY_CHINA,
        self::COUNTRY_TAIWAN,
        self::COUNTRY_JAPAN,
        self::COUNTRY_KOREA,
        self::COUNTRY_THAILAND
    ];

    private $supported_format = [
        self::FORMAT_LONG,
        self::FORMAT_MEDIUM,
        self::FORMAT_SHORT
    ];

    private $error_messages = [
        'E001' => 'Date string is invalid'
    ];

    /**
     * Settings - country (ISO3166)
     * @var string $country
     */
    public $country;

    /**
     * Settings - language code (ISO639)
     * @var string $language
     */
    public $language;

    /**
     * Settings - locale (RFC5646)
     * @var string $rfc5646
     */
    public $rfc5646;

    /**
     * Settings - calendar code
     * @var string $calendar
     * @var string $calendar_name
     */
    public $calendar;
    public $calendar_name;

    /**
     * Settings - format
     * @var string $format
     */
    public $format;

    /**
     * Value - timestamp
     * @var int $timestamp
     */
    public $timestamp;

    /**
     * Value - timestamp (ISO8601)
     * @var string $iso_string
     */
    public $iso_string;

    /**
     * Value - timestamp (formatted string)
     * @var string $formatted_string
     */
    public $formatted_string;

    /**
     * System - error array
     * @var array Error in the settings or values
     */
    public $errors = [];

    /**
     * DateFormatLocalizer constructor
     * @param string $country
     * @param string $language
     * @param string $calendar
     * @param string $format
     */
    public function __construct($country = '', $language = '', $calendar = '', $format = '')
    {
        $this->settings($country, $language, $calendar, $format);
    }

    /**
     * Setup the calendar
     * @param string $country
     * @param string $language
     * @param string $calendar
     * @param string $format
     */
    public function settings($country, $language, $calendar, $format)
    {
        if ( ! empty($country) && in_array($country, $this->supported_country))
        {
            $this->country = $country;
        } else
        {
            $this->country = self::COUNTRY_UNITED_STATES;
        }
        if ( ! empty($language) && in_array($language, $this->supported_languages))
        {
            $this->language = $language;
        } else
        {
            $this->language = self::LANGUAGE_ENGLISH;
        }
        if ( ! empty($calendar) && isset($this->supported_calendars[$calendar]))
        {
            $this->calendar = $calendar;
        } else
        {
            $this->calendar = self::CALENDAR_GREGORIAN;
        }
        if ( ! empty($format) && in_array($format, $this->supported_format))
        {
            $this->format = $format;
        }
        // VERIFY CALENDAR
        if (self::CALENDAR_JAPANESE == $this->calendar)
        {
            if ( ! in_array($this->language, [self::LANGUAGE_JAPANESE, self::LANGUAGE_ENGLISH]))
            {
                $this->language = self::LANGUAGE_ENGLISH;
            }
            if ($this->country != self::COUNTRY_JAPAN)
            {
                $this->country = self::COUNTRY_JAPAN;
            }
        } else if (self::CALENDAR_THAI == $this->calendar)
        {
            if ( ! in_array($this->language, [self::LANGUAGE_THAI, self::LANGUAGE_ENGLISH]))
            {
                $this->language = self::LANGUAGE_ENGLISH;
            }
            if ($this->country != self::COUNTRY_THAILAND)
            {
                $this->country = self::COUNTRY_THAILAND;
            }
        } else if (self::CALENDAR_MINGUO == $this->calendar)
        {
            if ( ! in_array($this->language, [self::LANGUAGE_CHINESE, self::LANGUAGE_ENGLISH]))
            {
                $this->language = self::LANGUAGE_ENGLISH;
            }
            if ($this->country != self::COUNTRY_TAIWAN)
            {
                $this->country = self::COUNTRY_TAIWAN;
            }
        }
        $this->rfc5646 = $this->language . self::STRING_DASH . $this->country;
        $this->calendar_name = $this->supported_calendars[$this->calendar];
    }

    /**
     * Format date according to the settings set in the class and return the formatted date string
     * @param string $date_string Date string in ISO8601 format: YYYY-MM-DD
     * @return string
     */
    public function format_date($date_string)
    {
        $this->prepare_date($date_string);
        return $this->formatted_string;
    }

    /**
     * Format date according to the settings set in the class and store in $this->formatted_string
     * @param string $date_string Date string in ISO8601 format: YYYY-MM-DD
     */
    public function prepare_date($date_string)
    {
        if ( ! preg_match('^(19|20)\d{2}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$', $date_string))
        {
            $this->errors[] = $this->error_messages['E001'];
            return;
        }
        $date_object = strtotime($date_string);
        $this->iso_string = $date_string;
        $this->timestamp = $date_object;
        switch ($this->calendar)
        {
            case self::CALENDAR_JAPANESE:
                $this->format_japanese_calendar($date_object);
            case self::CALENDAR_THAI:
                $this->format_thai_calendar($date_object);
            case self::CALENDAR_MINGUO:
                $this->format_minguo_calendar($date_object);
            case self::CALENDAR_GREGORIAN:
            default:
                $this->format_gregorian_calendar($date_object);
        }
    }

    /**
     * Format Japanese calendar
     * @param $date_object
     */
    private function format_japanese_calendar($date_object)
    {
        $this->formatted_string = '';
    }

    /**
     * Format Thai calendar
     * @param $date_object
     */
    private function format_thai_calendar($date_object)
    {
        $this->formatted_string = '';
    }

    /**
     * Format ROC Minguo calendar
     * @param $date_object
     */
    private function format_minguo_calendar($date_object)
    {
        $this->formatted_string = '';
    }

    /**
     * Format Gregorian calendar
     * @param $date_object
     */
    private function format_gregorian_calendar($date_object)
    {
        $this->formatted_string = '';
    }
}