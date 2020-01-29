<?php

use Illuminate\Database\Schema\Blueprint;
use Src\Core\Database\Eloquent\Eloquent;

class BooksTableMigration extends Eloquent
{
    public function up()
    {
        $this->schema->create('books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('isbn');
            $table->string('name');
            $table->string('url');
            $table->string('poster');
            $table->float('price');
        });
    }

    public function down()
    {
        $this->schema->dropIfExists('books');
    }
}
