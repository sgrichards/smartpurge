<?php

namespace spec\SmartPurge;

use SmartPurge\Pattern\Pattern;
use SmartPurge\SmartPurge;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SmartPurge\Tag\Tag;

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

    function it_should_get_a_pattern()
    {
        $this->getPattern('pattern')->shouldBeAnInstanceOf(Pattern::class);
    }

    function it_should_get_a_tag()
    {
        $this->getTag('tag')->shouldBeAnInstanceOf(Tag::class);
    }

}
