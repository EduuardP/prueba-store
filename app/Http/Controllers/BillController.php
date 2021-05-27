<?php

namespace App\Http\Controllers;

use App\Http\Requests\BillStoreRequest;
use App\Models\Bill as Bill;
use App\Models\Product;
use Illuminate\Http\Request;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $bills = Bill::with('products')->get();
        return response($bills,200);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response("",405);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BillStoreRequest $request)
    {
        $data = $request->validated();
        $products = $data['products'];
        $result = $this->generateTotalIva($products);
        if(array_key_exists("error",$result))
        {
            return response($result["error"],400);
        }
       $bill = Bill::create( [
            'client'=> $data['client'],
            'phone'=> $data['phone'],
            'email'=> $data['email'],
            'subtotal'=> $result["subtotal"],
            'IVA'=>  $result["iva"],
            'total'=> $result["total"]
            ]); 
        $bill->products()->attach($products);
        
        return $bill;
    }

    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function show(bill $bill)
    {
        //
        return response("",405);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function edit(bill $bill)
    {
        //
        return response("",405);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, bill $bill)
    {
        //
        return response("",405);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $bill = Bill::find($id);
        if ($bill){
            $bill->delete();
            return response("Factura eliminada con exito",200);
        }else{
            return response("No existe ninguna factura con el id mencionado",400);
        }
    }


    protected function generateTotalIva($productos){
        $subtotal = 0;
        $iva = 0;
        $total = 0;
        $result = [];
        foreach ($productos as $item){
           
          $product = Product::find($item['product_id']);
          if($product){
             $total += ($product->price)* intval($item['quantity']);
             $iva += ($product->price * intval($product->iva)/100) * intval($item['quantity']);
             
            
          }else{
            $result["error"] = "El producto con id: ". $item['product_id']. " no existe";
              return $result;
 
          }
          
         }

         $subtotal = ($total-$iva);
         $result["total"] = $total;
         $result["iva"] = $iva;
         $result["subtotal"] = $subtotal;
         return $result;


    }
}
