<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopsStoreRequest;
use App\Models\Shops;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShopsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Shops::query();
    
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('owner_name', 'like', "%$search%")
                  ->orWhere('shop_name', 'like', "%$search%");
        }
    
        if ($request->wantsJson()) {
            return response($query->get());
        }
    
        $shops = $query->latest()->paginate(10);
        return view('shops.index')->with('shops', $shops);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('shops.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShopsStoreRequest $request)
    {
        $imagePath = $request->file('logo')->store('shops', 'public');

        $shop = Shops::create([
            'owner_name' => $request->owner_name,
            'shop_name' => $request->shop_name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'logo' => basename($imagePath),
        ]);

        if (!$shop) {
            return redirect()->back()->with('error', 'Sorry, Something went wrong while creating shop.');
        }
        return redirect()->route('shops.index')->with('success', 'Success, New Shop has been added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shops  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Shops $shop)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shops  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Shops $shop)
    {
        return view('shops.edit', compact('shop'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shops  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shops $shop)
    {
        $shop->shop_name = $request->shop_name;
        $shop->owner_name= $request->owner_name;
        $shop->email = $request->email;
        $shop->phone = $request->phone;
        $shop->address = $request->address;
        $shop->device_id = $request->device_id;

        if ($request->hasFile('logo')) {
            $newImagePath = $request->file('logo')->store('shops', 'public');
            // Delete old image if it exists
            Storage::disk('public')->delete('shops/' . $shop->logo);
            $shop->logo = basename($newImagePath);
        }

        if (!$shop->save()) {
            return redirect()->back()->with('error', 'Sorry, Something went wrong while updating the customer.');
        }
        return redirect()->route('shops.index')->with('success', 'Success, The customer has been updated.');
    }

    public function destroy(Shops $shop)
    {
        if (Storage::disk('public')->exists('shops/' . $shop->logo)) {
            Storage::disk('public')->delete('shops/' . $shop->logo);
        }
        $shop->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
