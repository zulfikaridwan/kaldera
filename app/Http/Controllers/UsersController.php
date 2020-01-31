<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index()
    {
        $user = User::with('book')->Where(["id" => Auth::user()->id])->OrderBy("id", 'DESC')->paginate(2);
        $outPut = [
            "message" => "transactions", "results" => $user
        ];
        return response()->json($user, 200);
    }
}