<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
	protected $fillable = [
		'judul',
		'pengarang',
		'penerbit',
		'harga',
		'categorie_id',
		'user_id',
	];

	public $timestamps = true;
}
?>