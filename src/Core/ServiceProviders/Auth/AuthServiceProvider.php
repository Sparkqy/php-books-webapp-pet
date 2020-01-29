<?php

namespace Src\Core\ServiceProviders\Auth;

use Src\Core\ServiceProviders\AbstractServiceProvider;
use src\Exceptions\DIContainerException;
use Src\Services\Auth\Auth;

class AuthServiceProvider extends AbstractServiceProvider
{
    /**
     * @var string
     */
    const SERVICE_NAME = 'auth';

    /**
     * @throws DIContainerException
     */
    public function init(): void
    {
        $auth = new Auth();
        $this->di->set(self::SERVICE_NAME, $auth);
    }
}