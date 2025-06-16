<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * 
 * @property int $id_role
 * @property int $id_user
 * @property string|null $fio
 * @property string|null $email
 * @property string|null $hash_password
 * 
 * @property Role $role
 * @property Collection|Error[] $errors
 * @property Collection|ServiceActivation[] $service_activations
 * @property Collection|UserRequest[] $user_requests
 * @property Collection|Message[] $messages
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users_app';
    protected $primaryKey = 'id_user';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'id_role',
        'fio',
        'email',
        'hash_password',
    ];

    // Laravel ожидает метод getAuthPassword
    public function getAuthPassword()
    {
        return $this->hash_password;
    }
    public function getEmailAttribute()
    {
        return $this->attributes['email'];
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = $value;
    }

    public function getPasswordAttribute()
    {
        return $this->attributes['hash_password'];
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['hash_password'] = bcrypt($value);
    }


}
