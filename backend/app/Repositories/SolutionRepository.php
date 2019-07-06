<?php

namespace App\Repositories;

use App\Models\Solution;
use App\Repositories\BaseRepository;

/**
 * Class SolutionRepository
 * @package App\Repositories
 * @version July 6, 2019, 5:20 pm +05
*/

class SolutionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'file',
        'filesize',
        'description'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Solution::class;
    }
}
