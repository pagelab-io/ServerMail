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

class Account extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'accounts';

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
    protected $fillable = ['email', 'password'];

    /**
     * The attributes excluded the model´s JSON from.
     * @var array
     */
    protected $hidden = ['password'];


    /**
     * The validation rules
     *
     * @var string[]
     */
    public $rules = [
        'email' => 'required|email'
    ];

    /**
     * Accounts can belong to a domain
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function domain(){
        return $this->belongsTo(Domain::class);
    }
}
