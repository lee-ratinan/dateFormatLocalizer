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