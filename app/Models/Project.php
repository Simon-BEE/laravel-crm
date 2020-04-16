<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    /**
     * Check if a projects collection is not empty and has projects in progress
     *
     * @param [type] $projects
     * @return boolean
     */
    public static function isNotEmptyAndArchived($projects)
    {
        $projectsInProgress = $projects->filter(function($project, $key){
            if ($project && $project->status_id != 3 && $project->status_id != 4) {
                return $project;
            }
        });

        return $projectsInProgress->isNotEmpty() ?? false;
    }

    // SCOPES

    /**
     * Get only id and name in projects in progress
     *
     * @param Builder $query
     * @param integer $customerId
     * @return void
     */
    public function scopeEssentialDataByCustomer(Builder $query, int $customerId)
    {
        return $query
            ->select('id', 'name')
            ->where('customer_id', $customerId)
            ->where('status_id', '!=', 3)
            ->where('status_id', '!=', 4)
            ->get()
        ;
    }

    public function scopeMine(Builder $query)
    {
        return $query->where('customer_id', auth()->id());
    }

    // ATTRIBUTES

    public function getActualStatusAttribute()
    {
        return "<span class=\"badge badge-" . $this->status->color->name . "\"> " . $this->status->name . "</span>";
    }

    // RELATIONS

    public function estimates()
    {
        return $this->hasMany(Estimate::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id')->withTrashed();
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id')->withTrashed();
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
