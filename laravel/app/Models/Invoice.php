<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Invoice
 * 
 * @property int $id_invoice
 * @property int $id_services
 * @property int $id_role
 * @property int $id_user
 * @property int $id_connection
 * @property float|null $sum_payment
 * @property Carbon|null $date_formation
 * @property bool|null $status_payment
 * 
 * @property ServiceActivation $service_activation
 *
 * @package App\Models
 */
class Invoice extends Model
{
	protected $connection = 'pgsql';
	protected $table = 'invoice';
	protected $primaryKey = 'id_invoice';
	public $timestamps = false;

	protected $casts = [
		'id_services' => 'int',
		'id_role' => 'int',
		'id_user' => 'int',
		'id_connection' => 'int',
		'sum_payment' => 'float',
		'date_formation' => 'datetime',
		'status_payment' => 'bool'
	];

	protected $fillable = [
		'id_services',
		'id_role',
		'id_user',
		'id_connection',
		'sum_payment',
		'date_formation',
		'status_payment'
	];

	public function service_activation()
	{
		return $this->belongsTo(ServiceActivation::class, 'id_services')
					->where('service_activation.id_services', '=', 'invoice.id_services')
					->where('service_activation.id_role', '=', 'invoice.id_services')
					->where('service_activation.id_user', '=', 'invoice.id_services')
					->where('service_activation.id_connection', '=', 'invoice.id_services')
					->where('service_activation.id_services', '=', 'invoice.id_role')
					->where('service_activation.id_role', '=', 'invoice.id_role')
					->where('service_activation.id_user', '=', 'invoice.id_role')
					->where('service_activation.id_connection', '=', 'invoice.id_role')
					->where('service_activation.id_services', '=', 'invoice.id_user')
					->where('service_activation.id_role', '=', 'invoice.id_user')
					->where('service_activation.id_user', '=', 'invoice.id_user')
					->where('service_activation.id_connection', '=', 'invoice.id_user')
					->where('service_activation.id_services', '=', 'invoice.id_connection')
					->where('service_activation.id_role', '=', 'invoice.id_connection')
					->where('service_activation.id_user', '=', 'invoice.id_connection')
					->where('service_activation.id_connection', '=', 'invoice.id_connection');
	}
}
