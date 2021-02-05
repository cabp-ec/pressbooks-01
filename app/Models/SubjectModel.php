<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $identifier'
 * @property string $name
 */
class SubjectModel extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = 'subject';
    protected $primaryKey = 'identifier';
    protected $fillable = ['name'];
    protected $hidden = [];
    protected $prefix;
    protected $logger;

    /**
     * SubjectModel constructor.
     * @param array $attributes
     */
    function __construct(array $attributes = [])
    {
        $this->logger = app('Psr\Log\LoggerInterface');

        parent::__construct($attributes);
    }

    /**
     * Get books for the subject
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function books()
    {
        return $this->hasMany(BookModel::class);
    }
}
