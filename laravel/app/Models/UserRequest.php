<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserRequest
 * 
 * @property int $id_role
 * @property int $id_user
 * @property int $id_request
 * @property string|null $type_request
 * @property Carbon|null $date_request
 * @property bool|null $status_review
 * 
 * @property User $user
 * @property Collection|Message[] $messages
 *
 * @package App\Models
 */
class UserRequest extends Model
{
	protected $connection = 'pgsql';
	protected $table = 'user_request';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_role' => 'int',
		'id_user' => 'int',
		'id_request' => 'int',
		'date_request' => 'datetime',
		'status_review' => 'bool'
	];

	protected $fillable = [
		'type_request',
		'date_request',
		'status_review'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'id_role')
					->where('User.id_role', '=', 'user_request.id_role')
					->where('User.id_user', '=', 'user_request.id_role')
					->where('User.id_role', '=', 'user_request.id_user')
					->where('User.id_user', '=', 'user_request.id_user');
	}

	public function messages()
	{
		return $this->hasMany(Message::class, 'id_request', 'id_request');
	}

}
