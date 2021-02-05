<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id'
 * @property string $img_created_at
 * @property string $img_updated_at
 */
class BookModel extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = 'book';
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $hidden = [];
    protected $prefix;
    protected $logger;

    /**
     * BookModel constructor.
     * @param array $attributes
     */
    function __construct(array $attributes = [])
    {
        $this->logger = app('Psr\Log\LoggerInterface');

        parent::__construct($attributes);
    }
}
