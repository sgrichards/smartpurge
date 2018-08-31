<?php

namespace spec\SmartPurge\Tag;

use SmartPurge\Tag\Tag;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TagSpec extends ObjectBehavior
{

    function let()
    {
        $this->beConstructedWith('tag');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Tag::class);
    }
}
