<?php

namespace NGS\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class NGSUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
