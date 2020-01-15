<?php


use Phinx\Seed\AbstractSeed;

class TagsSeeder extends AbstractSeed
{
    public function run()
    {
        $data = [
            ['name' => 'tag1'],
            ['name' => 'tag2'],
            ['name' => 'tag3'],
            ['name' => 'tag4'],
            ['name' => 'tag5'],
        ];

        $this->table('tags')
            ->insert($data)
            ->save();
    }
}
