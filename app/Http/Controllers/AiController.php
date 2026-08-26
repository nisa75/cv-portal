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

    public function improveExperience(Request $request)
    {
        $validated = $request->validate([
            'company' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
        ]);

        $prompt = <<<PROMPT
Bir CV'deki iş deneyimi açıklamasını profesyonel ve etkili hale getir.

Şirket:
{$validated['company']}

Pozisyon:
{$validated['position']}

Mevcut açıklama:
{$validated['description']}

Kurallar:
- Türkçe yaz.
- 50-120 kelime arasında olsun.
- Profesyonel ama doğal bir dil kullan.
- CV'ye uygun olsun.
- Adayın verdiği bilgiler dışında yeni bilgi uydurma.
- Yapılan işleri, kullanılan teknolojileri ve katkıları mümkün olduğunca net ifade et.
- Gereksiz süslü ifadeler kullanma.
- Sadece iyileştirilmiş açıklamayı döndür.
PROMPT;

        $result = Gemini::generativeModel(
            model: 'gemini-3.6-flash'
        )->generateContent($prompt);

        return response()->json([
            'success' => true,
            'description' => trim($result->text()),
        ]);
    }
}