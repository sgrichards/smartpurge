<?php

namespace spec\SmartPurge;

use SmartPurge\SmartPurge;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SmartPurgeSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('username', 'sharedKey', 'shortName');
    }


    function it_is_initializable()
    {
        $this->shouldHaveType(SmartPurge::class);
    }
}
