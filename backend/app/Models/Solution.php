<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Solution
 * @package App\Models
 * @version July 6, 2019, 5:20 pm +05
 *
 * @property string title
 * @property string file
 * @property string filesize
 * @property string description
 */
class Solution extends Model
{

    public $table = 'solutions';
    


    public $fillable = [
        'title',
        'file',
        'filesize',
        'description',
        'task_id',
        'student_id'
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

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'file' => 'required',
        'description' => 'required',
        'task_id'=>'required'
    ];

    public function task(){
        return $this->belongsTo('App\Models\Task');
    }

    public function student(){
        return $this->belongsTo('App\Student');
    }

    
}
