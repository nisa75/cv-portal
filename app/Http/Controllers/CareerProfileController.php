<?php

namespace App\Http\Controllers;

use App\Models\CandidateAchievement;
use App\Models\CandidateCertificate;
use App\Models\CandidateCourse;
use App\Models\CandidateLanguage;
use App\Models\CandidateProject;
use App\Models\CandidateReference;
use App\Models\CandidateTechnicalInfo;
use App\Models\CandidateVolunteering;
use App\Models\Company;
use App\Models\CompanyFollow;
use App\Models\CoverLetter;
use App\Models\ProfileView;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CareerProfileController extends Controller
{
    private array $map = [
        'certificates' => [CandidateCertificate::class, ['name','issuer','issued_at','credential_id','credential_url','description']],
        'courses' => [CandidateCourse::class, ['name','provider','completed_at','certificate_url','description']],
        'technical' => [CandidateTechnicalInfo::class, ['category','name','level','years','notes']],
        'languages' => [CandidateLanguage::class, ['language','level','certificate']],
        'references' => [CandidateReference::class, ['name','position','company','email','phone','note']],
        'projects' => [CandidateProject::class, ['title','tech_stack','description','project_url','github_url','image']],
        'volunteering' => [CandidateVolunteering::class, ['organization','role','start_date','end_date','description']],
        'achievements' => [CandidateAchievement::class, ['title','organization','achieved_at','description','url']],
    ];

    public function saveSection(Request $request, string $section)
    {
        abort_unless(isset($this->map[$section]), 404);
        [$model, $fields] = $this->map[$section];
        $rules = [];
        foreach ($fields as $field) $rules[$field] = 'nullable|string|max:5000';
        $data = $request->validate($rules);
        if (!empty($data['credential_url']) || !empty($data['certificate_url']) || !empty($data['project_url']) || !empty($data['github_url']) || !empty($data['url'])) {
            foreach (['credential_url','certificate_url','project_url','github_url','url'] as $url) if (array_key_exists($url,$data) && $data[$url]) {
                validator([$url=>$data[$url]], [$url=>'nullable|url|max:1000'])->validate();
            }
        }
        if ($request->filled('id')) {
            $item = $model::where('user_id', $request->user()->id)->findOrFail($request->integer('id'));
            $item->update($data);
        } else {
            $data['user_id'] = $request->user()->id;
            $model::create($data);
        }
        return back()->with('success', 'Profil bölümü güncellendi.');
    }

    public function deleteSection(Request $request, string $section, int $id)
    {
        abort_unless(isset($this->map[$section]), 404);
        [$model] = $this->map[$section];
        $model::where('user_id', $request->user()->id)->findOrFail($id)->delete();
        return back()->with('success', 'Kayıt silindi.');
    }

    public function saveSettings(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'headline' => 'nullable|string|max:150',
            'is_public' => 'nullable|boolean',
        ]);
        $profile = $user->candidateProfile ?: $user->candidateProfile()->create(['user_id'=>$user->id]);
        $profile->update([
            'headline' => $data['headline'] ?? null,
            'is_public' => $request->boolean('is_public'),
        ]);
        return back()->with('success', 'Profil görünürlüğün güncellendi.');
    }

    public function publicProfile(Request $request, int $userId)
    {
        $candidate = User::where('role','candidate')->with('candidateProfile')->findOrFail($userId);
        abort_unless($candidate->candidateProfile?->is_public, 404);

        $viewer = $request->user();
        if (!$viewer || $viewer->id !== $candidate->id) {
            $existing = ProfileView::where('candidate_id',$candidate->id)
                ->where('viewer_id',$viewer?->id)
                ->where('viewed_at','>=',now()->subDay())->first();
            if (!$existing) {
                ProfileView::create([
                    'candidate_id'=>$candidate->id,
                    'viewer_id'=>$viewer?->id,
                    'ip_address'=>$request->ip(),
                    'user_agent'=>substr((string)$request->userAgent(),0,500),
                    'viewed_at'=>now(),
                ]);
                $candidate->candidateProfile()->increment('profile_views_count');
                if ($viewer && method_exists($viewer,'notifications')) {
                    DB::table('notifications')->insert([
                        'id'=>(string) \Illuminate\Support\Str::uuid(),
                        'type'=>'profile_viewed',
                        'notifiable_type'=>User::class,
                        'notifiable_id'=>$candidate->id,
                        'data'=>json_encode(['title'=>'Profilin görüntülendi','message'=>'Profilin bir işveren veya kullanıcı tarafından görüntülendi.','url'=>'/profile/'.$candidate->id]),
                        'created_at'=>now(),'updated_at'=>now(),
                    ]);
                }
            }
        }

        $candidateId = $candidate->id;
        return view('profile.public', [
            'candidate'=>$candidate,
            'profile'=>$candidate->candidateProfile,
            'certificates'=>CandidateCertificate::where('user_id',$candidateId)->latest()->get(),
            'courses'=>CandidateCourse::where('user_id',$candidateId)->latest()->get(),
            'technical'=>CandidateTechnicalInfo::where('user_id',$candidateId)->latest()->get(),
            'languages'=>CandidateLanguage::where('user_id',$candidateId)->latest()->get(),
            'references'=>CandidateReference::where('user_id',$candidateId)->latest()->get(),
            'projects'=>CandidateProject::where('user_id',$candidateId)->latest()->get(),
            'volunteering'=>CandidateVolunteering::where('user_id',$candidateId)->latest()->get(),
            'achievements'=>CandidateAchievement::where('user_id',$candidateId)->latest()->get(),
        ]);
    }

    public function followCompany(Request $request, int $companyId)
    {
        $company = Company::findOrFail($companyId);
        CompanyFollow::firstOrCreate(['user_id'=>$request->user()->id,'company_id'=>$company->id]);
        return back()->with('success', $company->name.' takip edilmeye başlandı.');
    }

    public function unfollowCompany(Request $request, int $companyId)
    {
        CompanyFollow::where('user_id',$request->user()->id)->where('company_id',$companyId)->delete();
        return back()->with('success', 'Şirket takibi bırakıldı.');
    }

    public function coverLetters(Request $request)
    {
        return view('cover-letters.index', ['letters'=>CoverLetter::where('user_id',$request->user()->id)->latest()->get()]);
    }

    public function saveCoverLetter(Request $request)
    {
        $data = $request->validate([
            'title'=>'required|string|max:150','job_title'=>'nullable|string|max:150','company'=>'nullable|string|max:150',
            'content'=>'required|string|max:20000','is_default'=>'nullable|boolean','id'=>'nullable|integer',
        ]);
        if (!empty($data['is_default'])) CoverLetter::where('user_id',$request->user()->id)->update(['is_default'=>false]);
        if (!empty($data['id'])) {
            $item=CoverLetter::where('user_id',$request->user()->id)->findOrFail($data['id']);
            unset($data['id']); $item->update($data);
        } else { $data['user_id']=$request->user()->id; CoverLetter::create($data); }
        return back()->with('success','Ön yazın kaydedildi.');
    }

    public function deleteCoverLetter(Request $request, int $id)
    {
        CoverLetter::where('user_id',$request->user()->id)->findOrFail($id)->delete();
        return back()->with('success','Ön yazı silindi.');
    }
}
