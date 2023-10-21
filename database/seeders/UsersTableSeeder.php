<?php




namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        DB::table('users')->insert(
        [
            'name' => 'priyanka kothyari',
            'email' => 'priyanka12@gmail.com',
            'email_verified_at'=>now(),
            'password' => bcrypt('12345678'),
        ]);

        \App\Models\User::factory(10)->create();
    }
}


