<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
	protected $fillable = array('nama_belakang', 'user_id', 'alamat', 'nomor_hp', 'image');

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
?>