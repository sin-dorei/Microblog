<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->times(99)->create();

        $user = User::find(1);
        $user->name = '朱武';
        $user->email = 'zhuwu@qq.com';
        $user->save();

        $user = User::find(2);
        $user->name = '黄信';
        $user->email = 'huangxin@qq.com';
        $user->save();
    }
}
