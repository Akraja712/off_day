<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer; 
use App\Models\Shops;
use App\Models\Offers;  

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $phone = $request->input('phone');
        $device_id = $request->input('device_id');

        if (empty($phone) || empty($device_id)) {
            return response()->json([
                'success' => false,
                'message' => 'Phone or device_id is empty.',
            ], 400);
        }

        // Check if a customer with the given mobile number exists in the database
        $customer = Customer::where('phone', $phone)->first();
        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid phone.',
            ], 404);
        }

        // Verify the password (you might want to hash and compare it, this is just for demonstration)
        if ($device_id !== $customer->device_id) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid device_id.',
            ], 401);
        }

        // Image URL
        $imageUrl = asset('storage/app/public/customers/' . $customer->image);

        return response()->json([
            'success' => true,
            'message' => 'Logged in successfully.',
            'data' => [
                'id' => $customer->id,
                'name' => $customer->name,
                'phone' => $customer->phone,
                'device_id' => $customer->device_id,
                'updated_at' => $customer->updated_at,
                'created_at' => $customer->created_at,
                'image_url' => $imageUrl,
            ],
        ], 200);
    }

    public function register(Request $request)
    {
        $phone = $request->input('phone');
        $device_id = $request->input('device_id');
        $name = $request->input('name');
        $image = $request->file('image');

        $errors = [];

        if (empty($phone)) {
            $errors[] = 'Phone is empty.';
        }
        if (empty($device_id)) {
            $errors[] = 'Device ID is empty.';
        }
        if (empty($name)) {
            $errors[] = 'Name is empty.';
        }
        if (empty($image)) {
            $errors[] = 'Image is empty.';
        }

        if (!empty($errors)) {
            return response()->json([
                'success' => false,
                'message' => $errors,
            ], 400);
        }

        // Check if the user with the given phone number already exists
        $existingCustomer = Customer::where('phone', $phone)->first();

        if ($existingCustomer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer already exists with this phone number.',
            ], 409);
        }

        // Store the image and get its path
        $imagePath = $image->store('customers', 'public');

        // Create a new customer record
        $customer = new Customer();
        $customer->phone = $phone;
        $customer->device_id = $device_id;
        $customer->name = $name;
        $customer->image = basename($imagePath);
        $customer->save();

        // Image URL
        $imageUrl = asset('storage/app/public/customers/' . $customer->image);

        return response()->json([
            'success' => true,
            'message' => 'Customer registered successfully.',
            'data' => [
                'id' => $customer->id,
                'name' => $customer->name,
                'phone' => $customer->phone,
                'device_id' => $customer->device_id,
                'updated_at' => $customer->updated_at,
                'created_at' => $customer->created_at,
                'image_url' => $imageUrl,
            ],
        ], 201);
    }
    public function customerdetails(Request $request)
{
    $customer_id = $request->input('customer_id');

    if (empty($customer_id)) {
        return response()->json([
            'success' => false,
            'message' => 'customer_id is empty.',
        ], 400);
    }

    // Fetch the customer details from the database based on the provided customer_id
    $customer = Customer::find($customer_id);

    if (!$customer) {
        return response()->json([
            'success' => false,
            'message' => 'Customer not found.',
        ], 404);
    }

    // Image URL
    $imageUrl = asset('storage/app/public/customers/' . $customer->image);

    return response()->json([
        'success' => true,
        'message' => 'Customer details retrieved successfully.',
        'data' => [
            'id' => $customer->id,
            'name' => $customer->name,
            'phone' => $customer->phone,
            'device_id' => $customer->device_id,
            'updated_at' => $customer->updated_at,
            'created_at' => $customer->created_at,
            'image_url' => $imageUrl,
        ],
    ], 200);
}
public function shoplogin(Request $request)
{
    $phone = $request->input('phone');
    $device_id = $request->input('device_id');

    if (empty($phone) || empty($device_id)) {
        return response()->json([
            'success' => false,
            'message' => 'Phone or device_id is empty.',
        ], 400);
    }

    // Check if a customer with the given mobile number exists in the database
    $shop = Shops::where('phone', $phone)->first();
    if (!$shop) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid phone.',
        ], 404);
    }

    // Verify the password (you might want to hash and compare it, this is just for demonstration)
    if ($device_id !== $shop->device_id) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid device_id.',
        ], 401);
    }

    // Image URL
    $imageUrl = asset('storage/app/public/shops/' . $shop->logo);

    return response()->json([
        'success' => true,
        'message' => 'Logged in successfully.',
        'data' => [
            'id' => $shop->id,
            'owner_name' => $shop->owner_name,
            'shop_name' => $shop->shop_name,
            'phone' => $shop->phone,
            'email' => $shop->email,
            'address' => $shop->address,
            'device_id' => $shop->device_id,
            'updated_at' => $shop->updated_at,
            'created_at' => $shop->created_at,
            'image_url' => $imageUrl,
        ],
    ], 200);
}

