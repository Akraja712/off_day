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
        $password = $request->input('password');

        if (empty($phone) || empty($password)) {
            return response()->json([
                'success' => false,
                'message' => 'phone or password is empty.',
            ], 200);
        }

        // Check if a customer with the given mobile number exists in the database
        $customer = Customer::where('phone', $phone)->first();
        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid phone.',
            ], 200);
        }

        // Verify the password (without hashing)
        if ($password !== $customer->password) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid password.',
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Logged in successfully.',
            'image' => asset('storage/app/public/customers/' . $customer->image), // Corrected variable name
            'data' => $customer,
        ], 201);
    }
}
