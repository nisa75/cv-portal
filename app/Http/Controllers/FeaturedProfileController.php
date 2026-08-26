<?php

namespace App\Http\Controllers;

class FeaturedProfileController extends Controller
{
    public function feature()
    {
        $user = auth()->user();

        if ($user->plan !== 'premium') {
            return back()->withErrors([
                'featured' => 'Profil öne çıkarma sadece Premium üyeler içindir.',
            ]);
        }

        $user->is_featured = true;
        $user->featured_until = now()->addDays(7);
        $user->save();

        return back()->with(
            'success',
            'Profiliniz 7 gün boyunca öne çıkarıldı. 🚀'
        );
    }

    public function remove()
    {
        $user = auth()->user();

        $user->is_featured = false;
        $user->featured_until = null;
        $user->save();

        return back()->with(
            'success',
            'Profil öne çıkarma kaldırıldı.'
        );
    }
}