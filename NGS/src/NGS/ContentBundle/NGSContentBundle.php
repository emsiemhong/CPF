<?php

namespace NGS\ContentBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class NGSContentBundle extends Bundle
{
	public function getParent()
    {
        return 'MremiContactBundle';
    }
}
