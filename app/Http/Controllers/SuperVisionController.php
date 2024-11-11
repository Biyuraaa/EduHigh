<?php

namespace App\Http\Controllers;

use App\Models\SuperVision;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSuperVisionRequest;
use App\Http\Requests\UpdateSuperVisionRequest;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SuperVisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role == 'mahasiswa') {
            $proposal = Auth::user()->proposal;

            if ($proposal) {
                $kbkId = $proposal->subkbk->kbk_id;

                $dosens = Dosen::where('kbk_id', $kbkId)
                    ->withCount('supervisions')
                    ->orderByDesc('supervisions_count')
                    ->get();

                return view('dashboard.mahasiswa.supervisions.index', compact('dosens'));
            } else {
                return view('dashboard.mahasiswa.supervisions.index', ['dosens' => collect()]);
            }
        } else {
            $dosenId = Auth::user()->dosen->id; // Ambil ID dosen yang sedang login
            $students = Mahasiswa::whereHas('supervisions', function ($query) use ($dosenId) {
                $query->where('dosen_id', $dosenId)
                    ->where('status', 'approved');
            })->get();

            return view('dashboard.dosen.supervisions.index', compact('students'));
        }
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSuperVisionRequest $request)
    {
        $request->validated();

        try {
            // Mencari atau membuat data supervisi baru
            $superVision = SuperVision::firstOrCreate(
                [
                    'mahasiswa_id' => $request->mahasiswa_id,
                    'dosen_id' => $request->dosen_id,
                ],
                [
                    'status' => 'pending',
                    'dosen_pembimbing' => 'pembimbing_1'
                ]
            );

            // Jika data sudah ada, perbarui statusnya menjadi 'pending'
            if (!$superVision->wasRecentlyCreated) {
                $superVision->status = 'pending';
                $superVision->comment = null;
                $superVision->save();
            }

            return redirect()->route('supervisions.index')->with('success', 'Supervisi berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('supervisions.index')->with('error', 'Supervisi gagal ditambahkan');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(SuperVision $superVision)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuperVision $superVision)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSuperVisionRequest $request, SuperVision $superVision)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuperVision $superVision)
    {
        //
    }

    public function showDosen(Dosen $dosen)
    {
        //dd
        return view('dashboard.mahasiswa.supervisions.showDosen', compact('dosen'));
    }

    public function showMahasiswa(Mahasiswa $mahasiswa)
    {
        $mahasiswa = Mahasiswa::with([
            'user',
            'user.proposal.subkbk.kbk',
            'user.proposal.titles',
            'user.proposal.researchQuestions.reasons',
            'user.proposal.previousResearches',
            'user.proposal.outputs',
            'user.proposal.backgroundReasons'
        ])->findOrFail($mahasiswa->id);

        return view('dashboard.dosen.supervisions.showMahasiswa', compact('mahasiswa'));
    }

    public function request()
    {


        $students = Auth::user()->dosen->superVisions->where('status', 'pending');
        return view('dashboard.dosen.supervisions.request', compact('students'));
    }

    public function approve(Request $request)
    {
        $request->validate([
            'supervision_id' => 'required|exists:super_visions,id',
        ]);
        $supervision = SuperVision::find(request('supervision_id'));
        $supervision->status = 'approved';
        $supervision->dosen_pembimbing = 'pembimbing_1';
        $supervision->save();

        return redirect()->route('supervisions.request')->with('success', 'Supervisi berhasil diterima');
    }

    public function reject(Request $request)
    {
        $request->validate([
            'supervision_id' => 'required|exists:super_visions,id',
            'comment' => 'nullable|string',
        ]);
        $supervision = SuperVision::find(request('supervision_id'));
        $supervision->status = 'rejected';
        $supervision->comment = request('comment');
        $supervision->save();

        return redirect()->route('supervisions.request')->with('success', 'Supervisi berhasil ditolak');
    }
}
