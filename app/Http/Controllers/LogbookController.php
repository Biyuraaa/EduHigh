<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLogbookRequest;
use App\Http\Requests\UpdateLogbookRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogbookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Periksa peran user yang login
        if (Auth::user()->role == "dosen") {
            // Untuk dosen: Ambil logbook mahasiswa yang dia supervisi dengan status "pending"
            $logbooks = Logbook::whereHas('appointment.mahasiswa.supervisions', function ($query) {
                $query->where('dosen_id', Auth::user()->dosen->id); // Ambil logbook berdasarkan dosen yang login
            })->where('status', 'pending')->paginate(10);

            // Tampilkan ke halaman dosen
            return view("dashboard.dosen.logbooks.index", compact("logbooks"));
        } else if (Auth::user()->role == "mahasiswa") {
            $logbooks = Logbook::whereHas('appointment', function ($query) {
                $query->where('mahasiswa_id', Auth::user()->mahasiswa->id); // Ambil logbook berdasarkan mahasiswa yang login
            })->paginate(10);

            // Tampilkan ke halaman mahasiswa
            return view("dashboard.mahasiswa.logbooks.index", compact("logbooks"));
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        if (Auth::user()->role == "admin") {
            return view("dashboard.dosen.logbooks.create");
        } else if (Auth::user()->role == "mahasiswa") {

            return view("dashboard.mahasiswa.logbooks.create");
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLogbookRequest $request)
    {
        //
        $request->validated();

        try {
            Logbook::create([
                "appointment_id" => $request->appointment_id,
                "notes" => $request->notes,
                "status" => "pending",
            ]);
            return redirect()->route("appointments.index")->with("success", "Logbook created successfully");
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route("appointments.index")->with("error", "Logbook created successfully");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Logbook $logbook)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Logbook $logbook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLogbookRequest $request, Logbook $logbook)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Logbook $logbook)
    {
        //
    }

    public function confirmLogbook(Request $request, Logbook $logbook)
    {
        $logbook = Logbook::findOrFail($logbook->id);

        // Update status based on input
        $logbook->status = $request->input('status');
        $logbook->comments = $request->input('comments', null);
        $logbook->save();

        return redirect()->route('logbooks.index')->with('success', 'Logbook status berhasil diperbarui.');
    }
    public function filter(Request $request)
    {
        $query = Logbook::query();

        if ($request->search) {
            $query->whereHas('dosen', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%");
            })
                ->orWhereHas('mahasiswa', function ($q) use ($request) {
                    $q->where('name', 'like', "%{$request->search}%");
                })
                ->orWhere('consultaion_notes', 'like', "%{$request->search}%");
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->date) {
            $query->whereDate('consultation_date', $request->date);
        }

        $logbooks = $query->with(['dosen', 'mahasiswa'])->latest()->get();

        return view('dashboard.partials.logbooks-table', compact('logbooks'));
    }

    public function viewPdf()
    {
        // Mendapatkan data mahasiswa yang sedang login
        $mahasiswa = Auth::user()->mahasiswa;

        $logbooks = Logbook::whereHas('appointment', function ($query) use ($mahasiswa) {
            $query->where('mahasiswa_id', $mahasiswa->id)
                ->where('status', 'approved');
        })->where('status', 'confirmed')
            ->get();

        return view('dashboard.mahasiswa.logbooks.export', compact('logbooks', 'mahasiswa'));
    }

    public function export()
    {
        $mahasiswa = Auth::user()->mahasiswa;
        $logbooks = Logbook::whereHas('appointment', function ($query) use ($mahasiswa) {
            $query->where('mahasiswa_id', $mahasiswa->id)
                ->where('status', 'approved');
        })->where('status', 'confirmed')
            ->get();

        $pdf = Pdf::loadView('dashboard.mahasiswa.logbooks.export', compact('logbooks', 'mahasiswa'));
        return $pdf->download('logbook.pdf');
    }
}
