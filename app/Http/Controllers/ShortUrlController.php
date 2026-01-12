<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortUrl;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{
    public function redirect($code)
    {
        $shortUrl = ShortUrl::where('code', $code)->firstOrFail();
        $shortUrl->increment('visits');
        return redirect($shortUrl->original_url);
    }

    public function index()
    {
        return view('short_urls.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url',
        ]);

        $code = Str::random(6);
        while (ShortUrl::where('code', $code)->exists()) {
            $code = Str::random(6);
        }

        $shortUrl = ShortUrl::create([
            'user_id' => Auth::id(),
            'original_url' => $request->original_url,
            'code' => $code,
            'title' => $request->input('title'),
        ]);

        return redirect()->route('dashboard')->with('success', 'สร้างลิงก์สั้นสำเร็จ: ' . url('/s/' . $shortUrl->code));
    }
}
