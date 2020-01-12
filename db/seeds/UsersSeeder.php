<?php

use Phinx\Seed\AbstractSeed;

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
                'first_name' => $faker->name,
                'last_name' => $faker->lastName,
                'password' => $faker->password,
                'is_admin' => ($i == 1) ? true : false,
            ];
        }

        $this->table('users')
            ->insert($users)
            ->save();
    }
}
