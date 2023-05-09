<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "activities";

    protected $fillable = [
        'id',
        'hours',
        'comment',
        'task_id',
        'project_id',
        'created_by',
        'project_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Relationship for project model 
     */
    public function project()
    {
        return $this->belongsTo(Project::class,'project_id','id');
    }

    /**
     * Relationship for user model 
     */
    public function reporter()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

    /**
     * Relationship for task model 
     */
    public function task()
    {
        return $this->belongsTo(Task::class,'task_id','id');
    }
}
