<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, SoftCascadeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'role_id', 'address', 'know'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The relations must be deleted in cascade with softDeleting.
     *
     * @var array
     */
    protected $softCascade = ['projects', 'tickets', 'replies'];

    // SCOPES

    public function scopeCustomers($query)
    {
        return $query->where('id', '!=', auth()->id());
    }

    public function scopeCustomersWithProjects($query)
    {
        return $query->where('id', '!=', auth()->id())->with('projects');
    }

    // ATTRIBUTES

    public function getNameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getManagerAttribute()
    {
        return $this->role->name === 'manager';
    }

    public function getCustomerAttribute()
    {
        return $this->role->name === 'customer';
    }

    public function getIsDeleteAttribute()
    {
        return $this->deleted_at ?? false;
    }

    // RELATIONS

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function estimates()
    {
        return $this->hasMany(Estimate::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
