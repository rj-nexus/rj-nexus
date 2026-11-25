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
        // Son 50 dərc edilmiş yazını çəkirik
        $posts = Post::where('status', 'published')
            ->orderByDesc('created_at')
            ->take(50)
            ->get(['id', 'title', 'content']);

        // Saytın loqosunu çəkirik (RJ Nexus-da adətən belə saxlanılır)
        $siteLogo = rj_get_option('site_logo') ?? rj_get_option('logo');
        
        // Əgər loqo yoxdursa, default bir SVG istifadə edə bilərik
        if (empty($siteLogo)) {
            $siteLogo = 'https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/banner.svg'; // Nümunə
        }

        return view('admin.tools.marketing', compact('posts', 'siteLogo'));
    }
}