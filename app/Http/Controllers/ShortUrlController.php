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
        $user = Auth::user();
        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $shortUrls = ShortUrl::orderByDesc('created_at')->get();
        return view('short_urls.index', compact('shortUrls'));
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

    public function edit(ShortUrl $shortUrl)
    {
        $user = Auth::user();
        if ($user->role !== 'admin' && $shortUrl->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }
        return view('short_urls.edit', compact('shortUrl'));
    }

    public function update(Request $request, ShortUrl $shortUrl)
    {
        $user = Auth::user();
        if ($user->role !== 'admin' && $shortUrl->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'original_url' => 'required|url',
            'title' => 'nullable|string|max:255',
        ]);
        $shortUrl->update($request->only('original_url', 'title'));
        return redirect()->route('short_urls.index')->with('success', 'อัปเดตลิงก์สั้นเรียบร้อยแล้ว');
    }

    public function destroy(ShortUrl $shortUrl)
    {
        $user = Auth::user();
        if ($user->role !== 'admin' && $shortUrl->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }
        $shortUrl->delete();
        return redirect()->route('short_urls.index')->with('success', 'ลบลิงก์สั้นเรียบร้อยแล้ว');
    }
}
