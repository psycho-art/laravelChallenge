<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FrontendController extends Controller
{
    public function index(Request $request)
    {

        $title = "Users";

        // Fetch users from the API otherwise get from session
        if(!session('users')) {
            $response = Http::get('https://randomuser.me/api/', [
                'results' => 50,
            ]);

            $users = $response->json()['results'];

            // Store users in session
            session(['users' => $users]);

        } else {
            $users = session('users');
        }

        return view('home', compact('users', 'title'));
    }

    public function show(Request $request, $id)
    {
        // Get the users from the session
        $users = session('users', []);

        // Find the user by UUID
        $user = collect($users)->firstWhere('login.uuid', $id);

        if (!$user) {
            abort(404, 'User not found');
        }

        // Safely access the name and it's keys using the optional helper
        $firstName = optional($user['name'])['first'] ?? 'Unknown';
        $lastName = optional($user['name'])['last'] ?? 'Unknown';
        $title = $firstName . ' ' . $lastName;

        return view('profile', compact('user', 'title'));
    }
}
