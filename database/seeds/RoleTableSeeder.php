<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Role::class, 1)
        	->create()
        	->each(function($role){
        		$role->users()->save(factory(App\User::class)->make());
        	});
    }
}
