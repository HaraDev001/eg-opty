<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Rank;

class RankSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // create admin account
    Rank::create(['name' => 'VIP']);
    Rank::create(['name' => 'S VIP']);
    Rank::create(['name' => 'SS VIP']);
    Rank::create(['name' => 'QUEEN']);
    Rank::create(['name' => 'KING']);
  }
}
