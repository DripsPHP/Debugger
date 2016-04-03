# Debugger

[![Build Status](https://travis-ci.org/Prowect/Debugger.svg)](https://travis-ci.org/Prowect/Debugger)
[![Code Climate](https://codeclimate.com/github/Prowect/Debugger/badges/gpa.svg)](https://codeclimate.com/github/Prowect/Debugger)
[![Test Coverage](https://codeclimate.com/github/Prowect/Debugger/badges/coverage.svg)](https://codeclimate.com/github/Prowect/Debugger/coverage)
[![Latest Release](https://img.shields.io/packagist/v/drips/Debugger.svg)](https://packagist.org/packages/drips/debugger)

## Beschreibung

Diese Komponente dient zum Debuggen von PHP-Anwendungen.

## Fehlerseite

Wird der Debugger verwendet, so erzeugt dieser eine Fehlerseite wenn es zu einem Fehler kommt. Hierfür muss man lediglich ein neues Debugger-Objekt erzeugen:

```php
<?php
use Drips\Debugger\Debugger;

$debugger = new Debugger;
```
> Der Debugger beginnt logischerweise erst dann Fehler abzufangen, sobald er angelegt wurde.  
> *Einige Fehler können über den Debugger nicht abgefangen werden, wie z.B.: Syntaxfehler.*

## Exceptions abfangen

Sobald eine Exception geworfen wird, die nicht abgefangen wurde, wird ein Event ausgelöst. Dieses Event kann abgefangen werden und anschließend separat behandelt werden.

### Beispiel

```php
<?php
use Drips\Debugger\Handler;

// Anstelle von {EXCEPTION_NAME} gehört natürlich der jeweilige Name der Exception eingetragen.
Handler::on("{EXCEPTION_NAME}", function()){
    echo "FEHLER!!";
    return true;
});
```

> Der Rückgabewert der Funktion gibt an, ob Sie bereits die Fehlerbehandlung vorgenommen haben oder nicht. Wird `true` zurückgegeben, so wird keine Fehlerseite erzeugt. Wird jedoch `false` zurückgegeben wird keine Fehlerseite erzeugt.

## Dump

Zusätzlich verfügt der Debugger über eine Funktion `dump()` die als Alternative zu `var_dump()` und `print_r()` benutzt werden kann.

Im Gegensatz zu den bestehenden PHP-Funktionen verfügt diese über eine formatierte HTML-Ausgabe.

### Beispiel

```php
<?php
$var = array("a", "b", 1, 3);
dump($var);
```
