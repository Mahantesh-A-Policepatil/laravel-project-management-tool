<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ProjectTask extends Model
{
    use HasFactory;

    protected $table = "project_tasks";
    protected $appends = ["open"];
 
    public function getOpenAttribute(){
        return true;
    }
    public function getStartDateAttribute()
    {
        return  isset($this->attributes['start_date']) ? Carbon::parse($this->attributes['start_date'])->format('d-m-Y h:i:s') : null;
    }
}
