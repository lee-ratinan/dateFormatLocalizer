<?php
include_once '../src/php/DateFormatLocalizer.php';
$date_string = $_POST['date'];
$obj = new DateFormatLocalizer();
if (empty($date_string))
{
    $date_string = date('Y-m-d');
}
$supported_locales = $obj->get_supported_locales();
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
            <div class="text-end">
              <input class="btn btn-success mb-3" type="submit" value="Format"/>
            </div>
          </form>
          <h1>Results</h1>
          <p>Input date: <?= $date_string ?>.</p>
          <table class="table table-sm table-hover table-striped">
            <thead class="text-center">
              <tr>
                <th colspan="2">Settings</th>
                <th colspan="3">Formats</th>
              </tr>
              <tr>
                <th>Calendar</th>
                <th>Locale</th>
                <th>Numeric</th>
                <th>Short</th>
                <th>Long</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($supported_locales as $calendar => $locales) : ?>
              <?php foreach ($locales as $locale) : ?>
                  <tr>
                    <td><?= $calendar ?></td>
                    <td><?= $locale ?></td>
                    <td>
                      <?php
                      $obj->settings($calendar, $locale, DateFormatLocalizer::FORMAT_NUMBERS);
                      echo $obj->format_date($date_string);
                      ?>
                    </td>
                    <td>
                        <?php
                        $obj->settings($calendar, $locale, DateFormatLocalizer::FORMAT_SHORT);
                        echo $obj->format_date($date_string);
                        ?>
                    </td>
                    <td>
                        <?php
                        $obj->settings($calendar, $locale, DateFormatLocalizer::FORMAT_LONG);
                        echo $obj->format_date($date_string);
                        ?>
                    </td>
                  </tr>
              <?php endforeach; ?>
              <?php endforeach; ?>
            </tbody>
          </table>
          <p>&copy; Ratinan Lee - 2021</p>
        </div>
      </div>
    </div>
  </body>
</html>