<h1>Config</h1>
<table class="table table-hover table-striped">
  <thead>
    <tr>
      <th>Calendar</th>
      <th>Locales</th>
    </tr>
  </thead>
  <tbody>
      <?php foreach ($supported_locales as $calendar => $locales) : ?>
        <tr>
          <td><?= $calendar ?></td>
          <td><?= implode(', ', $locales) ?></td>
        </tr>
      <?php endforeach; ?>
  </tbody>
</table>