<?php
include_once '../src/php/DateFormatLocalizer.php';
$date_string = $_POST['date'];
$language = $_POST['language'];
$country = $_POST['country'];
$calendar = $_POST['calendar'];
if ( ! empty($date_string))
{
    $obj = new DateFormatLocalizer($country, $language, $calendar);
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
    <div class="container">
      <div class="row">
        <div class="col col-lg-8">
          <h1>Test dateFormatLocalizer</h1>
          <hr>
          <form method="POST">
            <label for="date_string">Date</label>
            <input class="form-control mb-3" type="date" name="date" id="date_string" value="<?= @$date_string ?>" placeholder="Date" required/>
            <div class="row">
              <div class="col-6">
                <label for="language">Language</label>
                <select class="form-control mb-3" name="language" id="language">
                  <option value="EN" <?= ('EN' == $country ? 'selected' : '') ?>>English</option>
                  <option value="ZH" <?= ('ZH' == $country ? 'selected' : '') ?>>Chinese</option>
                  <option value="JA" <?= ('JA' == $country ? 'selected' : '') ?>>Japanese</option>
                  <option value="KO" <?= ('KO' == $country ? 'selected' : '') ?>>Korean</option>
                  <option value="TH" <?= ('TH' == $country ? 'selected' : '') ?>>Thai</option>
                </select>
              </div>
              <div class="col-6">
                <label for="country">Country</label>
                <select class="form-control mb-3" name="country" id="country">
                  <option value="US" <?= ('US' == $country ? 'selected' : '') ?>>US</option>
                  <option value="UK" <?= ('UK' == $country ? 'selected' : '') ?>>UK</option>
                  <option value="CN" <?= ('CN' == $country ? 'selected' : '') ?>>China</option>
                  <option value="TW" <?= ('TW' == $country ? 'selected' : '') ?>>Taiwan</option>
                  <option value="JP" <?= ('JP' == $country ? 'selected' : '') ?>>Japan</option>
                  <option value="KR" <?= ('KR' == $country ? 'selected' : '') ?>>Korea</option>
                  <option value="TH" <?= ('TH' == $country ? 'selected' : '') ?>>Thailand</option>
                </select>
              </div>
            </div>
            <label for="calendar">Calendar</label>
            <select class="form-control mb-3" name="calendar" id="calendar">
              <option value="GRE" <?= ('GRE' == $calendar ? 'selected' : '') ?>>Gregorian Calendar</option>
              <option value="THA" <?= ('THA' == $calendar ? 'selected' : '') ?>>Thai Buddhist Calendar</option>
              <option value="JAP" <?= ('JAP' == $calendar ? 'selected' : '') ?>>Japanese Calendar</option>
              <option value="ROC" <?= ('ROC' == $calendar ? 'selected' : '') ?>>Republic of China (MINGUO) Calendar
              </option>
            </select>
            <div class="text-end">
              <input class="btn btn-success mb-3" type="submit" value="Decode"/>
            </div>
          </form>
            <?= (isset($json) ? '<h2>Result</h2><pre>' . $json . '</pre>' : '') ?>
          <hr>
          <p>&copy; Ratinan Lee - 2021</p>
        </div>
      </div>
    </div>
  </body>
</html>