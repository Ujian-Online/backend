<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAsesi extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'phone_number',
        'gender',
        'birth_place',
        'birth_date',
        'no_ktp',
        'pendidikan_terakhir',
        'has_job',
        'job_title',
        'job_address',
        'company_name',
        'company_phone',
        'company_email',
        'user_id_admin',
        'is_verified',
        'verification_note',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'gender'        => 'boolean',
        'birth_date'    => 'date',
        'has_job'       => 'boolean',
        'is_verified'   => 'boolean',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id_admin',
    ];

    /**
     * Return Gender (Boolean) as String
     * - Pria (true)
     * - Wanita (false)
     *
     * @param $value
     *
     * @return string
     */
    public function getGenderAttribute($value) {
        return $value ? 'Pria' : 'Wanita';
    }

    /**
     * Format Date
     *
     * @param $value
     * @return string
     */
    public function getBirthDateAttribute($value) {
        return \Carbon\Carbon::parse($value)->toDateString();
    }

    /**
     * Relation to Table User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function User()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    /**
     * Relation to Table UserAsesiCustomData
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function AsesiCustomData()
    {
        return $this->hasMany('App\UserAsesiCustomData', 'asesi_id', 'user_id');
    }

    public function Order()
    {
        return $this->hasMany('App\Order', 'asesi_id', 'user_id');
    }

    public function SingleOrder()
    {
        return $this->hasOne('App\Order', 'asesi_id', 'user_id');
    }

    public function Admin()
    {
        return $this->hasOne('App\User', 'id', 'user_id_admin');
    }
}