public function shopregister(Request $request)
{
    $phone = $request->input('phone');
    $device_id = $request->input('device_id');
    $shop_name = $request->input('shop_name');
    $logo = $request->file('logo');
    $email = $request->input('email');
    $address = $request->input('address');
    $owner_name = $request->input('owner_name');

    $errors = [];

    if (empty($phone)) {
        $errors[] = 'Phone is empty.';
    }
    if (empty($device_id)) {
        $errors[] = 'Device ID is empty.';
    }
    if (empty($shop_name)) {
        $errors[] = 'shop name is empty.';
    }
    if (empty($logo)) {
        $errors[] = 'Logo is empty.';
    }
    if (empty($owner_name)) {
        $errors[] = 'Owner Name is empty.';
    }
    if (empty($email)) {
        $errors[] = 'Email is empty.';
    }
    if (empty($address)) {
        $errors[] = 'Address is empty.';
    }

    if (!empty($errors)) {
        return response()->json([
            'success' => false,
            'message' => $errors,
        ], 400);
    }

    // Check if the user with the given phone number already exists
    $existingShop = Shops::where('phone', $phone)->first();

    if ($existingShop) {
        return response()->json([
            'success' => false,
            'message' => 'Shop already exists with this phone number.',
        ], 409);
    }

    // Store the image and get its path
    $imagePath = $logo->store('shops', 'public');

    // Create a new customer record
    $shop = new Shops();
    $shop->phone = $phone;
    $shop->device_id = $device_id;
    $shop->shop_name = $shop_name;
    $shop->owner_name = $owner_name;
    $shop->address = $address;
    $shop->email = $email;
    $shop->logo = basename($imagePath);
    $shop->save();

    // Image URL
    $imageUrl = asset('storage/app/public/shops/' . $shop->logo);

    return response()->json([
        'success' => true,
        'message' => 'Shops registered successfully.',
        'data' => [
            'id' => $shop->id,
            'owner_name' => $shop->owner_name,
            'shop_name' => $shop->shop_name,
            'phone' => $shop->phone,
            'email' => $shop->email,
            'address' => $shop->address,
            'device_id' => $shop->device_id,
            'updated_at' => $shop->updated_at,
            'created_at' => $shop->created_at,
            'image_url' => $imageUrl,
        ],
    ], 201);
}
public function shopdetails(Request $request)
{
$shop_id = $request->input('shop_id');

if (empty($shop_id)) {
    return response()->json([
        'success' => false,
        'message' => 'shop_id is empty.',
    ], 400);
}

// Fetch the customer details from the database based on the provided customer_id
$shop = Shops::find($shop_id);

if (!$shop) {
    return response()->json([
        'success' => false,
        'message' => 'Shop not found.',
    ], 404);
}

// Image URL
$imageUrl = asset('storage/app/public/shops/' . $shop->logo);

return response()->json([
    'success' => true,
    'message' => 'Shop details retrieved successfully.',
    'data' => [
        'id' => $shop->id,
            'owner_name' => $shop->owner_name,
            'shop_name' => $shop->shop_name,
            'phone' => $shop->phone,
            'email' => $shop->email,
            'address' => $shop->address,
            'device_id' => $shop->device_id,
            'updated_at' => $shop->updated_at,
            'created_at' => $shop->created_at,
            'image_url' => $imageUrl,
    ],
], 200);
}

public function addOffers(Request $request)
{
    $title = $request->input('title');
    $description = $request->input('description');
    $base_price = $request->input('base_price');
    $image = $request->file('image');
    $valid_date = $request->input('valid_date');
    $max_users = $request->input('max_users');
    $availablity = $request->input('availablity');
    $shop_id = $request->input('shop_id'); // Assuming 'shop_id' is passed in the request

    $errors = [];

    if (empty($title)) {
        $errors[] = 'Title is empty.';
    }
    if (empty($description)) {
        $errors[] = 'Description is empty.';
    }
    if (empty($base_price)) {
        $errors[] = 'Base Price is empty.';
    }
    if (empty($image)) {
        $errors[] = 'Image is empty.';
    }
    if (empty($valid_date)) {
        $errors[] = 'Valid Date is empty.';
    }
    if (empty($max_users)) {
        $errors[] = 'Max Users is empty.';
    }
    if (empty($availablity)) {
        $errors[] = 'Availablity is empty.';
    }
    
    // Check if shop_id is valid
    $shop = Shops::find($shop_id);
    if (!$shop) {
        $errors[] = 'Shop not found.';
    }

    if (!empty($errors)) {
        return response()->json([
            'success' => false,
            'message' => $errors,
        ], 400);
    }

    // Store the image and get its path
    $imagePath = $image->store('offers', 'public');

    // Create a new offer record
    $offer = new Offers();
    $offer->title = $title;
    $offer->description = $description;
    $offer->base_price = $base_price;
    $offer->valid_date = $valid_date;
    $offer->max_users = $max_users;
    $offer->availablity = $availablity;
    $offer->image = basename($imagePath);
    $offer->shop_id = $shop_id; // Assign the shop_id
    $offer->save();

    // Image URL
    $imageUrl = asset('storage/app/public/offers/' . $offer->image);

    return response()->json([
        'success' => true,
        'message' => 'Offer added successfully.',
        'data' => [
            'id' => $offer->id,
            'title' => $offer->title,
            'description' => $offer->description,
            'base_price' => $offer->base_price,
            'valid_date' => $offer->valid_date,
            'max_users' => $offer->max_users,
            'availablity' => $offer->availablity,
            'shop_name' => $shop->shop_name,
            'updated_at' => $offer->updated_at,
            'created_at' => $offer->created_at,
            'image_url' => $imageUrl,
        ],
    ], 201);
}

