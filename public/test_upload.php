<?php
require '../vendor/autoload.php';

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;

// Simulate authentication
Auth::loginUsingId(1); // Assuming user ID 1 exists

// Create a mock request with an uploaded file
$request = new Request();
$request->files->set('profile_picture', new \Illuminate\Http\UploadedFile('public/images/test_profile_picture.jpg', 'test_profile_picture.jpg'));
$request->merge([
    'name' => 'Test User',
    'email' => 'testuser@example.com',
    'contact_no' => '1234567890',
    'address' => '123 Test St',
]);

// Call the update method
$controller = new ProfileController();
$response = $controller->update($request);

// Output the response
echo $response->getContent();
?>
