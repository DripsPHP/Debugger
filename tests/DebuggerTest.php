<?php

namespace tests;

use Drips\Debugger\Debugger;
use PHPUnit_Framework_TestCase;

class DebuggerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testDebugger()
    {
        $debugger = Debugger::getInstance();
        $this->assertTrue($debugger->isEnabled());
        $debugger->disable();
        $this->assertFalse($debugger->isEnabled());
        $debugger->enable();
        $this->assertTrue($debugger->isEnabled());
        $debugger->__destruct();
    }
}
