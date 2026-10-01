<?php
/*
 * Excelup OpenCart Extension by OpencartBot
 * https://opencartbot.com/en/excelup
 * Released under CC BY-ND 3.0 license
 */
 
// Heading
$_['heading_title']			= ' ExcelUp: обновление цен и остатков из Excel';

// Tabs
$_['tab_main']				= 'Основное';
$_['tab_import']			= 'Импорт';
$_['tab_license']			= 'Лицензия';

// Text
$_['text_extension'] 		= 'Модули';
$_['text_success']			= 'Успешно: Вы изменили модуль ExcelUp!';
$_['text_success_import']	= 'Успешно: Обновление товаров успешно выполнено!';
$_['text_edit']				= 'Редактирование ExcelUp';
$_['text_model']			= 'Model (Код товара)';
$_['text_sku']				= 'SKU (Артикул)';
$_['text_product_id']		= 'ID товара';
$_['text_import']			= 'Импорт';
$_['text_copyright']    	= '<p>Модуль бесплатно получен на сайте <strong><a target="_blank" href="https://opencartbot.com/ru/">opencartbot.com</a></strong></p>
<p>Модуль предоставляется по лицензии <a target="_blank" href="https://creativecommons.org/licenses/by-nd/3.0/deed.ru">CC BY-ND 3.0</a>. Вы можете устанавливать его на любых сайтах, модифицировать его код, при этом, не удаляя копирайт автора и ссылки на его сайт.</p>
<p>Автор не предоставляет техническую поддержку по данному бесплатному модулю и не несет ответственность за любые возникающие проблемы.</p>
<p><a target="_blank" href="https://opencartbot.com/ru/excelup">Страница модуля</a></p>
<p>Автор модуля: <strong>opencartbot</strong></p>';

// Entry
$_['entry_status']			= 'Статус';
$_['entry_ident']			= 'Идентификатор товаров';
$_['entry_idcol']			= 'Номер колонки индентификаторов';
$_['entry_firstrow']		= 'Номер первого ряда';
$_['entry_price']			= 'Обновление цен';
$_['entry_pricecol']		= 'Номер колонки цен';
$_['entry_priceup']			= 'Процент наценки';
$_['entry_quantity']		= 'Обновление остатков';
$_['entry_quantitycol']		= 'Номер колонки остатков';
$_['entry_file']			= 'Прайс Excel';
$_['entry_special']			= 'Обновление акций';
$_['entry_special_new']		= 'Создать акцию, если такой не существует';
$_['entry_specialcol']		= 'Номер колонки акционных цен';
$_['entry_specialup']		= 'Процент наценки';

//Help
$_['help_status']			= 'Статус модуля';
$_['help_ident']			= 'Укажите по какому параметру будет производиться сравнение товаров прайса и сайта';
$_['help_idcol']			= 'Номер колонки в прайсе, в которой находятся идентификаторы товаров';
$_['help_firstrow']			= 'Номер ряда в прайсе, с которого начинать импорт';
$_['help_price']			= 'Нужно обновлять цены товаров?';
$_['help_pricecol']			= 'Номер колонки в прайсе, в которой находятся цены товаров';
$_['help_priceup']			= 'Укажите процент наценки. 0 - без наценки.';
$_['help_quantity']			= 'Обновлять количество товаров на складе';
$_['help_quantitycol']		= 'Номер колонки в прайсе, в которой находятся остатки';
$_['help_special']			= 'Обновление цен во вкладке Акции';
$_['help_special_new']		= 'Создать акцию во вкладке Акции, если такой не существует';
$_['help_specialcol']		= 'Номер колонки в прайсе, в которой находятся цены';
$_['help_specialup']		= 'Процент наценки для цены по акции';

// Error
$_['error_permission']		= 'Внимание: У вас нет доступа для управления модулем!';
$_['error_upload']			= 'Ошибка при загрузке файла на сервер! Проверьте права на папку storage/upload';
$_['error_import']			= 'Ошибка при обработке файла или в процессе импорта!';
$_['error_php_version']		= 'Ошибка! Для работы модуля нужно использовать PHP 7.2 или выше';