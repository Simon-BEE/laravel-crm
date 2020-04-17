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
        'firstname', 'lastname', 'email',
        'password', 'role_id', 'address',
        'knew', 'changed', 'settings', 'last_login_at',
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

    protected $dates = ['last_login_at'];

    /**
     * The relations must be deleted in cascade with softDeleting.
     *
     * @var array
     */
    protected $softCascade = ['projects', 'tickets', 'replies', 'address'];

    protected static function boot(){
        parent::boot();

        static::created(function($user){
            $user->address()->create([
                'user_id' => $user->id
            ]);
        });
    }

    // SCOPES

    public function scopeCustomers($query)
    {
        $roleId = Role::where('name', 'customer')->first()->id;
        return $query->where('role_id', $roleId)->with('address');
    }

    public function scopeCustomersWithProjects($query)
    {
        $customers = $this->scopeCustomers($query)->with(['projects'])->get();
        return $customers->filter(function($customer, $key){
            if ($customer->hasProjects) {
                return $customer;
            }
        });
    }

    public function scopeCustomersWithAddressAndProjects($query)
    {
        $customers = $this->scopeCustomersWithProjects($query);
        return $customers->filter(function($customer, $key){
            if ($customer->hasAddress && $customer->hasProjectsInProgress) {
                return $customer;
            }
        });
    }

    // ATTRIBUTES

    /**
     * Concat firstname and lastname
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    /**
     * Get a string with all address attributes
     *
     * @return string
     */
    public function getCompleteAddressAttribute()
    {
        return $this->address->getCompleteAddress();
    }

    /**
     * Get a string with only city and country attributes
     *
     * @return string
     */
    public function getPartialAddressAttribute()
    {
        return $this->address->getPartialAddress();
    }

    /**
     * Check if user's address has been filled
     *
     * @return bool
     */
    public function getHasAddressAttribute()
    {
        return $this->address->address_1 ? true : false;
    }

    /**
     * Check if user has project(s) in progress
     *
     * @return bool
     */
    public function getHasProjectsAttribute()
    {
        return $this->projects->isNotEmpty();
    }

    /**
     * Check if user has project(s) in progress
     *
     * @return bool
     */
    public function getHasProjectsInProgressAttribute()
    {
        return Project::isNotEmptyAndArchived($this->projects);
    }

    /**
     * Check if user is an admin
     *
     * @return bool
     */
    public function getIsAdminAttribute()
    {
        return $this->role->name === 'admin';
    }

    /**
     * Check if user is a customer
     *
     * @return bool
     */
    public function getIsCustomerAttribute()
    {
        return $this->role->name === 'customer';
    }

    /**
     * Check if user is deleted
     *
     * @return string|bool
     */
    public function getIsDeleteAttribute()
    {
        return $this->deleted_at ?? false;
    }

    /**
     * Decode json of settings user's attribute
     *
     * @param JSON $value
     * @return object
     */
    public function getSettingsAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * Return pagination settings of user
     *
     * @return ?integer
     */
    public function getPaginationAttribute()
    {
        return $this->settings ? $this->settings->pagination : null;
    }

    // RELATIONS

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'customer_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function customerEstimates()
    {
        return $this->hasMany(Estimate::class, 'customer_id');
    }

    public function adminEstimates()
    {
        return $this->hasMany(Estimate::class, 'admin_id');
    }

    public function customerInvoices()
    {
        return $this->hasMany(Invoice::class, 'customer_id');
    }

    public function adminInvoices()
    {
        return $this->hasMany(Invoice::class, 'admin_id');
    }
}
