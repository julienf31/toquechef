<?php
class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->delete();
        DB::table('profiles')->delete();

        $users = array(
            array('id' => '1','email' => 'julien.fournier@ynov.com','password' => '$2y$10$rzNXOx6OfburzG3glc4.JebUMShwltmgiGtE1pPllFTWJ/V2Il/IC','remember_token' => '4peEvp1g49VneScLwykQlyh9cPnFu4oKI9ZDRfp6dF98spjmgInc9QgLuDyR','created_at' => '2018-01-14 09:07:07','updated_at' => '2018-01-14 09:06:19'),
            array('id' => '2','email' => 'demo@toquechef.fr','password' => '$2y$10$AYOC9kgQwl.D37sgXCnMUOOJIBrE/TiS.zVBXG0AqOMRqjZqYtGN.','remember_token' => '0IRVUZvSW7c5K4HZIxTkYqC5w0gOo2MLYMk6YA2IzjrfN3JsyJMqtOOr1FoS','created_at' => '2018-01-14 09:07:07','updated_at' => '2018-01-14 09:37:12')
        );

        $profiles = array(
            array('id' => '1','firstname' => 'julien','lastname' => 'Fournier','picture' => 'avatar.png','location' => 'Toulouse, FR','birthdate' => '1995-08-12','description' => '','created_at' => '2018-01-14 09:07:07','updated_at' => '2018-01-14 09:10:52'),
            array('id' => '2','firstname' => 'Bob','lastname' => 'L\'éponge','picture' => 'avatar.jpeg','location' => 'Sous l\'océan','birthdate' => '1992-06-12','description' => 'Je travaille au Krab Croustillan','created_at' => '2018-01-14 09:07:07','updated_at' => '2018-01-14 09:10:52')
        );


        DB::table('users')->insert($users);
        DB::table('profiles')->insert($profiles);
    }
}