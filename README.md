# Maskice-emde.hr

OpenCart 3.0.3.8 application source for the Maskice-emde.hr webshop.

Production credentials, runtime storage, logs, generated caches, customer data
and credential-bearing integrations are excluded from Git. Existing production
configuration and integrations must be retained when deploying this repository.

## Sidrene cijene i digitalni cjenik

Projekt uključuje modul sidrenih cijena, revizijski trag, masovni CSV unos te
dnevni javni digitalni cjenik u CSV i XML formatu s arhivom najmanje 30 dana.
Referentni datum je 10. 9. 2026.; vlasnik je potvrdio odgovarajuće početne cijene.

Postupak instalacije, EasyCron, provjere i kontrolirani rollback opisani su u
[`docs/sidrene_cijene_pustanje_na_produkciju.md`](docs/sidrene_cijene_pustanje_na_produkciju.md).

## cPanel deploy

Datoteka `.cpanel.yml` pokreće `tools/deploy-cpanel.sh` prema produkcijskom
document rootu `/home/maskice2/public_html`. Deploy kopira samo datoteke koje
Git prati, nikada ne briše postojeće datoteke i prije svake promjene sprema
prethodnu verziju izvan javnog web direktorija.

Produkcijski `config.php`, `admin/config.php`, slike proizvoda te OpenCart
cache, logovi, sesije, upload i modification direktoriji izričito su zaštićeni
od prepisivanja. Prije prvog produkcijskog deploya pokrenuti lokalni pregled na
serveru:

```bash
bash tools/deploy-cpanel.sh --dry-run /home/maskice2/public_html
```

## Pravni OCMOD paketi

Izvor i reproducibilna izrada paketa za obrazac jednostranog raskida ugovora
i zakonsko jamstvo nalaze se u `extensions/ocmod/`. Paketi se instaliraju kroz
OpenCart Installer, nakon čega treba osvježiti Modifications i predmemoriju teme.
