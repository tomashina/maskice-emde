# Production verification — 2026-10-01

- OpenCart 3.0.3.8 / PHP 7.4.33, Basel, store 0, EUR.
- Selective deployment of 40 runtime files, including accessory views; originals compared byte-for-byte with the private server backup.
- Private backups: existing code and complete setting, event, user_group and extension tables, outside the document root.
- 7,391 active products have confirmed anchors; 194 newer products use their actual first-added dates after explicit owner confirmation. Legacy reference date: 2026-09-10.
- Product 57946 retained its 13.00 EUR selling price; product/category anchor labels and footer price-list link verified.
- First public CSV and XML: 7,391 products, 20 fields, valid content, HTTP 200.
- Cron rejects absent/invalid keys with HTTP 403; correct-header server test returns HTTP 200, success=true, existing=true.
- EasyCron job 11549761 enabled daily at 06:35 Europe/Zagreb, 180-second timeout, authentication only in the HTTP header. No secrets are committed.
- Barcode fields in the product database are empty; the price list therefore exports empty barcode values.
- The configured archive retention is at least 30 days. The first publication is available; older history accumulates with daily runs.

Public page: https://www.maskicezamobitel.hr/index.php?route=information/price_list
