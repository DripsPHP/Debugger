<?php

/**
 * Created by Prowect
 * Author: Lars Müller
 * Date: 03.05.15 - 13:13.
 * Copyright Prowect
 */

/**
 * Alternative zu var_dump mit formatierter HTML-Ausgabe
 *
 * @param   mixed  $var
 * @param  integer $indentBy
 * @param  integer $indentationLevel
 */
function dump($var, $indentBy = 2, $indentationLevel = 0)
{
    $stringStyle = 'color:#8cc152;';
    $propertyStyle = 'color:#967adc;';
    $classStyle = 'color:#f6bb42;';
    $nullStyle = 'color:#aab2bd;';
    $integerStyle = 'color:#e9573f;';
    $doubleStyle = 'color:#e9573f;';
    $boolStyle = 'color:#aab2bd;';
    $arrayStyle = '';
    $resourceStyle = '';
    $privateStyle = '';
    $unknownTypeStyle = '';

    if (PHP_SAPI == "cli") {
        var_dump($var);
    } else {
        if ($indentationLevel == 0) {
            echo '<pre style="background-color:#434a54;color:#f5f7fa;padding:1em;">'.PHP_EOL;
        }
        $parentIndentation = str_repeat(" ", $indentationLevel);
        $indentation = str_repeat(" ", $indentBy);
        if ($var === null) {
            echo '<span style="'.$nullStyle.'">NULL</span>'.PHP_EOL;
        } elseif (is_array($var)) {
            $array = (array) $var;
            $type = 'array';
            $len = sizeof($array);
            echo $type.' ('.$len.') '.'{';
            if ($len > 0) {
                echo PHP_EOL;
                foreach ($array as $key => $value) {
                    echo $parentIndentation.$indentation.'['.$key.'] =&gt; ';
                    dump($value, $indentBy, $indentationLevel + $indentBy);
                }
                echo $parentIndentation;
            }
            echo '}'.PHP_EOL;
        } elseif (is_object($var)) {
            $type = 'object';
            $reflect = new ReflectionClass($var);
            $properties = $reflect->getProperties();
            $len = sizeof($properties);
            echo $type.'<span style="'.$classStyle.'">('.$reflect->getName().')</span>'.' ('.$len.') '.'{'.PHP_EOL;
            foreach ($properties as $property) {
                echo $parentIndentation.$indentation.'<span style="'.$propertyStyle.'">['.($property->isStatic() ? 'static ' : '').($property->isPublic() ? 'public ' : ($property->isProtected() ? 'protected ' : ($property->isPrivate() ? 'private ' : ''))).'$'.$property->getName().']</span> =&gt; ';
                $property->setAccessible(true);
                dump($property->getValue($var), $indentBy, $indentationLevel + $indentBy);
            }
            echo $parentIndentation.'}'.PHP_EOL;
        } elseif (is_string($var)) {
            echo gettype($var).' ('.strlen($var).') <span style="'.$stringStyle.'">"'.$var.'"</span>'.PHP_EOL;
        } elseif (is_bool($var)) {
            echo gettype($var).' <span style="'.$boolStyle.'">'.(($var == 1) ? 'true' : 'false').'</span>'.PHP_EOL;
        } else {
            $type = gettype($var);
            echo $type.' ('.sizeof($var).') <span style="'.${str_replace(' t', 'T', gettype($var)).'Style'}.'">'.$var.'</span>'.PHP_EOL;
        }
        if ($indentationLevel == 0) {
            echo '</pre>';
        }
    }
}
