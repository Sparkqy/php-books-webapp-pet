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
     * @var array
     */
    private $connectionOptions = [];

    public function init()
    {
        $this->capsule = new Capsule();
        $this->connectionOptions = require 'src/Configs/database.php';

        $this->capsule->addConnection([
            'driver' => 'mysql',
            'host' => $this->connectionOptions['DB_HOST'],
            'port' => $this->connectionOptions['DB_PORT'],
            'database' => $this->connectionOptions['DB_NAME'],
            'username' => $this->connectionOptions['DB_USER'],
            'password' => $this->connectionOptions['DB_PASSWORD'],
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ]);

        $this->capsule->bootEloquent();
        $this->capsule->setAsGlobal();
        $this->schema = $this->capsule->schema();
    }

    public static function initStatically()
    {
        $capsule = new Capsule();
        $connectionOptions = require $_SERVER['DOCUMENT_ROOT'] . '/../src/Configs/database.php';

        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => $connectionOptions['DB_HOST'],
            'port' => $connectionOptions['DB_PORT'],
            'database' => $connectionOptions['DB_NAME'],
            'username' => $connectionOptions['DB_USER'],
            'password' => $connectionOptions['DB_PASSWORD'],
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ]);

        $capsule->bootEloquent();
        $capsule->setAsGlobal();
    }
}