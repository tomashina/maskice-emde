<?php
/*
 * Excelup OpenCart Extension by OpencartBot
 * https://opencartbot.com/en/excelup
 * Released under CC BY-ND 3.0 license
 */

// Heading
$_['heading_title'] = ' ExcelUp: оновлення цін і залишків з Excel';

// Tabs
$_['tab_main'] = 'Основне';
$_['tab_import'] = 'Імпорт';
$_['tab_license'] = 'Ліцензія';

// Text
$_['text_extension'] = 'Модулі';
$_['text_success'] = 'Успішно: Ви змінили модуль ExcelUp!';
$_['text_success_import'] = 'Успішно: Оновлення товарів успішно виконано!';
$_['text_edit'] = 'Редагування ExcelUp';
$_['text_model'] = 'Model (Код товару)';
$_['text_sku'] = 'SKU (Артикул)';
$_['text_product_id'] = 'ID товару';
$_['text_import'] = 'Імпорт';
$_['text_copyright'] = '<p>Модуль безкоштовно отриманий на сайті <strong><a target="_blank" href="https://opencartbot.com/"> opencartbot.com</a></strong></p>
<p>Модуль розповсюджується по ліцензії <a target="_blank" href="https://creativecommons.org/licenses/by-nd/3.0/deed.uk">CC BY-ND 3.0</a>. Ви можете встановлювати його на будь-яких сайтах, модифікувати його код, при цьому, не видаляючи копірайт автора і посилання на його сайт.</p>
<p>Автор не надає технічну підтримку з даного безкоштовного модулю і не несе відповідальність за будь-які проблеми, що виникають у процессі його використання.</p>
<p><a target="_blank" href="https://opencartbot.com/excelup">Сторінка модуля</a></p>
<p>Автор модуля: <strong>opencartbot</strong></p> ';

// Entry
$_['entry_status'] = 'Статус';
$_['entry_ident'] = 'Ідентифікатор товарів';
$_['entry_idcol'] = 'Номер колонки ідентифікаторів';
$_['entry_firstrow'] = 'Номер першого ряду';
$_['entry_price'] = 'Оновлення цін';
$_['entry_pricecol'] = 'Номер колонки цін';
$_['entry_priceup'] = 'Відсоток націнки';
$_['entry_quantity'] = 'Оновлення залишків';
$_['entry_quantitycol'] = 'Номер колонки залишків';
$_['entry_file'] = 'Прайс Excel';
$_['entry_special'] = 'Оновлення акційних цін';
$_['entry_special_new'] = 'Створити акцію, якщо такої не існує';
$_['entry_specialcol'] = 'Номер колонки акційних цін';
$_['entry_specialup'] = 'Відсоток націнки';

// Help
$_['help_status'] = 'Статус модуля';
$_['help_ident'] = 'Вкажіть з якого параметру буде проводитися порівняння товарів прайса і сайту';
$_['help_idcol'] = 'Номер колонки в прайсі, в якій знаходяться ідентифікатори товарів';
$_['help_firstrow'] = 'Номер ряду в прайсі, з якого починати імпорт';
$_['help_price'] = 'Потрібно оновлювати ціни товарів?';
$_['help_pricecol'] = 'Номер колонки в прайсі, в якій знаходяться ціни товарів';
$_['help_priceup'] = 'Вкажіть відсоток націнки. 0 - без націнки. ';
$_['help_quantity'] = 'Оновлювати кількість товарів на складі';
$_['help_quantitycol'] = 'Номер колонки в прайсі, в якій знаходяться залишки - кількість товару';
$_['help_special'] = 'Оновлення цін у вкладці Акції';
$_['help_special_new'] = 'Створити акцію у вкладці Акції, якщо такої не існує';
$_['help_specialcol'] = 'Номер колонки в прайсе, в якій знаходяться ціни для акцій';
$_['help_specialup'] = 'Відсоток націнки для ціни по акції';

// Error
$_['error_permission'] = 'Увага: Ви не маєте доступу для управління модулем!';
$_['error_upload'] = 'Помилка при завантаженні файлу на сервер! Перевірте права на папку storage/upload';
$_['error_import'] = 'Помилка при обробці файлу або в процесі імпорту!';
$_['error_php_version'] = 'Помилка! Для роботи модуля потрібно використовувати PHP 7.2 або вище';