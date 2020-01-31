<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class BooksController extends Controller
{
    public function index(Request $request)
	{
        $acceptHeader = $request->header('Accept');

        if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml')
		{
            if(Gate::denies('read-book')){
                return response()->json([
                    'succes' => false,
                    'status' => 403,
                    'message' => 'You Are unauthorized'
                ], 403);
            }

            $book = Book::OrderBy("id", "DESC")->paginate(2)->toArray();
            $response =[
				"total_count" => $book["total"],
				"limit" => $book["per_page"],
				"pagination" => [
					"nex_page" => $book["next_page_url"],
					"current_page" => $book["current_page"]
				],
				"data" => $book["data"],
			];
        
            if($acceptHeader === 'application/json')
			{
                return response()->json($response, 200);
			} else {
                    $xml = new \SimpleXMLElement('<books/>');

                    foreach ($book->items('data') as $item)
                    {
                        $xmlItem = $xml->addChild('book');

                        $xmlItem->addChild('id', $item->id);
                        $xmlItem->addChild('judul', $item->judul);
                        $xmlItem->addChild('pengarang', $item->pengarang);
                        $xmlItem->addChild('penerbit', $item->penerbit);
                        $xmlItem->addChild('harga', $item->harga);
                        $xmlItem->addChild('categorie_id', $item->categorie_id);
                        $xmlItem->addChild('user_id', $item->user_id);
                        $xmlItem->addChild('created_at', $item->created_at);
                        $xmlItem->addChild('updated_at', $item->updated_at);
                    }
                    return $xml->asXML();	
			    }
			}else{
				return response('Not Acceptable', 406);
        }
    }

    public function store(Request $request)
    {
        $acceptHeader = $request->header('Accept');

        if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml')
        {
            if(Gate::denies('create-book')){
                return response()->json([
                    'succes' => false,
                    'status' => 403,
                    'message' => 'You Are unauthorized'
                ], 403);
            }

            $input = $request->all();
            $validationRules = [
            'judul'=> 'required',
            'pengarang' => 'required|min:5',
            'penerbit' => 'required|min:5',
            'harga' => 'required|integer',
            'categorie_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id'
            ];
            $validator = \Validator::make($input, $validationRules);
            if($validator->fails()){
                return response()->json($validator->errors(), 400);
            }
            $book = Book::create($input);

            if($acceptHeader === 'application/json')
			{
				return response()->json($book, 200);
			} else {
                $xml = new \SimpleXMLElement('<books/>');

                    $xmlItem = $xml->addChild('book');

                    $xmlItem->addChild('id', $book->id);
                    $xmlItem->addChild('judul', $book->judul);
                    $xmlItem->addChild('pengarang', $book->pengarang);
                    $xmlItem->addChild('penerbit', $book->penerbit);
                    $xmlItem->addChild('harga', $book->harga);
                    $xmlItem->addChild('categorie_id', $book->categorie_id);
                    $xmlItem->addChild('user_id', $book->user_id);
                    $xmlItem->addChild('created_at', $book->created_at);
                    $xmlItem->addChild('updated_at', $book->updated_at);
                    
                    return $xml->asXML();	
			}
        }else{
            return response('Not Acceptable', 406);
        }
    }

    public function show(Request $request, $id)
    {
        $acceptHeader = $request->header('Accept');

        if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml')
        {
            if(Gate::denies('detail-book')){
                return response()->json([
                    'succes' => false,
                    'status' => 403,
                    'message' => 'You Are unauthorized'
                ], 403);
            }

            $book = Book::find($id);
            if(!$book){
                abort(404);
            }

            if($acceptHeader === 'application/json')
			{
				return response()->json($book, 200);
			} else {
                $xml = new \SimpleXMLElement('<books/>');

                    $xmlItem = $xml->addChild('book');

                    $xmlItem->addChild('id', $book->id);
                    $xmlItem->addChild('judul', $book->judul);
                    $xmlItem->addChild('pengarang', $book->pengarang);
                    $xmlItem->addChild('penerbit', $book->penerbit);
                    $xmlItem->addChild('harga', $book->harga);
                    $xmlItem->addChild('categorie_id', $book->categorie_id);
                    $xmlItem->addChild('user_id', $book->user_id);
                    $xmlItem->addChild('created_at', $book->created_at);
                    $xmlItem->addChild('updated_at', $book->updated_at);
                    
                    return $xml->asXML();	
			}
        }else{
            return response('Not Acceptable', 406);
        }
    }

    public function update(Request $request, $id)
    {
        $acceptHeader = $request->header('Accept');

        if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml')
        {
            if(Gate::denies('update-book')){
                return response()->json([
                    'succes' => false,
                    'status' => 403,
                    'message' => 'You Are unauthorized'
                ], 403);
            }

            $input = $request->all();
            $book = Book::find($id);
            if(!$book){
                abort(404);
            }

            $validationRules = [
            'judul'=> 'required',
            'pengarang' => 'required|min:5',
            'penerbit' => 'required|min:5',
            'harga' => 'required|integer',
            'categorie_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id'
            ];
            $validator = \Validator::make($input, $validationRules);
            if($validator->fails()){
                return response()->json($validator->errors(), 400);
            }

            $book->fill($input);
            $book->save();

            if($acceptHeader === 'application/json')
			{
				return response()->json($book, 200);
			} else {
                $xml = new \SimpleXMLElement('<books/>');

                    $xmlItem = $xml->addChild('book');

                    $xmlItem->addChild('id', $book->id);
                    $xmlItem->addChild('judul', $book->judul);
                    $xmlItem->addChild('pengarang', $book->pengarang);
                    $xmlItem->addChild('penerbit', $book->penerbit);
                    $xmlItem->addChild('harga', $book->harga);
                    $xmlItem->addChild('categorie_id', $book->categorie_id);
                    $xmlItem->addChild('user_id', $book->user_id);
                    $xmlItem->addChild('created_at', $book->created_at);
                    $xmlItem->addChild('updated_at', $book->updated_at);
                    
                    return $xml->asXML();	
			}
        }else{
            return response('Not Acceptable', 406);
        }
    }

    public function destroy(Request $request, $id)
    {
        $acceptHeader = $request->header('Accept');

		if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml')
		{
            if(Gate::denies('delete-book')){
                return response()->json([
                    'succes' => false,
                    'status' => 403,
                    'message' => 'You Are unauthorized'
                ], 403);
            }

			$book = Book::find($id);
            if(!$book){
                abort(404);
            }
			$book->delete();

			if($acceptHeader === 'application/json')
			{
				$message = ['message' => 'deleted succesfully', 'book_id' => $id];
                return response()->json($message, 200);
			} else {
				$xml = new \SimpleXMLElement('<Books/>');
				$xmlItem = $xml->addChild('book');

				$xmlItem->addChild('id', $book->id);
				$xmlItem->addChild('message' , 'deleted succesfully');

				return $xml->asXML();
			}

		}else{
				return response('Not Acceptable', 406);
			}
    }

    public function myBook($userId)
    {
        if(Gate::denies('my-book')){
            return response()->json([
                'succes' => false,
                'status' => 403,
                'message' => 'You Are unauthorized'
            ], 403);
        }
        
        $user = Book::Where(["user_id" => Auth::user()->id])->OrderBy("id", 'DESC')->paginate(2);
        $outPut = [
            "message" => "transactions", "results" => $user
        ];
        return response()->json($user, 200);
    }
}