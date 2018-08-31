<?php

namespace spec\SmartPurge;

use SmartPurge\SmartPurgeException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SmartPurgeExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SmartPurgeException::class);
    }
}
