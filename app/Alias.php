<?php

/*
 * This file is part of SMail
 *
 * (c) PageLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PageLab\ServerMail;

use Illuminate\Database\Eloquent\Model;

class Alias extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'aliases';

    /**
     * List of attributes that have a default values.
     *
     * @var mixed[]
     */
    protected $attributes = [
        'domain_id' => 0
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var strings[]
     */
    protected $casts = [
        'id' => 'int'
    ];

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = ['source', 'destination'];

    /**
     * The attributes excluded the model´s JSON from.
     * @var array
     */
    protected $hidden = [];


    /**
     * The validation rules
     *
     * @var string[]
     */
    public $rules = [
        'source' => 'required',
        'destination' => 'required'
    ];

    /**
     * Accounts can belong to a domain
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function domain(){
        return $this->belongsTo(Domain::class);
    }
}
