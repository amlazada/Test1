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
        DB::table('Tags')->insert([
        	'id' => '1',
        	'name' => 'tag1'
        ]);
        DB::table('Tags')->insert([
        	'id' => '2',
        	'name' => 'tag2'
        ]);
        DB::table('Tags')->insert([
        	'id' => '3',
        	'name' => 'tag3'
        ]);
        DB::table('Posts')->insert([
        	'id' => '1',
        	'name' => 'name 1',
        	'text' => 'text 1'
        ]);
        DB::table('Posts')->insert([
        	'id' => '2',
        	'name' => 'name 2',
        	'text' => 'text 2'
        ]);
        DB::table('posts_tags')->insert([
        	'post_id' => '1',
        	'tag_id' => '1'
        ]);
        DB::table('posts_tags')->insert([
        	'post_id' => '1',
        	'tag_id' => '2'
        ]);
        DB::table('posts_tags')->insert([
        	'post_id' => '2',
        	'tag_id' => '2'
        ]);
    }
}
