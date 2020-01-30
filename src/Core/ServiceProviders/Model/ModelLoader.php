<?php

namespace Src\Core\ServiceProviders\Model;

use Src\Core\Model\ModelLoader as Loader;
use Src\Core\ServiceProviders\AbstractServiceProvider;
use src\Exceptions\DIContainerException;

class ModelLoader extends AbstractServiceProvider
{
    /**
     * @var string
     */
    const SERVICE_NAME = 'model_loader';

    /**
     * @throws DIContainerException
     */
    public function init(): void
    {
        $modelLoader = new Loader($this->di);
        $this->di->set(self::SERVICE_NAME, $modelLoader);
    }
}