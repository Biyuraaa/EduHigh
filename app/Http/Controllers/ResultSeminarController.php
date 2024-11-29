<?php

namespace App\Http\Controllers;

use App\Models\ResultSeminar;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreResultSeminarRequest;
use App\Http\Requests\UpdateResultSeminarRequest;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\ResultAssessment;
use App\Models\ResultAssessmentCriteria;
use App\Models\ResultCriteria;
use App\Models\ResultSeminarReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ResultSeminarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role == "dosen") {
            $resultSeminars = ResultSeminar::where('status', 'approved')
                ->whereHas('resultAssessments', function ($query) {
                    $query->where('dosen_id', Auth::user()->dosen->id)
                        ->whereIn('type', ['pembimbing_1', 'pembimbing_2', 'penguji_1', 'penguji_2']);
                })->get();

            return view("dashboard.dosen.resultSeminars.index", compact('resultSeminars'));
        } else if (Auth::user()->role == "admin") {
            $resultSeminars = ResultSeminar::where('status', 'approved')->get();

            return view("dashboard.admin.resultSeminars.index", compact("resultSeminars"));
        } else {
            return view("dashboard.mahasiswa.resultSeminars.index");
        }
    }

    public function evaluation(String $id)
    {
        $resultSeminar = ResultSeminar::findOrFail($id);

        $materiAssessment = $resultSeminar->resultAssessments()
            ->where('dosen_id', Auth::user()->dosen->id)
            ->where('category', 'material')
            ->first();

        $presentasiAssessment = $resultSeminar->resultAssessments()
            ->where('dosen_id', Auth::user()->dosen->id)
            ->where('category', 'presentation')
            ->first();

        $criterias = ResultCriteria::all()->groupBy('category');

        $materiAssessmentCriterias = $materiAssessment ? $materiAssessment->resultAssessmentCriterias()
            ->pluck('score', 'result_criteria_id')
            ->toArray() : [];

        $presentasiAssessmentCriterias = $presentasiAssessment ? $presentasiAssessment->resultAssessmentCriterias()
            ->pluck('score', 'result_criteria_id')
            ->toArray() : [];

        // Kirim data ke view
        return view('dashboard.dosen.resultSeminars.evaluation', compact(
            'resultSeminar',
            'criterias',
            'materiAssessment',
            'materiAssessmentCriterias',
            'presentasiAssessmentCriterias'
        ));
    }

    public function updateEvaluation(Request $request, ResultSeminar $resultSeminar)
    {
        try {
            $request->validate([
                'scores.*' => 'required|numeric|min:0|max:100',
                'assessment_id' => 'required|exists:proposal_assessments,id'
            ]);

            $assessment = $seminarproposal->proposalAssessments()
                ->where('dosen_id', Auth::user()->dosen->id)
                ->firstOrFail();

            // Begin transaction
            DB::beginTransaction();

            $totalCalculatedScore = 0;
            $totalWeight = 0;

            // Get all criteria
            $criterias = ProposalCriteria::all();

            // Process each score
            foreach ($request->scores as $criteriaId => $score) {
                $criteria = $criterias->find($criteriaId);

                if (!$criteria) {
                    throw new \Exception("Invalid criteria ID: {$criteriaId}");
                }

                $calculatedScore = $score * ($criteria->weight / 100);
                $totalWeight += $criteria->weight;

                // Update or create assessment criteria
                ProposalAssessmentCriteria::updateOrCreate(
                    [
                        'proposal_assessment_id' => $assessment->id,
                        'proposal_criteria_id' => $criteriaId
                    ],
                    [
                        'score' => $score,
                        'calculated_score' => $calculatedScore
                    ]
                );

                $totalCalculatedScore += $calculatedScore;
            }

            // Validate total weight
            if (abs($totalWeight - 100) > 0.01) {
                throw new \Exception("Total criteria weight must be 100%, current: {$totalWeight}%");
            }

            // Update final score
            $assessment->update(['score' => $totalCalculatedScore]);

            // Update seminar proposal grade if all assessments are complete
            $allAssessmentsComplete = $seminarproposal->proposalAssessments()
                ->whereNull('score')
                ->doesntExist();

            if ($allAssessmentsComplete) {
                // Calculate the average score
                $averageScore = $seminarproposal->proposalAssessments()->avg('score');

                // Update numeric grade
                $seminarproposal->numeric_grade = round($averageScore, 2);

                // Convert to letter grade
                $seminarproposal->letter_grade = $this->convertToLetterGrade($averageScore);

                // Save seminar proposal
                $seminarproposal->save();
            }

            DB::commit();

            return redirect()
                ->route('seminarproposals.index')
                ->with('success', 'Assessment has been updated successfully!');
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error('Validation Error in updateEvaluation:', [
                'seminar_id' => $seminarproposal->id,
                'errors' => $e->errors()
            ]);
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in updateEvaluation:', [
                'seminar_id' => $seminarproposal->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()
                ->with('error', 'An error occurred while updating the assessment. Please try again.');
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
    public function store(StoreResultSeminarRequest $request)
    {
        //
        $request->validated();
        try {
            $mahasiswa_id = $request->mahasiswa_id;

            $mahasiswa = Mahasiswa::with('superVisions')->find($mahasiswa_id);

            if (!$mahasiswa) {
                return redirect()->route('resultSeminars.index')->with('error', 'Mahasiswa tidak ditemukan.');
            }

            $dosens = $mahasiswa->superVisions->where('status', 'approved')->pluck('dosen');

            $existingProposal = ResultSeminar::where('mahasiswa_id', $mahasiswa_id)->first();

            if (!$existingProposal) {
                $resultSeminar = ResultSeminar::create([
                    'mahasiswa_id' => $mahasiswa_id,
                    'status' => 'pending',
                ]);


                foreach ($dosens as $dosen) {
                    $result = ResultSeminarReview::create([
                        'dosen_id' => $dosen->id,
                        'result_seminar_id' => $resultSeminar->id,
                        'status' => 'pending',
                    ]);
                }


                return redirect()->route('resultSeminars.index')->with('success', 'Proposal Seminar berhasil diajukan.');
            } else {
                return redirect()->route('resultSeminars.index')->with('error', 'Anda sudah memiliki pengajuan seminar proposal.');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('resultSeminars.index')->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }
    public function request()
    {
        if (!Auth::user()->role == "dosen") {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to access this page');
        } else {

            $resultSeminars = ResultSeminar::whereHas('resultAssessments', function ($query) {
                $query->where('dosen_id', Auth::user()->dosen->id);
            })->get();

            $resultSeminarReviews = ResultSeminarReview::where('dosen_id', Auth::user()->dosen->id)->get();
            return view("dashboard.dosen.resultSeminars.request", compact("resultSeminars", "resultSeminarReviews"));
        }
    }

    public function resubmission(StoreResultSeminarRequest $request)
    {
        $request->validated();

        try {
            $mahasiswa_id = $request->mahasiswa_id;

            $resultSeminar = ResultSeminar::where('mahasiswa_id', $mahasiswa_id)
                ->where('status', 'rejected')
                ->first();

            if ($resultSeminar) {
                $resultSeminar->status = 'pending';
                $resultSeminar->save();

                foreach ($resultSeminar->resultSeminarReviews as $review) {
                    $review->status = 'pending';
                    $review->comment = null;
                    $review->save();
                }

                return redirect()->route('resultSeminars.index')->with('success', 'Proposal Seminar berhasil diajukan ulang, dan status review diperbarui.');
            } else {
                return redirect()->route('resultSeminars.index')->with('error', 'Proposal Seminar tidak ditemukan atau tidak dapat diajukan ulang.');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('resultSeminars.index')->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ResultSeminar $resultSeminar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ResultSeminar $resultSeminar)
    {
        //
        $usedDosenIds = $resultSeminar->resultAssessments()
            ->whereIn('type', ['pembimbing_1', 'pembimbing_2', 'penguji_1'])
            ->pluck('dosen_id')
            ->toArray();

        $availableDosens = Dosen::whereNotIn('id', $usedDosenIds)
            ->with('user:id,name')
            ->get()
            ->map(function ($dosen) {
                return [
                    'id' => $dosen->id,
                    'name' => $dosen->user->name
                ];
            });

        $pengujiAssessment = $resultSeminar->resultAssessments()->where('type', 'penguji_2')->first();
        $selectedDosenId = $pengujiAssessment ? $pengujiAssessment->dosen_id : null;

        return view('dashboard.admin.resultSeminars.edit', compact('resultSeminar', 'availableDosens', 'selectedDosenId'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateResultSeminarRequest $request, ResultSeminar $resultSeminar)
    {
        $request->validated();

        try {
            // Update seminar proposal
            $resultSeminar->update([
                "date" => $request->date,
                "time" => $request->time,
                "location" => $request->location,
            ]);

            $existingAssessments = $resultSeminar->resultAssessments()->where('type', 'penguji_2')->get();

            if ($existingAssessments->isNotEmpty()) {
                if ($existingAssessments->first()->dosen_id != $request->dosen_id) {
                    foreach ($existingAssessments as $assessment) {
                        $assessment->resultAssessmentCriterias()->delete();
                    }

                    $resultSeminar->resultAssessments()->where('type', 'penguji_2')->delete();

                    $this->createResultAssessmentWithCategories($resultSeminar, $request->dosen_id, 'penguji_2');
                }
            } else {
                $this->createResultAssessmentWithCategories($resultSeminar, $request->dosen_id, 'penguji_2');
            }

            // Redirect ke halaman daftar dengan pesan sukses
            return redirect()->route('resultSeminars.index')->with('success', 'Proposal Seminar berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('resultSeminars.edit', $resultSeminar)->with('error', "Terjadi kesalahan. Silakan coba lagi.");
        }
    }

    /**
     * Membuat ResultAssessment dengan kategori material dan presentation.
     *
     * @param  ResultSeminar  $resultSeminar
     * @param  int  $dosenId
     * @param  string  $type
     * @return void
     */
    private function createResultAssessmentWithCategories(ResultSeminar $resultSeminar, $dosenId, $type)
    {
        foreach (['material', 'presentation'] as $category) {
            // Tentukan bobot berdasarkan kategori
            $weight = $category === 'material' ? 20 : 25;

            $resultAssessment = ResultAssessment::create([
                "result_seminar_id" => $resultSeminar->id,
                "dosen_id" => $dosenId,
                "type" => $type,
                "category" => $category,
                "weight" => $weight,
            ]);

            // Ambil semua criteria yang sesuai kategori
            $criterias = ResultCriteria::where('category', $category)->get();

            foreach ($criterias as $criterion) {
                ResultAssessmentCriteria::create([
                    'result_criteria_id' => $criterion->id,
                    'result_assessment_id' => $resultAssessment->id,
                    'score' => 0,
                    'calculated_score' => 0,
                ]);
            }
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResultSeminar $resultSeminar)
    {
        //
    }
}
