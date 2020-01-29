<?php

use Illuminate\Database\Schema\Blueprint;
use Src\Core\Database\Eloquent\Eloquent;

class BookTagTable extends Eloquent
{
    public function up()
    {
        $this->schema->create('book_tag', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('tag_id');

            $table->foreign('book_id')
                ->references('id')
                ->on('books')
                ->onDelete('cascade');
            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        $this->schema->dropIfExists('book_tag');
    }
}
