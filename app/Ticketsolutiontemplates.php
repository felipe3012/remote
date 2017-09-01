<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticketsolutiontemplates extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ticketsolutiontemplates';

/**
 * [$primaryKey description]
 * @var string
 */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'entities_id', 'is_recursive', 'name', 'content', 'ticketsolutiontypes_id', 'comment'];
}
