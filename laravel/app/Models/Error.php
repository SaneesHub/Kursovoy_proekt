<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Error
 * 
 * @property int $id_device
 * @property int $code_error
 * @property int $id_role
 * @property int $id_user
 * @property bool|null $status_error
 * @property string|null $description_error
 * 
 * @property NetworkDevice $network_device
 * @property User $user
 *
 * @package App\Models
 */
class Error extends Model
{
	protected $connection = 'pgsql';
	protected $table = 'error';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_device' => 'int',
		'code_error' => 'int',
		'id_role' => 'int',
		'id_user' => 'int',
		'status_error' => 'bool'
	];

	protected $fillable = [
		'id_role',
		'id_user',
		'status_error',
		'description_error'
	];

	public function network_device()
	{
		return $this->belongsTo(NetworkDevice::class, 'id_device');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'id_role')
					->where('User.id_role', '=', 'error.id_role')
					->where('User.id_user', '=', 'error.id_role')
					->where('User.id_role', '=', 'error.id_user')
					->where('User.id_user', '=', 'error.id_user');
	}
}
