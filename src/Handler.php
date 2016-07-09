<?php

/**
 * Created by Prowect
 * Author: Raffael Kessler
 * Date: 03.04.2016 - 18:00.
 * Copyright Prowect.
 */

namespace Drips\Debugger;

use Throwable;
use Drips\Utils\Event;

/**
 * Class Handler.
 *
 * Beinhaltet Funktionen zum Behandeln von PHP-Fehlern und Exceptions und kann
 * somit als Error- und Exceptionhandler eingesetzt werden.
 */
class Handler
{
    use Event;
    /**
     * Beinhaltet alle Fehlerinformationen über entstandene PHP-Fehler und Exceptions
     *
     * @var array
     */
    protected static $errors = array();

    /**
     * Dient zum Handeln von PHP-Fehlern
     *
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     * @param mixed $errcontext
     * @param bool $isException
     */
    public static function handleError($errno, $errstr, $errfile, $errline, $errcontext, $isException = false)
    {
        $error = array(
            'number' => $errno,
            'desc' => $errstr,
            'file' => $errfile,
            'line' => $errline,
            'context' => $errcontext,
            'isException' => $isException,
        );
        $handled = false;
        if($isException){
            $handled = static::call(get_class($errcontext), $handled);
        }
        if(!$handled){
            static::$errors[] = $error;
        }
    }

    /**
     * Dient zum Handeln von Exceptions
     *
     * @param Exception $exception
     */
    public static function handleException($exception)
    {
        static::handleError($exception->getCode(), $exception->getMessage(), $exception->getFile(), $exception->getLine(), $exception, true);
    }

    /**
     * Liefert alle entstandenen Fehlermeldungen als Array zurück
     *
     * @return array
     */
    public static function getErrors()
    {
        return static::$errors;
    }

    /**
     * Gibt zurück ob der Handler bereits Fehler oder Exceptions aufgefangen hat
     * oder nicht.
     *
     * @return bool
     */
    public static function hasErrors()
    {
        return !empty(static::$errors);
    }
}
