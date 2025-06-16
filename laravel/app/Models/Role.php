<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * 
 * @property int $id_role
 * @property string|null $name_role
 * @property string|null $desc_access
 * 
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Role extends Model
{
	protected $connection = 'pgsql';
	protected $table = 'role';
	protected $primaryKey = 'id_role';
	public $timestamps = false;

	protected $fillable = [
		'name_role',
		'desc_access'
	];

	public function users()
	{
		return $this->hasMany(User::class, 'id_role');
	}
}
