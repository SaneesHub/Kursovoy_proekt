<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ServiceActivation
 * 
 * @property int $id_services
 * @property int $id_role
 * @property int $id_user
 * @property int $id_connection
 * @property Carbon|null $date_connection
 * @property Carbon|null $date_disconnection
 * @property string|null $name_guest
 * @property string|null $email_guest
 * @property string|null $address_connection
 * 
 * @property Service $service
 * @property User $user
 * @property Collection|Invoice[] $invoices
 *
 * @package App\Models
 */
class ServiceActivation extends Model
{
	protected $connection = 'pgsql';
	protected $table = 'service_activation';
	protected $primaryKey = 'id_connection';
	public $incrementing = true;
	public $timestamps = false;

	protected $casts = [
		'id_services' => 'int',
		'id_role' => 'int',
		'id_user' => 'int',
		'id_connection' => 'int',
		'date_connection' => 'datetime',
		'date_disconnection' => 'datetime'
	];

	protected $fillable = [
		'id_services',
        'id_role',
        'id_user',
        'date_connection',
        'date_disconnection',
        'name_guest',
        'email_guest',
        'address_connection'
	];

	public function service()
	{
		return $this->belongsTo(Service::class, 'id_services', 'id_services');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'id_role', 'id_user')
					->where('User.id_user', '=', 'service_activation.id_role')
					->where('User.id_role', '=', 'service_activation.id_role')
					->where('User.id_role', '=', 'service_activation.id_user')
					->where('User.id_user', '=', 'service_activation.id_user');
	}

	public function invoices()
	{
		return $this->hasMany(Invoice::class, 'id_connection');
	}
}
