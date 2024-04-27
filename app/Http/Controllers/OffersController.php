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
    public function index(Request $request)
    {
        $query = Offers::query()->with('shop'); // Eager load the shop relationship
    
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%")
                  ->orWhereHas('shop', function ($query) use ($search) {
                      $query->where('name', 'like', "%$search%");
                  });
        }
    
        if ($request->wantsJson()) {
            return response($query->get());
        }
    
        $offers = $query->latest()->paginate(10);
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
        $imagePath = $request->file('image')->store('offers', 'public');

        $offer = Offers::create([
            'title' => $request->title,
            'description' => $request->description,
            'base_price' => $request->base_price,
            'valid_date' => $request->valid_date,
            'max_users' => $request->max_users,
            'shop_id' => $request->shop_id,
            'availablity' => $request->availablity,
            'image' => basename($imagePath),
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
        $offer->base_price = $request->base_price;
        $offer->valid_date = $request->valid_date;
        $offer->max_users = $request->max_users;
        $offer->shop_id = $request->shop_id;
        $offer->availablity = $request->availablity;

        if ($request->hasFile('image')) {
            $newImagePath = $request->file('image')->store('offers', 'public');
            // Delete old image if it exists
            Storage::disk('public')->delete('offers/' . $offer->image);
            $offer->image = basename($newImagePath);
        }

        if (!$offer->save()) {
            return redirect()->back()->with('error', 'Sorry, Something went wrong while updating the customer.');
        }
        return redirect()->route('offers.index')->with('success', 'Success, The Offers has been updated.');
    }

    public function destroy(Offers $offer)
    {
        if (Storage::disk('public')->exists('offers/' . $offer->logo)) {
            Storage::disk('public')->delete('offers/' . $offer->logo);
        }
        $offer->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
