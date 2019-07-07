<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Task
 * @package App\Models
 * @version July 6, 2019, 4:28 pm +05
 *
 * @property string title
 * @property string file
 * @property string filesize
 * @property int num_of_downloads
 * @property string description
 * @property string purpose
 * @property int status
 */
class Task extends Model
{

    public $table = 'tasks';
    


    public $fillable = [
        'title',
        'file',
        'filesize',
        'num_of_downloads',
        'description',
        'purpose',
        'student_id',
        'status',
        'file_headers'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'file' => 'string',
        'filesize' => 'string',
        'description' => 'string',
        'purpose' => 'string',
        'file_headers' => 'array'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'description' => 'required'
    ];

    public function student(){
        return $this->belongsTo('App\Student');
    }

    public function solution(){
        return $this->hasMany('App\Models\Solution');
    }

    public function comment(){
        return $this->hasMany('App\Models\Comment');
    }








    
}
