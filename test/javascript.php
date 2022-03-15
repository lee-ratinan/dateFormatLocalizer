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
              <div class="test-date" id="test-number" data-calendar="<?= $calendar ?>"
                   data-locale="<?= $locale ?>" data-format="N" data-date="<?= $date_string ?>"></div>
            </td>
            <td>
              <div class="test-date" id="test-short" data-calendar="<?= $calendar ?>"
                   data-locale="<?= $locale ?>"
                   data-format="S" data-date="<?= $date_string ?>"></div>
            </td>
            <td>
              <div class="test-date" id="test-long" data-calendar="<?= $calendar ?>"
                   data-locale="<?= $locale ?>"
                   data-format="L" data-date="<?= $date_string ?>"></div>
            </td>
          </tr>
          <?php endforeach; ?>
      <?php endforeach; ?>
  </tbody>
</table>
<script>
    $(function () {
        $('.test-date').DateFormatLocalizer();
    });
</script>