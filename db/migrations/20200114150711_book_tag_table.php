<?php

use Illuminate\Database\Schema\Blueprint;
use Src\Core\Database\Migration\Migration;

class BookTagTable extends Migration
{
    public function up()
    {
        $this->schema->create('book_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('tag_id');

            $table->foreign('book_id')->references('id')->on('books');
            $table->foreign('tag_id')->references('id')->on('tags');
        });
    }

    public function down()
    {
        $this->schema->dropIfExists('book_tag');
    }
}
