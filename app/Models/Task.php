<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "tasks";

    protected $fillable = [
        'id',
        'name',
        'assignee',
        'status',
        'priority',
        'created_by',
        'project_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function getNameAttribute()
    {
        return  ucfirst($this->attributes['name']);         
    }

    public function getStatusAttribute()
    {
        if($this->attributes['status'] == 'in_progress')
        {
            return "In Progress";
        }else{
            return ucfirst($this->attributes['status']); 
        }
    }
    
    public function getPriorityAttribute()
    {
        return  ucfirst($this->attributes['priority']);         
    }
    /**
     * Relationship for user model 
     */
    public function reporter()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }
    /**
     * Relationship for user model 
     */
    public function assigned_user()
    {
        return $this->belongsTo(User::class,'assignee','id');
    }
    /**
     * Relationship for project model 
     */
    public function project()
    {
        return $this->belongsTo(Project::class,'project_id','id');
    }

    /**
     * Relationship for activity model 
     */
    public function taskActivity()
    {
        return $this->belongsTo(Activity::class,'id','id');
    }

}
