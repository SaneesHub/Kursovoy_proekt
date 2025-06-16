<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NetworkDevice
 * 
 * @property int $id_device
 * @property string|null $ip_address
 * @property string|null $type_device
 * 
 * @property Collection|Error[] $errors
 * @property Collection|Implement[] $implements
 *
 * @package App\Models
 */
class NetworkDevice extends Model
{
	protected $connection = 'pgsql';
	protected $table = 'network_device';
	protected $primaryKey = 'id_device';
	public $timestamps = false;

	protected $fillable = [
		'ip_address',
		'type_device',
		'mac_address'
	];

	public function errors()
	{
		return $this->hasMany(Error::class, 'id_device');
	}

	public function implements()
	{
		return $this->hasMany(Implement::class, 'id_device');
	}
}
