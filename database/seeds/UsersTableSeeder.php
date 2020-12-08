<?php

use App\Store;
use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class, 40)->create()->each(function ($user) {
            $user->store()->save(
                factory(Store::class)->make()
            );
        });
    }
}
