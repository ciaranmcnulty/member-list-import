<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImporterSpec extends ObjectBehavior
{
    function let(\MembersList $membersList, \ImportFile $file)
    {
        $file->getMembers()->willReturn([]);
        $file->delete()->willReturn(null);

        $this->beConstructedWith($membersList, $file);
    }

    function it_handles_file_not_existing(\ImportFile $file)
    {
        $file->getMembers()->willThrow(new \ImportFileNotFound());

        $this->import();
    }

    function it_imports_new_members_into_the_member_list(\MembersList $membersList, \ImportFile $file)
    {

        $member = \Member::fromDetails('124', 'Ciaran', 'true');

        $file->getMembers()->willReturn([$member]);

        $this->import();

        $membersList->addMember($member)->shouldHaveBeenCalled();
    }

    function it_deletes_the_file_after_import(\ImportFile $file)
    {
        $this->import();

        $file->delete()->shouldHaveBeenCalled();
    }
}
