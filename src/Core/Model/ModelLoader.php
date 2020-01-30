<?php

namespace Src\Core\Model;

use Src\Core\DI\DI;
use stdClass;

class ModelLoader
{
    /**
     * @var DI
     */
    protected DI $di;

    /**
     * @var stdClass
     */
    protected stdClass $model;

    /**
     * Model entities path
     * @var string
     */
    const MODEL_NAMESPACE_MASK = '\App\Models\%s';

    /**
     * Model repositories path
     * @var string
     */
    const REPOSITORY_NAMESPACE_MASK = '\App\Repositories\%sRepository';

    /**
     * ModelLoader constructor.
     * @param DI $di
     */
    public function __construct(DI $di)
    {
        $this->di = $di;
        $this->model = new stdClass();
    }

    /**
     * @param string $modelName
     * @return stdClass
     */
    public function loadModel(string $modelName): stdClass
    {
        $modelName = ucfirst($modelName);
        $modelNamespace = sprintf(self::MODEL_NAMESPACE_MASK, $modelName);
        $repositoryNamespace = sprintf(self::REPOSITORY_NAMESPACE_MASK, $modelName);

        $this->model->model = $modelNamespace;
        $this->model->repository = new $repositoryNamespace($this->di);

        return $this->model;
    }
}