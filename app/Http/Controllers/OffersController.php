<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferStoreRequest;
use App\Models\Offers;
use App\Models\Shops;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OffersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->wantsJson()) {
            return response(
                Offers::all()
            );
        }
        $offers = Offers::latest()->paginate(10);
        return view('offers.index')->with('offers', $offers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shops = Shops::all(); // Fetch all shops
        return view('offers.create', compact('shops')); // Pass shops to the view
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OfferStoreRequest $request)
    {

        $offer = Offers::create([
            'title' => $request->title,
            'description' => $request->description,
            'valid_date' => $request->valid_date,
            'max_users' => $request->max_users,
            'shop_id' => $request->shop_id, // Assign shop_id from the request
        ]);

        if (!$offer) {
            return redirect()->back()->with('error', 'Sorry, Something went wrong while creating customer.');
        }
        return redirect()->route('offers.index')->with('success', 'Success, New Offers has been added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Offer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Offers $offers)
    {
    }
// Offer.php model

public function shop()
{
    return $this->belongsTo(Shops::class);
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Offer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Offers $offer)
    {
        $shops = Shops::all(); // Fetch all shops
        return view('offers.edit', compact('offer', 'shops'));
    }
    
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Offer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offers $offer)
    {
        $offer->title = $request->title;
        $offer->description = $request->description;
        $offer->valid_date = $request->valid_date;
        $offer->max_users = $request->max_users;
        $offer->shop_id = $request->shop_id; // Update shop_id

        if (!$offer->save()) {
            return redirect()->back()->with('error', 'Sorry, Something went wrong while updating the customer.');
        }
        return redirect()->route('offers.index')->with('success', 'Success, The Offers has been updated.');
    }

    public function destroy(Offers $offer)
    {
      
        $offer->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
