<?php

use App\Models\Book;
use App\Models\Tag;
use Phinx\Seed\AbstractSeed;

class BookTagSeeder extends AbstractSeed
{
    public function getDependencies()
    {
        return [
            'BooksSeeder',
            'TagsSeeder',
        ];
    }

    public function run()
    {
        $books = [
            ['id' => 1],
            ['id' => 2],
            ['id' => 3],
        ];

        $tags = [1, 2, 3, 4, 5];

        foreach ($books as $book) {
            $tagsCount = rand(1, 5);
            $bookTags = array_intersect_key($tags, (array) array_rand($tags, $tagsCount));

            foreach ($bookTags as $tag) {
                $this->table('book_tag')
                    ->insert([
                        'book_id' => $book['id'],
                        'tag_id' => $tag,
                    ])
                    ->save();
            }
        }
    }
}
