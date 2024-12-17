<?php

namespace App\Http\Controllers;

use App\Models\Product;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //El metodo va adevolver todos los productos
        $products = Product::all();

        return Response()->json([
            'message'=>'La lista de los productos existentes',
            'content'=>$products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    //funcion para crear un producto
    public function create(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'name'=>'required|string',
            'description'=>'required|string',
            'price'=>'required'
        ]);

        if($validator->fails()){
            return Response()->json([
                'message'=>'Los datos no estan correctos',
                'error'=>$validator->errors()
            ]);
        }
        $product = Product::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'price'=>$request->price
        ]);
        return Response()->json([
            'message'=>'el producto fue creado',
            'result'=>$product
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $product = Product::find($id);
        if(!$product){
            return Response()->json([
                'message'=>'Producto no encontrado',
                'status'=>201
            ]);
        }else{
            return Response()->json([
                'message'=>'pruducto encontrado',
                'respuesta'=>$product
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function delete($id)
    {
        //
        $product = Product::find($id);

        if (!$product) {
            $data = [
                'message' => 'Producto no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        
        $product->delete();

        $data = [
            'message' => 'Producto eliminado',
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $product = Product::find($id);

        if (!$product) {
            $data = [
                'message' => 'Producto no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name'=>'required|string',
            'description'=>'required|string',
            'price'=>'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;

        $product->save();

        $data = [
            'message' => 'Producto actualizado',
            'student' => $product,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
