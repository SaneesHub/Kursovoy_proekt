<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Implement
 * 
 * @property int $id_services
 * @property int $id_device
 * 
 * @property Service $service
 * @property NetworkDevice $network_device
 *
 * @package App\Models
 */
class Implement extends Model
{
	protected $connection = 'pgsql';
	protected $table = 'implements';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = ['id_services', 'id_device'];
	protected $casts = [
		'id_services' => 'int',
		'id_device' => 'int'
	];

	public function service()
	{
		return $this->belongsTo(Service::class, 'id_services');
	}

	public function network_device()
	{
		return $this->belongsTo(NetworkDevice::class, 'id_device');
	}
}