public function editoffers(Request $request)
{
    $offer_id = $request->input('offer_id');

    if (empty($offer_id)) {
        return response()->json([
            'success' => false,
            'message' => 'offer_id is empty.',
        ], 400);
    }
    $offer = Offers::find($offer_id);

    if (!$offer) {
        return response()->json([
            'success' => false,
            'message' => 'Offer not found.',
        ], 404);
    }

    $title = $request->input('title');
    $description = $request->input('description');
    $base_price = $request->input('base_price');
    $image = $request->file('image');
    $valid_date = $request->input('valid_date');
    $max_users = $request->input('max_users');
    $availablity = $request->input('availablity');
    $shop_id = $request->input('shop_id');

    // Update offer details
    if ($title !== null) {
        $offer->title = $title;
    }
    if ($description !== null) {
        $offer->description = $description;
    }
    if ($base_price !== null) {
        $offer->base_price = $base_price;
    }
    if ($image !== null) {
        $imagePath = $image->store('offers', 'public');
        $offer->image = basename($imagePath);
    }
    if ($valid_date !== null) {
        $offer->valid_date = $valid_date;
    }
    if ($max_users !== null) {
        $offer->max_users = $max_users;
    }
    if ($availablity !== null) {
        $offer->availablity = $availablity;
    }
    if ($shop_id !== null) {
        // Check if shop_id is valid
        $shop = Shops::find($shop_id);
        if (!$shop) {
            return response()->json([
                'success' => false,
                'message' => 'Shop not found.',
            ], 404);
        }
        $offer->shop_id = $shop_id;
    }

    // Retrieve the associated shop details
    $shop = Shops::find($offer->shop_id);

    // Save the updated offer
    $offer->save();

    // Image URL
    $imageUrl = asset('storage/app/public/offers/' . $offer->image);

    return response()->json([
        'success' => true,
        'message' => 'Offer updated successfully.',
        'data' => [
            'id' => $offer->id,
            'title' => $offer->title,
            'description' => $offer->description,
            'base_price' => $offer->base_price,
            'valid_date' => $offer->valid_date,
            'datetime' => $offer->datetime,
            'max_users' => $offer->max_users,
            'availablity' => $offer->availablity,
            'shop_name' => $shop->shop_name,
            'updated_at' => $offer->updated_at,
            'created_at' => $offer->created_at,
            'image_url' => $imageUrl,
        ],
    ], 200);
}
public function offerdetails(Request $request)
{
$offer_id = $request->input('offer_id');

if (empty($offer_id)) {
    return response()->json([
        'success' => false,
        'message' => 'offer_id is empty.',
    ], 400);
}

// Fetch the customer details from the database based on the provided customer_id
$offer = Offers::find($offer_id);

if (!$offer) {
    return response()->json([
        'success' => false,
        'message' => 'Offer not found.',
    ], 404);
}


    // Retrieve the associated shop details
    $shop = Shops::find($offer->shop_id);

// Image URL
$imageUrl = asset('storage/app/public/offers/' . $offer->image);

return response()->json([
    'success' => true,
    'message' => 'Offers details retrieved successfully.',
    'data' => [
        'id' => $offer->id,
        'title' => $offer->title,
        'description' => $offer->description,
        'base_price' => $offer->base_price,
        'valid_date' => $offer->valid_date,
        'datetime' => $offer->datetime,
        'max_users' => $offer->max_users,
        'availablity' => $offer->availablity,
        'shop_name' => $shop->shop_name,
        'updated_at' => $offer->updated_at,
        'created_at' => $offer->created_at,
        'image_url' => $imageUrl,
    ],
], 200);
}

}
