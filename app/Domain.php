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

class Domain extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'domains';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * The attributes excluded from the model´s JSON from.
     * @var array
     */
    protected $hidden = [];

    /**
     * Gets the related accounts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts(){
        return $this->hasMany(Account::class);
    }

    /**
     * Gets the related accounts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function aliases(){
        return $this->hasMany(Alias::class);
    }

    /**
     * Filter all domains by name
     *
     * @param $query
     * @param $name
     */
    public function scopeName($query, $name){

        if (trim($name) != '') {
            $query->where('name', 'LIKE', "'%$name%'");
        }
    }
}
