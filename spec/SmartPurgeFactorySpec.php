<?php

namespace spec\SmartPurge;

use SmartPurge\SmartPurge;
use SmartPurge\SmartPurgeFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SmartPurgeFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SmartPurgeFactory::class);
    }

    function it_should_build_a_smartpurge_object()
    {
        $this->build('username', 'sharedKey', 'shortName')->shouldBeAnInstanceOf(SmartPurge::class);
    }
}
