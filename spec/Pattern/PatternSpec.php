<?php

namespace spec\SmartPurge\Pattern;

use SmartPurge\Pattern\Pattern;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PatternSpec extends ObjectBehavior
{

    function let()
    {
        $this->beConstructedWith('pattern', []);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Pattern::class);
    }
}
