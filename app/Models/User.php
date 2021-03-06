<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Str;
use Barryvdh\Debugbar\Facade as Debugbar;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * 防止批量赋值安全漏洞的字段白名单
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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

    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    public function feed()
    {
        $user_ids = $this->followings->pluck('id')->toArray();
        array_push($user_ids, $this->id);

        // $data = Status::whereIn('user_id', $user_ids)->with('user')->orderBy('created_at', 'desc')->get();

        // foreach($data as $item)
        // {
        //     Debugbar::info($item->id);
        // }

        return Status::whereIn('user_id', $user_ids)->with('user')->orderBy('created_at', 'desc');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    public function followOrUnfollow($user_ids)
    {
        $this->followings()->toggle($user_ids);
    }

    public function follow($user_ids)
    {
        // if (!is_array($user_ids)) {
        //     $user_ids = compact($user_ids);
        // }
        $this->followings()->syncWithoutDetaching($user_ids);
    }

    public function unfollow($user_ids)
    {
        // if ( ! is_array($user_ids)) {
        //     $user_ids = compact('user_ids');
        // }
        $this->followings()->detach($user_ids);
    }

    public function isFollowing($user_id)
    {
        return $this->followings->contains($user_id);
    }
}
