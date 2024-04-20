<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer; 

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
}
