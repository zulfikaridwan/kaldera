<?php
namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilesController extends Controller
{
    public function store(Request $request)
	{
		$input = $request->all();

		$validationRules = [
			'nama_belakang'=> 'required|min:2',
            'alamat' => 'required|min:10',
            'nomor_hp' => 'required|min:10'
		];

		$validator = \Validator::make($input, $validationRules);
		if($validator->fails()){
			return response()->json($validator->errors(), 400);
		}

		$profile = Profile::where('user_id', Auth::user()->id)->first();

		if(!$profile){
			$profile = new Profile;
			$profile->user_id = Auth::user()->id;
		}

		$profile->nama_belakang = $request->input('nama_belakang');
		$profile->alamat = $request->input('alamat');
		$profile->nomor_hp = $request->input('nomor_hp');

		//jika ada image yang di upload
		if($request->hasFile('gambar')){
            $nama_belakang = str_replace(' ', '_', $request->input('nama_belakang'));

            $imagName = Auth::user()->id . '_' . $nama_belakang;
            $request->file('gambar')->move(storage_path('uploads/image_user'), $imagName);

            $current_image_path = storage_path('avatar') . '/' . $profile->gambar;
            if(file_exists($current_image_path)){
                unlink($current_image_path);
            }

            $profile->gambar = $imagName;
        }

		//save image
		$profile->save();

		return response()->json($profile, 200);
    }
    
    public function show($userId)
	{
        $profile = Profile::with('user')->where('user_id', $userId)->first();

		if(!$profile){
			abort(404);
		}

		return response()->json($profile, 200);
    }
    
    public function image($imageName)
	{
		$imagePath = storage_path('uploads/image_user') . '/' . $imageName;
		if(file_exists($imagePath)){
			$file = file_get_contents($imagePath);
			return response($file, 200)->header('Content-Type', 'image/jpeg');
		}

		return response()->json(array(
			"message" => "image not found"
		), 401);
	}
}
?>