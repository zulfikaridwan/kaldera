<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
	{
		$this->validate($request, [
			'nama' => 'required|min:5',
			'email' => 'required|email|unique:users',
			'password' => 'required|confirmed',
			'role' => 'required|in:pembeli,penjual',
		]);
		$input = $request->all();
		//validation
		$validationRules = [
			'nama' => 'required|string',
			'email' => 'required|email|unique:users',
			'password' => 'required|confirmed',
			'role' => 'required|in:pembeli,penjual',
		];

		$validator = \Validator::make($input, $validationRules);
		if($validator->fails()){
			return response()->json($validator->errors(), 400);
		}
		//validation end

		//create user
		$user = new User;
		$user->nama = $request->input('nama');
		$user->email = $request->input('email');
		$plainPassword = $request->input('password');
		$user->password = app('hash')->make($plainPassword);
		$user->role = $request->input('role');
		$user->save();
		return response()->json($user, 200);

    }
    
    public function login(Request $request)
	{
		$input = $request->all();

		//validation
		$validationRules = [
			'email' => 'required|string',
			'password' => 'required|string',
		];

		$validator = \Validator::make($input, $validationRules);
		if($validator->fails()){
			return response()->json($validator->errors(), 400);
		}

		//procces login
		$credentials = $request->only(['email', 'password']);
		if(! $token = Auth::attempt($credentials)){
			return response()->json(['message' => 'Unaunthorized'], 401);
		}

		return response()->json([
			'token' => $token,
			'token_type' => 'bearer',
			'expires_in' => Auth::factory()->getTTL() * 60
		], 200);
	}
}
?>