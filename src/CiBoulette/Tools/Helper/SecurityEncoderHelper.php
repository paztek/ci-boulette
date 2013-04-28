<?php

namespace CiBoulette\Tools\Helper;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

use Symfony\Component\Console\Helper\Helper;

class SecurityEncoderHelper extends Helper
{
    protected $_encoder;

    public function __construct(PasswordEncoderInterface $encoder)
    {
        $this->_encoder = $encoder;
    }

    public function getEncoder()
    {
        return $this->_encoder;
    }

    public function getName()
    {
        return 'encoder';
    }
}