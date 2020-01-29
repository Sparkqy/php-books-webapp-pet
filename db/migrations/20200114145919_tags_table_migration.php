<?php

use Illuminate\Database\Schema\Blueprint;
use Src\Core\Database\Eloquent\Eloquent;

class TagsTableMigration extends Eloquent
{
    public function up()
    {
        $this->schema->create('tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
        });
    }

    public function down()
    {
        $this->schema->dropIfExists('tags');
    }
}
