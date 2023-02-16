<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    public function permissions() {

       return $this->belongsToMany(Permission::class,'roles_permissions');
           
    }

    public function users() {

       return $this->belongsToMany(User::class,'users_roles');
           
    }
}
