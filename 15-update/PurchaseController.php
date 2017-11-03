<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Purchase;

class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function create()
    {
        return view('create');
    }
    
    public function store(Request $request)
    {
        // Validate the data
        $request->validate([
            'date' => 'required|date',
            'price' => 'required|numeric|min:0.01|max:99999999999.99',
            'description' => 'required|max:191'
        ]);
        
        // Check if request has id
        if ($request->has('id')) {
            // Find the Purchase
            $purchase = Purchase::find($request->id);
        } else {
            // Instantiate new Purchase model
            $purchase = new Purchase;
        }
        
        // Apply validated data to model
        $purchase->date = $request->date;
        $purchase->price = $request->price;
        $purchase->description = $request->description;
        
        // Save the model
        $purchase->save();
        
        // Set status message and redirect back to the form
        $request->session()->flash('status', 'Purchase saved');
        return back();     
    }
    
    public function browse()
    {
        // Load purchases
        $purchases = Purchase::orderBy('date', 'desc')->paginate(10);
        
        // Load the view
        return view('browse', compact('purchases'));
    }
    
    public function update($id)
    {
        // Try to find the purchase in the database
        $purchase = Purchase::findOrFail($id);
        return view('update', compact('purchase'));
    }
}
