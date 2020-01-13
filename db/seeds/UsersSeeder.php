<?php

use Phinx\Seed\AbstractSeed;
use Src\Services\Auth\Auth;

class UsersSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $users = [];

        for ($i = 1; $i <= 2; $i++) {
            $users[] = [
                'email' => $faker->email,
                'first_name' => $faker->name,
                'last_name' => $faker->lastName,
                'password' => Auth::encryptPassword('admin'),
                'hash' => $faker->sha1,
                'is_admin' => ($i == 1) ? true : false,
            ];
        }

        $this->table('users')
            ->insert($users)
            ->save();
    }
}
