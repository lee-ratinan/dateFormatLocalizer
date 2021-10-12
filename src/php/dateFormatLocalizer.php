<?php

/**
 * Class dateFormatLocalizer
 */
class dateFormatLocalizer {

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
     * Value - timestamp
     * @var DateTime $timestamp
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
     * dateFormatLocalizer constructor
     * @param string $country
     * @param string $language
     * @param string $calendar
     */
    public function __construct($country = '', $language = '', $calendar = '')
    {
        $this->settings($country, $language, $calendar);
    }

    /**
     * Setup the calendar
     * @param string $country
     * @param string $language
     * @param string $calendar
     */
    public function settings($country, $language, $calendar)
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
        $this->rfc5646 = $this->language . '-' . $this->country;
        if ( ! empty($calendar) && isset($this->supported_calendars[$calendar]))
        {
            $this->calendar = $calendar;
        } else
        {
            $this->calendar = self::CALENDAR_GREGORIAN;
        }
        $this->calendar_name = $this->supported_calendars[$this->calendar];
        $this->check_calendar();
    }

    private function check_calendar()
    {
        switch ($this->calendar)
        {
            case self::CALENDAR_JAPANESE:
                if ( ! in_array($this->rfc5646, ['JA-JP', 'EN-JP']))
                {
                    //
                }
                break;
            case self::CALENDAR_MINGUO:
                if ( ! in_array($this->rfc5646, ['ZH-TW', 'EN-TW']))
                {
                    //
                }
                break;
            case self::CALENDAR_THAI:
                if ( ! in_array($this->rfc5646, ['TH-TH', 'EN-TH']))
                {
                    //
                }
                break;
            case self::CALENDAR_GREGORIAN:
            default:
                break;
        }
    }
}