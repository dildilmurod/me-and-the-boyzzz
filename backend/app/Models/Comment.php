<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Comment
 * @package App\Models
 * @version July 6, 2019, 6:44 pm +05
 *
 * @property string comment
 * @property integer student_id
 */
class Comment extends Model
{

    public $table = 'comments';
    


    public $fillable = [
        'comment',
        'student_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'comment' => 'string',
        'student_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'comment' => 'required'
    ];


    public function task(){
        return $this->belongsTo('App\Models\Task');
    }








    
}
