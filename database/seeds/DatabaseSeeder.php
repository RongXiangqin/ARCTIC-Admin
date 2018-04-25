<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //database seeder command
        //php artisan migrate:refresh --seed

        //VERY IMPORTANT
        //DONT CHANGE ANGYTHING
        //CHECK ENV
        $this->command->info('===========================');
        $this->command->info('Start Database Seeding...');
        if ($_ENV['APP_SERVER'] == '10.254.253.238') {
            // 当前正处于本地开发环境
            $this->command->info('Please wait updating the data...');
            $this->call('Ferret_albumsSeeder');

            $this->command->info('Updating the data completed !');
        } else {
            $this->command->info('environment checking failure quit');
        }
    }

}

class Ferret_albumsSeeder extends Seeder
{

    public function run()
    {
        //$sql = File::get(database_path().'seeds/sql/ferret_albums.sql');
        //app('db')->statement($sql);
    }
}