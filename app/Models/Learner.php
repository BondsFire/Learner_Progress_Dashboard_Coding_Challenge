<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Learner extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
    ];

    // public function courses(): HasManyThrough{

    //     return $this->hasManyThrough(Course::class, Enrolment::class, 'learner_id', 'id','id','course_id');
    // }

    public function courses(){

        return $this->belongsToMany(Course::class,'enrolments','course_id','learner_id')->withPivot(['progress']);
    }

}
