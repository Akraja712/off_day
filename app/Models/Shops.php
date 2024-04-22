<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Shops extends Authenticatable
{
    use Notifiable;

    protected $guard = 'shops';

    protected $table = 'shops';


    protected $fillable = [
        'owner_name', 'shop_name', 'phone', 'address', 'logo','email', // Add 'mobile' to the fillable fields
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function findForPassport($mobile)
    {
        return $this->where('mobile', $mobile)->first();
    }
    public function getFullname()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getAvatar()
    {
        return 'https://www.gravatar.com/avatar/' . md5($this->email);
    }
}
