<?php

namespace spec\SmartPurge;

use SmartPurge\SmartPurgeFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SmartPurgeFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SmartPurgeFactory::class);
    }
}
