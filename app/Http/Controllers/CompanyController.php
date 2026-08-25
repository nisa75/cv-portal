<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function show()
    {
        $company = auth()->user()->company;

        return view('company-profile', compact('company'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:3000',
            'industry' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
        ]);
if ($request->hasFile('logo')) {
    $validated['logo'] = $request
        ->file('logo')
        ->store('company-logos', 'public');
}
        Company::updateOrCreate(
            ['user_id' => auth()->id()],
            $validated
        );

        return redirect('/employer/company')
            ->with('success', 'Firma bilgileri başarıyla kaydedildi.');
    }
}