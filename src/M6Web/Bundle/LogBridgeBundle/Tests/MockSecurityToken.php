<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;


class MockSecurityToken extends AbstractToken
{

    public function __toString()
    {
        return $this->getUser()->getUsername();
    }

    public function getCredentials()
    {
        return 'test';
    }


}
