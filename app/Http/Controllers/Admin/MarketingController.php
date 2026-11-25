<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Str;

class MarketingController extends Controller
{
    public function index()
    {
        // YALNIZ POSTLARI ÇƏKİRİK (Səhifələr yox)
        $posts = Post::where('type', 'post') // Əgər sütun adı fərqlidirsə, buraya diqqət edin
            ->where('status', 'published')
            ->orderByDesc('created_at')
            ->take(50)
            ->get(['id', 'title', 'content', 'featured_image']);

        $siteLogo = rj_get_option('site_logo') ?? rj_get_option('logo');
        if (empty($siteLogo)) { $siteLogo = ''; }

        return view('admin.tools.marketing', compact('posts', 'siteLogo'));
    }
}