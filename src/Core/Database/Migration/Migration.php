<?php

namespace Src\Core\Database\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Builder;
use Phinx\Migration\AbstractMigration;

class Migration extends AbstractMigration
{
    /** @var Capsule $capsule */
    protected $capsule;

    /** @var Builder $capsule */
    protected $schema;

    /**
     * Init Phinx in cmd
     */
    public function init()
    {
        $this->capsule = new Capsule();

        $this->capsule->addConnection([
            'driver' => 'mysql',
            'host' => '172.25.0.1',
            'port' => 3306,
            'database' => 'php-books',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
            'collation' => 'utf8_general_ci',
        ]);

        $this->capsule->bootEloquent();
        $this->capsule->setAsGlobal();
        $this->schema = $this->capsule->schema();
    }

    /**
     * Init Phinx without creating instance inside the Src\App
     */
    public static function initStatically()
    {
        $capsule = new Capsule();

        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => '172.25.0.1',
            'port' => 3306,
            'database' => 'php-books',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
            'collation' => 'utf8_general_ci',
        ]);

        $capsule->bootEloquent();
        $capsule->setAsGlobal();
    }
}