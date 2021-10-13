<?php
include_once '../src/php/DateFormatLocalizer.php';
$date_string = $_POST['date'];
$locale = $_POST['locale'];
$calendar = $_POST['calendar'];
$format = $_POST['format'];
$obj = new DateFormatLocalizer();
if ( ! empty($date_string))
{
    $obj->settings($calendar, $locale, $format);
    $obj->prepare_date($date_string);
    $json = json_encode($obj, JSON_PRETTY_PRINT);
}
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="dateFormatLocalizer">
    <meta name="author" content="Ratinan Lee">
    <title>Test dateFormatLocalizer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
  </head>
  <body>
      <?php
      include "_header.php";
      ?>
    <div class="container mt-5">
      <div class="row">
        <div class="col col-lg-8">
          <h1>Test PHP Formatter</h1>
          <form method="POST">
            <label for="date_string">Date</label>
            <input class="form-control mb-3" type="date" name="date" id="date_string" value="<?= @$date_string ?>" placeholder="Date" required/>
            <div class="row">
              <div class="col-6">
                <label for="locale">Locale</label>
                <select class="form-control mb-3" name="locale" id="locale">
                  <option value="<?= $obj::LOCALE_ENGLISH_US ?>" <?= ($obj::LOCALE_ENGLISH_US == $locale ? 'selected' : '') ?>>English (US)</option>
                  <option value="<?= $obj::LOCALE_ENGLISH_UK ?>" <?= ($obj::LOCALE_ENGLISH_UK == $locale ? 'selected' : '') ?>>English (UK)</option>
                  <option value="<?= $obj::LOCALE_JAPANESE ?>" <?= ($obj::LOCALE_JAPANESE == $locale ? 'selected' : '') ?>>Japanese</option>
                  <option value="<?= $obj::LOCALE_CHINESE_TAIWAN ?>" <?= ($obj::LOCALE_CHINESE_TAIWAN == $locale ? 'selected' : '') ?>>Chinese (Taiwan)</option>
                  <option value="<?= $obj::LOCALE_CHINESE_CHINA ?>" <?= ($obj::LOCALE_CHINESE_CHINA == $locale ? 'selected' : '') ?>>Chinese (China)</option>
                  <option value="<?= $obj::LOCALE_THAI ?>" <?= ($obj::LOCALE_THAI == $locale ? 'selected' : '') ?>>Thai</option>
                </select>
              </div>
              <div class="col-6">
                <label for="format">Format</label>
                <select class="form-control mb-3" name="format" id="format">
                  <option value="<?= $obj::FORMAT_NUMBERS ?>" <?= ($obj::FORMAT_NUMBERS == $format ? 'selected' : '') ?>>Numbers</option>
                  <option value="<?= $obj::FORMAT_SHORT ?>" <?= ($obj::FORMAT_SHORT == $format ? 'selected' : '') ?>>Short date</option>
                  <option value="<?= $obj::FORMAT_LONG ?>" <?= ($obj::FORMAT_LONG == $format ? 'selected' : '') ?>>Long date</option>
                </select>
              </div>
            </div>
            <label for="calendar">Calendar</label>
            <select class="form-control mb-3" name="calendar" id="calendar">
              <option value="<?= $obj::CALENDAR_GREGORIAN ?>" <?= ($obj::CALENDAR_GREGORIAN == $calendar ? 'selected' : '') ?>>Gregorian Calendar</option>
              <option value="<?= $obj::CALENDAR_THAI ?>" <?= ($obj::CALENDAR_THAI == $calendar ? 'selected' : '') ?>>Thai Buddhist Calendar</option>
              <option value="<?= $obj::CALENDAR_JAPANESE ?>" <?= ($obj::CALENDAR_JAPANESE == $calendar ? 'selected' : '') ?>>Japanese Calendar</option>
              <option value="<?= $obj::CALENDAR_TAIWANESE ?>" <?= ($obj::CALENDAR_TAIWANESE == $calendar ? 'selected' : '') ?>>Republic of China (MINGUO) Calendar</option>
            </select>
            <div class="text-end">
              <input class="btn btn-success mb-3" type="submit" value="Format"/>
            </div>
          </form>
            <?= (isset($json) ? '<h2>Result</h2><pre>' . $json . '</pre><br><b>Formatted Output: </b>' . $obj->get_formatted_date() : '') ?>
          <hr>
          <p>&copy; Ratinan Lee - 2021</p>
        </div>
      </div>
    </div>
  </body>
</html>