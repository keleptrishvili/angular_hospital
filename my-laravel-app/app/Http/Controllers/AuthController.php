<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; // Import File Facade

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        // Data to be saved in the JSON file
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // You should hash the password before saving
        ];

        // Define the path to the JSON file
        $jsonFilePath = storage_path('app/users.json');

        // Check if the file exists
        if (File::exists($jsonFilePath)) {
            // Get existing data
            $existingData = json_decode(File::get($jsonFilePath), true);
        } else {
            // Create an empty array if no file exists
            $existingData = [];
        }

        // Append the new user data to the existing data
        $existingData[] = $userData;

        // Save the updated data back to the JSON file
        try {
            File::put($jsonFilePath, json_encode($existingData, JSON_PRETTY_PRINT));
        } catch (\Exception $e) {
            // Handle the error if file writing fails
            return response()->json(['message' => 'Error saving data: ' . $e->getMessage()], 500);
        }

        return response()->json(['message' => 'Registration successful!']);
    }
}

