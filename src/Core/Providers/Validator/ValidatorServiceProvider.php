<?php

namespace Src\Core\Providers\Validator;

use Src\Core\Providers\AbstractServiceProvider;
use src\Exceptions\DIContainerException;
use Src\Exceptions\FileNotFoundException;
use Src\Services\Validation\Validator;

class ValidatorServiceProvider extends AbstractServiceProvider
{
    /**
     * @var string
     */
    const SERVICE_NAME = 'validator';

    /**
     * @throws FileNotFoundException
     * @throws DIContainerException
     */
    public function init(): void
    {
       $validator = new Validator();
       $this->di->set(self::SERVICE_NAME, $validator);
    }
}