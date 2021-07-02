<?php

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // create admin account
    $Admin = User::create([
      'name' => 'John Doe',
      'email' => 'admin@gmail.com',
      'password' => bcrypt('12345678'),
      'role' => 'admin',
      'remember_token' => Str::random(10),
      'avatar' => 'https://cdn.vuetifyjs.com/images/lists/3.jpg',
      'furi_first' => 'ジョン',
      'furi_last' => 'ドウ',
      'nick_name' => 'Admin-John',
      'name_first' => 'John',
      'name_last' => 'Doe',
    ]);
    // create normal user
    $user = User::create([
      'name' => 'Uri Solomin ',
      'email' => 'solomin@gmail.com',
      'password' => bcrypt('12345678'),
      'role' => 'user',
      'remember_token' => Str::random(10),
      'name_first' => 'Uri',
      'name_last' => 'Solomin',
      'furi_first' => 'ジョン',
      'furi_last' => 'ドウ',
      'nick_name' => 'User-Solomin',
      'avatar' => 'https://cdn.vuetifyjs.com/images/john.jpg',
    ]);
  }
}
