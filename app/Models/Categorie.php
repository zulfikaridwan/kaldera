<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
	protected $fillable = [
		'nama',
	];

	public $timestamps = true;

	public function book()
	{
		return $this->hasMany('App\Models\Book');
	}
}
?>