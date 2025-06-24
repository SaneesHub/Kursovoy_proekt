<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Message
 * 
 * @property int $id_role
 * @property int $id_user
 * @property int $id_message
 * @property int|null $use_id_role
 * @property int|null $use_id_user
 * @property int|null $id_request
 * @property Carbon|null $date_sending
 * @property string|null $content
 * 
 * @property User $user
 * @property UserRequest|null $user_request
 *
 * @package App\Models
 */
class Message extends Model
{
	protected $connection = 'pgsql';
	protected $table = 'message';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_role' => 'int',
		'id_user' => 'int',
		'id_message' => 'int',
		'use_id_role' => 'int',
		'use_id_user' => 'int',
		'id_request' => 'int',
		'date_sending' => 'datetime'
	];

	protected $fillable = [
		'use_id_role',
		'use_id_user',
		'id_request',
		'date_sending',
		'content'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'id_user', 'id_user');
	}

	public function user_request()
	{
		return $this->belongsTo(UserRequest::class, 'id_request', 'id_request');
	}
}
