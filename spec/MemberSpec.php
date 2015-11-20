<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MemberSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedFromDetails('1234', 'Ciaran', 'true');
    }

    function it_can_convert_itself_into_array()
    {
        $this->asArray()->shouldReturn(['1234', 'Ciaran', 'true']);
    }
}
