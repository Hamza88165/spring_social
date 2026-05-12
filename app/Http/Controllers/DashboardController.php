<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Post;
use App\Models\Message;
use App\Models\SocialAccount;

class DashboardController extends Controller
{
    public function index()
    {
        $totalClients        = Client::count();
        $totalAccounts       = SocialAccount::count();
        $scheduledToday      = Post::where('status', 'scheduled')
                                   ->whereDate('scheduled_at', today())
                                   ->count();
        $unreadMessages      = Message::where('is_read', false)->count();
        $recentClients       = Client::latest()->take(5)->get();

        return view('dashboard', compact(
            'totalClients',
            'totalAccounts',
            'scheduledToday',
            'unreadMessages',
            'recentClients'
        ));
    }
}