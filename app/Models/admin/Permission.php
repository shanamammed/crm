<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory;
    protected $dates = ['deleted_at'];

    public function roles() {

       return $this->belongsToMany(Role::class,'roles_permissions');
           
    }

    public function users() {

       return $this->belongsToMany(User::class,'users_permissions');
           
    }
}
