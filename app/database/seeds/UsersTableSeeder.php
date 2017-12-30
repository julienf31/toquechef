<?php
class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->delete();
        DB::table('profiles')->delete();
        $user = array(
            'email' => 'julien.fournier@ynov.com',
            'password' => Hash::make('coucou'),
        );
        $profile = array(
            'id' => 1,
            'firstname' => 'julien',
            'lastname' => 'Fournier',
        );

        DB::table('users')->insert($user);
        DB::table('profiles')->insert($profile);
    }
}