<?php

namespace spec\SmartPurge\Client;

use SmartPurge\Client\LimelightClient;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LimelightClientSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(LimelightClient::class);
    }
}
