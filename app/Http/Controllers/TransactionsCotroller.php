<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TransactionsCotroller extends Controller
{
    public function index()
    {
        $transaction = Transaction::Where(["user_id_pembeli" => Auth::user()->id])->OrderBy("id", 'DESC')->paginate(2);
        $outPut = [
            "message" => "transactions", "results" => $transaction
        ];
        return response()->json($transaction, 200);
    }

    public function store(Request $request)
    {
        if(Gate::denies('create-transaction')){
            return response()->json([
                'succes' => false,
                'status' => 403,
                'message' => 'You Are unauthorized'
            ], 403);
        }

        $input = $request->all();
        $validationRules = [
            'tgl_faktur'=> 'required|date',
            'book_id'=> 'required|exists:books,id',
            'user_id_pembeli'=> 'required|exists:users,id',
            'user_id_penjual'=> 'required|exists:users,id',
            'total'=> 'required'
		];
		$validator = \Validator::make($input, $validationRules);
		if($validator->fails()){
			return response()->json($validator->errors(), 400);
        }

        $input = $request->all();
		$transaction = Transaction::create($input);

		return response()->json($transaction, 200);
    }

    public function show($id)
	{
        if(Gate::denies('detail-transaction')){
            return response()->json([
                'succes' => false,
                'status' => 403,
                'message' => 'You Are unauthorized'
            ], 403);
        }

        $transaction = Transaction::with('book')->find($id);

		if(!$transaction){
			abort(404);
		}

		return response()->json($transaction, 200);
    }
}
?>
