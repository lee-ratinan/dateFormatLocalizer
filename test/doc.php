<h1>dateFormatLocalizer</h1>
<p>This JS/PHP library formats date into localized formats such as ROC/Reiwa/BE calendars.</p>
<h2>How to Use</h2>

<h3>PHP</h3>
<h4>Constructor and <code>settings()</code></h4>
<p>Add the calendar type, locale code, and format code in either constructor or <code>settings()</code>.</p>
<p><b>Parameters</b></p>
<ul>
  <li><code>calendar</code> Calendar of the output date format</li>
  <li><code>locale</code> Locale of the output date format in RFC5646 format</li>
  <li><code>format</code> Format of the date string output, either N, S, or L</li>
</ul>
<h4><code>prepare_date()</code> and <code>format_date()</code></h4>
<p>Prepare the output date format in the calendar, locale, and format as specified in the constructor or <code>settings()</code>.
</p>
<p><b>Parameters</b></p>
<ul>
  <li><code>date_string</code> The date string in ISO8601 format</li>
</ul>
<p><b>Return</b></p>
<p><code>prepare_date()</code> will set the date in the class property <code>date_formatted</code> while <code>format_date()</code>
  will return such string.</p>
<h4><code>get_formatted_date()</code></h4>
<p>After calling <code>prepare_date()</code>, this function return the property <code>date_formatted</code> to the
  caller.</p>
<h4>Available Settings</h4>
<ul>
  <li>Calendars
    <ul>
      <li>GREGORIAN: <code>DateFormatLocalizer::CALENDAR_GREGORIAN</code></li>
      <li>JAPANESE: <code>DateFormatLocalizer::CALENDAR_JAPANESE</code></li>
      <li>TAIWANESE: <code>DateFormatLocalizer::CALENDAR_TAIWANESE</code></li>
      <li>THAI: <code>DateFormatLocalizer::CALENDAR_THAI</code></li>
    </ul>
  </li>
  <li>
    Locales
    <ul>
      <li>EN-US: <code>DateFormatLocalizer::LOCALE_ENGLISH_US</code></li>
      <li>EN-UK: <code>DateFormatLocalizer::LOCALE_ENGLISH_UK</code></li>
      <li>JA-JP: <code>DateFormatLocalizer::LOCALE_JAPANESE</code></li>
      <li>ZH-TW: <code>DateFormatLocalizer::LOCALE_CHINESE_TAIWAN</code></li>
      <li>ZH-CN: <code>DateFormatLocalizer::LOCALE_CHINESE_CHINA</code></li>
      <li>TH-TH: <code>DateFormatLocalizer::LOCALE_THAI</code></li>
    </ul>
  </li>
  <li>
    Formats
    <ul>
      <li>N: <code>DateFormatLocalizer::FORMAT_NUMBERS</code></li>
      <li>S: <code>DateFormatLocalizer::FORMAT_SHORT</code></li>
      <li>L: <code>DateFormatLocalizer::FORMAT_LONG</code></li>
    </ul>
  </li>
</ul>
<h4>Example</h4>
<code><pre>
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
echo '&lt;pre&gt;' . $json . '&lt;/pre&gt;';

/*
 * This will return and print only formatted string
 * Output: Nov 15, 2021
 */
echo $obj->get_formatted_date();
</pre>
</code>

<p>When the date is invalid, the class return <code>****-**-**</code>.</p>

<code><pre>
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
echo '&lt;pre&gt;' . $json . '&lt;/pre&gt;';
</pre>
</code>

<h3>JavaScript</h3>
<p>This is the jQuery plugin, so jQuery JS has to be included into the HTML file first. Then, include the <code>DateFormatLocalizer.js</code>
  or the minified <code>DateFormatLocalizer.min.js</code>.</p>

<p><b>Method 1:</b> Add <code>data-calendar</code>, <code>data-locale</code>, <code>data-format</code>, and <code>data-date</code>
  as the data attributes of the target element and call <code>.DateFormatLocalizer()</code> in JavaScript.</p>
