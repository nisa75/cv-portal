<?php

namespace App\Http\Controllers;

use Gemini\Laravel\Facades\Gemini;
use Illuminate\Http\Request;

class AiController extends Controller
{
    public function generateAbout(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'skills' => 'nullable|string|max:2000',
            'experience' => 'nullable|string|max:3000',
            'education' => 'nullable|string|max:2000',
            'current_about' => 'nullable|string|max:3000',
        ]);

        $prompt = <<<PROMPT
Bir CV için profesyonel ve doğal bir "Hakkımda" bölümü yaz.

Aday:
Ad: {$validated['name']}

Yetenekler:
{$validated['skills']}

Deneyim:
{$validated['experience']}

Eğitim:
{$validated['education']}

Mevcut Hakkımda:
{$validated['current_about']}

Kurallar:
- Türkçe yaz.
- 80-150 kelime arasında olsun.
- Profesyonel ama doğal bir dil kullan.
- Var olmayan bilgi uydurma.
- Birinci tekil şahıs kullan.
- İş başvurusu yapılabilecek profesyonel bir CV'ye uygun olsun.
- Başına "Hakkımda" başlığı koyma.
PROMPT;

        $result = Gemini::generativeModel(
            model: 'gemini-3.6-flash'
        )->generateContent($prompt);

        return response()->json([
            'success' => true,
            'about' => trim($result->text()),
        ]);
    }
}