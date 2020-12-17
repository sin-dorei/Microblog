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
        factory(User::class)->times(11)->create();

        $user = User::find(1);
        $user->name = '朱武';
        $user->email = 'zhuwu@qq.com';
        $user->is_admin = true;
        $user->save();

        $user = User::find(2);
        $user->name = '黄信';
        $user->email = 'huangxin@qq.com';
        $user->save();

        $user = User::find(9);
        $user->name = '无名神魔';
        $user->email = '576051199@qq.com';
        $user->save();
    }
}
