<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Purchase;

use Carbon\Carbon;

class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    private function _fetchTotal($start, $end)
    {
        return Auth::user()->purchases()
                ->whereBetween('date', [$start, $end])
                ->pluck('price')
                ->sum();
    }
    
    public function home()
    {
        // Create report data array
        $reports = [];
        
        // Get today total
        $start = Carbon::today()->toDateTimeString();
        $end = Carbon::today()->setTime(23,59,59)->toDateTimeString();
        $today = $this->_fetchTotal($start, $end);
        $reports['today'] = $today;
        
        // Get yesterday total
        $start = Carbon::yesterday()->toDateTimeString();
        $end = Carbon::yesterday()->setTime(23,59,59)->toDateTimeString();
        $yesterday = $this->_fetchTotal($start, $end);
        $reports['yesterday'] = $yesterday;
        
        // Get last seven days (including today)
        $start = Carbon::today()->subDays(6)->toDateTimeString();
        $end = Carbon::today()->setTime(23,59,59)->toDateTimeString();
        $last7days = $this->_fetchTotal($start, $end);
        $reports['last7days'] = $last7days;
        
        // Get last 30 days (including today)
        $start = Carbon::today()->subDays(29)->toDateTimeString();
        $end = Carbon::today()->setTime(23,59,59)->toDateTimeString();
        $last30days = $this->_fetchTotal($start, $end);
        $reports['last30days'] = $last30days;
        
        // Return view with reports data
        return view('home', $reports);
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
            $purchase = Auth::user()
                    ->purchases()
                    ->find($request->id); 
        } else {
            // Instantiate new Purchase model
            $purchase = new Purchase;
        }
        
        // Make sure purchase isn't null
        if ($purchase == null) {
            // Set error message
            return back()->withErrors(['msg' => 'Problem updating purchase']);
        }
        
        // Apply validated data to model
        $purchase->user_id = Auth::id();
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
        $purchases = Auth::user()
                ->purchases()
                ->orderBy('date', 'desc')
                ->paginate(10);
        
        // Load the view
        return view('browse', compact('purchases'));
    }
    
    public function update($id)
    {
        // Try to find the purchase in the database
        $purchase = Auth::user()
                ->purchases()
                ->findOrFail($id);
        
        return view('update', compact('purchase'));
    }
    
    public function delete(Request $request)
    {
        // Check if the request has an id parameter
        if ($request->has('id')) {
            // Try to find the purchase
            $purchase = Auth::user()->purchases()->find($request->id);
            // Make sure you found it
            if ($purchase != null) {
                // Delete Purchase
                $purchase->delete();
                $destroyed = 1;
            } else {
                $destroyed = 0;
            }
        } else {
            $destroyed = 0;
        }
        
        if ($destroyed == 1) {
            // Set status message
            $request->session()->flash('status', 'Purchase deleted');
            return back();
        } else {
            // Set error message
            return back()->withErrors(['msg' => 'Problem deleting purchase']);
        }         
    }
}
