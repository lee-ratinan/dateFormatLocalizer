# dateFormatLocalizer
This JS/PHP library formats date into localized formats such as ROC/Reiwa/BE calendars

## How to Use

### PHP

Crete the object with the format settings or call `settings()` function.

```PHP
$object = DateFormatLocalizer('JP', 'JA', 'JAP', 'S');
/* or */
$object = DateFormatLocalizer();
$object->settings('JP', 'JA', 'JAP', 'S');
```

To format the date, either call `format_date()` and get the formatted string returned or call the `prepare_date()` to get the date stored as the property of the class and call it later.

```PHP
$object = DateFormatLocalizer('JP', 'JA', 'JAP', 'S');
echo $object->format_date('2021-11-15');
/* or */
$object->prepare_date('2021-11-15');
echo json_encode($object, JSON_PRETTY_PRINT);
```
