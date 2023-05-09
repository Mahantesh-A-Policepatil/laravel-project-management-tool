<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "projects";

    protected $fillable = [
        'id',
        'name',
        'description',
        'created_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Relationship for user model 
     */
    public function user()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

    /**
     * Accessor for name property
     */
    public function getNameAttribute()
    {
        return  ucfirst($this->attributes['name']); 
    }
}
