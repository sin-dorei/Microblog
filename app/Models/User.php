<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PhpParser\Node\Expr\FuncCall;
use Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * 防止批量赋值安全漏洞的字段白名单
     *
     * @var array
     */
    protected $fillable = [
        'name', 'aemail', 'password',
    ];

    /**
     * 当使用 $user->toArray() 或 $user->toJson() 时隐藏这些字段
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function booted()
    {
        // parent::boot();

        static::creating(function ($user) {
            $user->activation_token = Str::random(10);
        });
    }

    /**
     * 指定模型属性的数据类型
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }
}
