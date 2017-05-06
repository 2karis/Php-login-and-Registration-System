<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User Extends Model{

	protected $table = "users";

	protected $fillable = [
		'username',
		'email',
		'password'
	];

}
?>