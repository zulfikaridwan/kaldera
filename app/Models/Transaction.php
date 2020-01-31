<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	protected $fillable = [
		'tgl_faktur', 'book_id', 'user_id_penjual', 'user_id_pembeli', 'total',
	];

    public $timestamps = true;
    
    public function book()
    {
        return $this->belongsTo('App\Models\Book');
    }
}
?>