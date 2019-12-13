# Red de verhalen van Red Een Portret

Eenvoudige statische site om de verhalen van redeenportret.nl te archiveren. 

## Wat te runnen en wanneer

* `php archive-tool/scripts/convert.php` 

Maakt een nieuwe files/redeenportret.json op basis van een XML dump uit Memorix (data/ams_rep_export.xml, niet meegeleverd). 
Alleen te gebruiken als er nog eens een nieuwe XML dump komt.


* `php archive-tool/scripts/convertToHTML.php` 

Maakt HTMl bestanden voor elke letter van het alfabet. Op basis van `files/redeenportret.json`

* `php archive-tool/scripts/names.php > ./names.json`

Genereert een nieuwe names.json file die door de javascript app gebruikt wordt om alle namen te tonen en erheen te scrollen.

