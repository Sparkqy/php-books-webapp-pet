<?php

use Illuminate\Database\Schema\Blueprint;
use Src\Core\Database\Migration\Migration;

class BooksTableMigration extends Migration
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
            $table->json('tags')->nullable();
        });
    }

    public function down()
    {
        $this->schema->dropIfExists('books');
    }
}
