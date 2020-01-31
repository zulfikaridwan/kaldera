<?php
namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class CategoriesController extends Controller
{
    public function index()
	{
        if(Gate::denies('read-categorie')){
            return response()->json([
                'succes' => false,
                'status' => 403,
                'message' => 'You Are unauthorized'
            ], 403);
        }

        $categorie = Categorie::OrderBy("id", "DESC")->paginate(2);
        $outPut = [
            "message" => "categories", "results" => $categorie
        ];

		return response()->json($categorie, 200);
    }

    public function store(Request $request)
    {
        if(Gate::denies('create-categorie')){
            return response()->json([
                'succes' => false,
                'status' => 403,
                'message' => 'You Are unauthorized'
            ], 403);
        }

        $input = $request->all();
		$categorie = Categorie::create($input);

		return response()->json($categorie, 200);
    }

    public function show($id)
    {
        if(Gate::denies('detail-categorie')){
            return response()->json([
                'succes' => false,
                'status' => 403,
                'message' => 'You Are unauthorized'
            ], 403);
        }

        $categorie = Categorie::with('book')->find($id);
        if(!$categorie){
            abort(404);
        }

        return response()->json($categorie, 200);
    }

    public function update(Request $request, $id)
    {
        if(Gate::denies('update-categorie')){
            return response()->json([
                'succes' => false,
                'status' => 403,
                'message' => 'You Are unauthorized'
            ], 403);
        }

        $input = $request->all();
        $categorie = Categorie::find($id);
        if(!$categorie){
            abort(404);
        }

        $categorie->fill($input);
        $categorie->save();

        return response()->json($categorie, 200);
    }

    public function destroy($id)
    {
        if(Gate::denies('delete-categorie')){
            return response()->json([
                'succes' => false,
                'status' => 403,
                'message' => 'You Are unauthorized'
            ], 403);
        }

        $categorie = Categorie::find($id);
        if(!$categorie){
            abort(404);
        }

        $categorie->delete();
        $message = ['message' => 'deleted succesfully', 'categorie_id' => $id];

        return response()->json($message, 200);
    }
}
?>