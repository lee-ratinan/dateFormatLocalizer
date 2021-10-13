<?php
include_once '../src/php/DateFormatLocalizer.php';
$date_string = $_POST['date'];
$locale = $_POST['locale'];
$calendar = $_POST['calendar'];
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="../src/js/DateFormatLocalizer.js"></script>
  </head>
  <body>
      <?php
      include "_header.php";
      ?>
    <div class="container mt-5">
      <div class="row">
        <div class="col col-lg-8">
          <h1>Test JavaScript Formatter</h1>
          <form method="POST">
            <label for="date_string">Date</label>
            <input class="form-control mb-3" type="date" name="date" id="date_string" value="<?= @$date_string ?>" placeholder="Date" required/>
            <label for="locale">Locale</label>
            <select class="form-control mb-3" name="locale" id="locale">
              <option value="<?= DateFormatLocalizer::LOCALE_ENGLISH_US ?>" <?= (DateFormatLocalizer::LOCALE_ENGLISH_US == $locale ? 'selected' : '') ?>>English (US)</option>
              <option value="<?= DateFormatLocalizer::LOCALE_ENGLISH_UK ?>" <?= (DateFormatLocalizer::LOCALE_ENGLISH_UK == $locale ? 'selected' : '') ?>>English (UK)</option>
              <option value="<?= DateFormatLocalizer::LOCALE_JAPANESE ?>" <?= (DateFormatLocalizer::LOCALE_JAPANESE == $locale ? 'selected' : '') ?>>Japanese</option>
              <option value="<?= DateFormatLocalizer::LOCALE_CHINESE_TAIWAN ?>" <?= (DateFormatLocalizer::LOCALE_CHINESE_TAIWAN == $locale ? 'selected' : '') ?>>Chinese (Taiwan)</option>
              <option value="<?= DateFormatLocalizer::LOCALE_CHINESE_CHINA ?>" <?= (DateFormatLocalizer::LOCALE_CHINESE_CHINA == $locale ? 'selected' : '') ?>>Chinese (China)</option>
              <option value="<?= DateFormatLocalizer::LOCALE_THAI ?>" <?= (DateFormatLocalizer::LOCALE_THAI == $locale ? 'selected' : '') ?>>Thai</option>
            </select>
            <label for="calendar">Calendar</label>
            <select class="form-control mb-3" name="calendar" id="calendar">
              <option value="<?= DateFormatLocalizer::CALENDAR_GREGORIAN ?>" <?= (DateFormatLocalizer::CALENDAR_GREGORIAN == $calendar ? 'selected' : '') ?>>Gregorian Calendar</option>
              <option value="<?= DateFormatLocalizer::CALENDAR_THAI ?>" <?= (DateFormatLocalizer::CALENDAR_THAI == $calendar ? 'selected' : '') ?>>Thai Buddhist Calendar</option>
              <option value="<?= DateFormatLocalizer::CALENDAR_JAPANESE ?>" <?= (DateFormatLocalizer::CALENDAR_JAPANESE == $calendar ? 'selected' : '') ?>>Japanese Calendar</option>
              <option value="<?= DateFormatLocalizer::CALENDAR_TAIWANESE ?>" <?= (DateFormatLocalizer::CALENDAR_TAIWANESE == $calendar ? 'selected' : '') ?>>Republic of China (MINGUO) Calendar</option>
            </select>
            <div class="text-end">
              <input class="btn btn-success mb-3" type="submit" value="Format"/>
            </div>
          </form>
            <?php if ( ! empty($date_string)) : ?>
              <h2>Results</h2>
              <h3>Numbers</h3>
              <div class="test-date" id="test-number" data-calendar="<?= $calendar ?>" data-locale="<?= $locale ?>" data-format="N" data-date="<?= $date_string ?>"></div>
              <h3>Short</h3>
              <div class="test-date" id="test-short" data-calendar="<?= $calendar ?>" data-locale="<?= $locale ?>" data-format="S" data-date="<?= $date_string ?>"></div>
              <h3>Long</h3>
              <div class="test-date" id="test-long" data-calendar="<?= $calendar ?>" data-locale="<?= $locale ?>" data-format="L" data-date="<?= $date_string ?>"></div>
            <?php endif; ?>
          <hr>
          <p>&copy; Ratinan Lee - 2021</p>
        </div>
      </div>
    </div>
  </body>
  <script>
      $(function () {
          $('.test-date').dateFormatLocalizer();
      });
  </script>
</html>