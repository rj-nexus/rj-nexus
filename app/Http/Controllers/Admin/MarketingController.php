<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Str;

class MarketingController extends Controller
{
    public function index()
    {
        // Son 50 dərc edilmiş yazını şəkilləri ilə birlikdə çəkirik
        $posts = Post::where('status', 'published')
            ->orderByDesc('created_at')
            ->take(50)
            ->get(['id', 'title', 'content', 'featured_image']);

        // Saytın loqosunu çəkirik
        $siteLogo = rj_get_option('site_logo') ?? rj_get_option('logo');
        
        // Əgər loqo yoxdursa, boş string göndəririk ki, JS-də default 'RJ' yazısı görünsün
        if (empty($siteLogo)) {
            $siteLogo = '';
        }

        return view('admin.tools.marketing', compact('posts', 'siteLogo'));
    }
}