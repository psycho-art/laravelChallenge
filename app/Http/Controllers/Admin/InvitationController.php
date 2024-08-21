<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Log;

class InvitationController extends Controller
{
    public function index()
    {
        $title = "Invitations";

        try {
            $invitations = Invitation::cursorPaginate(10);
        } catch (Exception $e) {
            Log::error('Failed to load invitations: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load invitations.');
        }

        return view('admin.invitations.index', compact('invitations', 'title'));
    }

    public function create() {
        $title = "Create Invitation";

        return view('admin.invitations.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:invitations,email',
        ]);

        try {
            $invitation = Invitation::create([
                'email' => $request->email,
                'token' => Str::random(32),
                'expires_at' => now()->addDays(7),
                'invited_by' => Auth::id(),
            ]);

            // Log the token for debugging
            logger()->info('Invite Token: ' . $invitation->token);

            return redirect()->route('admin.invitations.index')->with('success', 'Invitation created successfully!');
        } catch (Exception $e) {
            Log::error('Failed to create invitation: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create invitation. Please try again.');
        }
    }

    public function resend(Invitation $invitation)
    {
        try {
            $invitation->update([
                'expires_at' => now()->addDays(7)
            ]);

            return redirect()->route('admin.invitations.index')->with('success', 'Invitation resent successfully!');
        } catch (Exception $e) {
            Log::error('Failed to resend invitation: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to resend invitation. Please try again.');
        }
    }
}
