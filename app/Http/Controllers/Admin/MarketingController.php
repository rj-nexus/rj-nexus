<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MarketingController extends Controller
{
    public function index()
    {
        // Postları şəkilləri ilə birlikdə çəkirik
        $posts = Post::where('status', 'published')
            ->orderByDesc('created_at')
            ->take(50)
            ->get(['id', 'title', 'content', 'featured_image']);

        $siteLogo = rj_get_option('site_logo') ?? rj_get_option('logo');
        if (empty($siteLogo)) { $siteLogo = ''; }

        return view('admin.tools.marketing', compact('posts', 'siteLogo'));
    }
}