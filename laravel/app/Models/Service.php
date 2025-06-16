<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Service
 * 
 * @property int $id_services
 * @property float|null $tariff_price
 * @property string|null $description_services
 * @property string|null $type_services
 * 
 * @property Collection|Implement[] $implements
 * @property Collection|ServiceActivation[] $service_activations
 *
 * @package App\Models
 */
class Service extends Model
{
	protected $connection = 'pgsql';
	protected $table = 'services';
	protected $primaryKey = 'id_services';
	public $timestamps = false;

	protected $casts = [
		'tariff_price' => 'float'
	];

	protected $fillable = [
		'tariff_price',
		'description_services',
		'type_services'
	];

	public function implements()
	{
		return $this->hasMany(Implement::class, 'id_services');
	}

	public function service_activations()
	{
		return $this->hasMany(ServiceActivation::class, 'id_services');
	}
}
