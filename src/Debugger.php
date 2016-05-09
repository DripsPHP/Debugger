<?php

/**
 * Created by Prowect
 * Author: Raffael Kessler
 * Date: 03.04.2016 - 18:00.
 * Copyright Prowect.
 */

namespace Drips\Debugger;

use Drips\Utils\OutputBuffer;

/**
 * Class Debugger.
 *
 * Dient zum Debuggen von PHP-Anwendungen. Erzeugt eine formatierte Ausgabe mit
 * Fehlermeldungen, sofern diese vom Handler erfasst wurden.
 */
class Debugger
{
    /**
     * Beinhaltet ein OutputBuffer-Objekt zum buffern der Ausgabe
     *
     * @var OutputBuffer
     */
    protected $buffer;

    /**
     * Erzeugt eine neue Debugger-Instanz und registriert Error- und Exception-Handler
     */
    public function __construct()
    {
        set_error_handler([Handler::class, "handleError"]);
        set_exception_handler([Handler::class, "handleException"]);
        $this->buffer = new OutputBuffer;
        $this->buffer->start();
    }

    /**
     * Erzeugt einen Codeausschnitt einer Datei und hebt eine bestimmte Zeile hervor
     *
     * @param string $path Dateipfad
     * @param int $line Zeilenzahl die hervorgehoben werden soll
     *
     * @return string
     */
    public static function getCode($path, $line)
    {
        $snippet = 7;
        $code = str_replace('>', '&gt', str_replace('<', '&lt;', file_get_contents($path)));
        $codesplit = explode("\n", $code);
        $lines = count($codesplit);
        $from = $line < $snippet ? 0 : $line - $snippet;
        $to = $lines < $line + $snippet ? $lines + 1 : $line + $snippet;
        $new = array();
        for ($i = $from; $i < $to - 1; $i++) {
            if ($i + 1 == $line) {
                $new[] = "<span class='highlight'>".($i + 1).' '.$codesplit[$i].'</span>';
            } else {
                $new[] = ($i + 1).' '.$codesplit[$i];
            }
        }
        return '<pre><code>'.implode("\n", $new)."\n</code></pre>";
    }

    /**
     * Erzeugt die Fehlerseite mit Auflistung der einzelnen Fehlermeldungen
     */
    public function __destruct()
    {
        $this->buffer->end();
        if(Handler::hasErrors() && PHP_SAPI == "cli"){
            foreach(Handler::getErrors() as $error){
                if($error["isException"]){
                    echo "[".get_class($error["context"])."]: ";
                } else {
                    echo "[ERROR#".$error["number"]."]: ";
                }
                echo $error["desc"].PHP_EOL."\t".$error["file"].":".$error["line"].PHP_EOL;
            }
        } elseif(Handler::hasErrors()){
            require_once __DIR__.'/layout.phtml';
        } else {
            echo $this->buffer->getContent();
        }
    }
}
