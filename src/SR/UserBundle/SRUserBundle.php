<?php

namespace SR\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SRUserBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}