<h4>HTML:</h4>
<code><pre>
&lt;script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"&gt;&lt;/script&gt;
&lt;script src="../src/js/DateFormatLocalizer.min.js"&gt;&lt;/script&gt;
&lt;div id="format-date" data-calendar="GREGORIAN" data-locale="EN-US" data-format="S" data-date="2021-11-15"&gt;&lt;/div&gt;
</pre>
</code>
<h4>JavaScript:</h4>
<code><pre>
$(function () {
  $('#format-date').DateFormatLocalizer();
});
</pre>
</code>
<h4>Output:</h4>
<code><pre>
Nov 15, 2021
</pre>
</code>
<p><b>Method 2:</b> Only add the <code>data-date</code> in the target element and pass the <code>calendar</code>, <code>locale</code>,
  and <code>format</code> in the jQuery function.</p>
<h4>HTML:</h4>
<code><pre>
&lt;div id="format-date" data-date="2021-11-15"&gt;&lt;/div&gt;
</pre>
</code>
<h4>JavaScript:</h4>
<code><pre>
$(function () {
  $('#format-date').DateFormatLocalizer({
    'calendar': 'GREGORIAN',
    'locale': 'EN-US',
    'format': 'S'
  });
});
</pre>
</code>
<h4>Output:</h4>
<code><pre>
Nov 15, 2021
</pre>
</code>

<h4>Available Settings</h4>
<ul>
  <li>Calendars
    <ul>
      <li>GREGORIAN</li>
      <li>JAPANESE</li>
      <li>TAIWANESE</li>
      <li>THAI</li>
    </ul>
  </li>
  <li>Locales
    <ul>
      <li>EN-US</li>
      <li>EN-UK</li>
      <li>JA-JP</li>
      <li>ZH-TW</li>
      <li>ZH-CN</li>
      <li>TH-TH</li>
    </ul>
  </li>
  <li>Formats
    <ul>
      <li>N (numeric)</li>
      <li>S (short)</li>
      <li>L (long)</li>
    </ul>
  </li>
</ul>

<h2>Calendars</h2>
<h3>Gregorian</h3>
<p>The most popular Gregorian calendar supports all valid dates.</p>
<h3>Japanese</h3>
<p>This calendar supports all Modern Japanese eras starting from Meija Era and not a day prior to 23 Oct 1868. Here are
  the dates:</p>
<table class="table table-sm table-striped table-hover">
  <thead>
    <tr>
      <th>First date</th>
      <th>Era (English)</th>
      <th>Era (Japanese)</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>23 Oct 1868</td>
      <td>Meiji</td>
      <td>明治</td>
    </tr>
    <tr>
      <td>30 Jul 1912</td>
      <td>Taishō</td>
      <td>大正</td>
    </tr>
    <tr>
      <td>25 Dec 1926</td>
      <td>Shōwa</td>
      <td>昭和</td>
    </tr>
    <tr>
      <td>08 Jan 1989</td>
      <td>Heisei</td>
      <td>平成</td>
    </tr>
    <tr>
      <td>01 May 2019</td>
      <td>Reiwa</td>
      <td>令和</td>
    </tr>
  </tbody>
</table>
<p>The Japanese calendar supports only <code>EN-US</code>, <code>EN-UK</code>, and <code>JA-JP</code>.</p>
<h3>Taiwanese Minguo (ROC) Calendar / 中華民國曆 / 民國紀年</h3>
<p>This calendar is popular in Taiwan. Starting from 1912 as its first year, the calendar never supports any date priority to this year.</p>
<p>The Taiwanese calendar supports only <code>EN-US</code>, <code>EN-UK</code>, and <code>ZH-TW</code>.</p>
<h3>Thai Buddhist Calendar / พุทธศักราช</h3>
<p>Because of the unique rules, the Buddhist calendar is diverse. This library supports the Thai version of the Buddhist calendar starting from 1941 (or 2484 BE).</p>
<p>The Japanese calendar supports only <code>EN-US</code>, <code>EN-UK</code>, and <code>TH-TH</code>.</p>