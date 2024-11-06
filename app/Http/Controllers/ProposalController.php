<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProposalRequest;
use App\Http\Requests\UpdateProposalRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\SubKbk;

class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        if (Auth::user()->role == 'admin') {
            $proposals = Proposal::all();
            return view('dashboard.admin.proposals.index', compact('proposals'));
        } else {

            $proposal = Proposal::where('user_id', Auth::user()->id)->first();
            return view('dashboard.mahasiswa.proposals.index', compact('proposal'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $subkbks = SubKbk::all();
        $proposal = Proposal::where('user_id', Auth::user()->id)->first();
        // if ($proposal) {
        //     //redirect to proposals.index
        //     return redirect()->route('proposals.index')->with('status', 'proposal-exists');
        // }
        return view('dashboard.mahasiswa.proposals.create', compact('subkbks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProposalRequest $request)
    {
        //

        $request->validated();



        try {
            $proposal = Proposal::create([
                'topic' => $request->topic,
                'background' => $request->background,
                'subkbk_id' => $request->subkbk_id,
                'user_id' => Auth::user()->id,
            ]);

            foreach ($request->titles as $name) {
                $proposal->titles()->create([
                    'name' => $name,
                ]);
            }

            foreach ($request->backgroundReasons as $backgroundReason) {
                $proposal->backgroundReasons()->create([
                    'reason' => $backgroundReason,
                ]);
            }



            foreach ($request->previousResearch as $previousResearch) {
                $proposal->previousResearches()->create([
                    'title' => $previousResearch['title'],
                    'doi' => $previousResearch['doi'],
                    'authors' => $previousResearch['authors'],
                    'problem_statement' => $previousResearch['problem'],
                    'results' => $previousResearch['results'],
                ]);
            }



            foreach ($request->researchQuestions as $researchQuestion) {
                $proposal->researchQuestions()->create([
                    'question' => $researchQuestion,
                ]);
            }



            foreach ($request->researchOutputs as $researchOutput) {
                $proposal->outputs()->create([
                    'research_output' => $researchOutput,
                ]);
            }

            return redirect()->route('proposals.index')->with('status', 'proposal-created');
        } catch (\Exception $e) {
            return redirect()->back()->with('status', 'proposal-created-failed');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Proposal $proposal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proposal $proposal)
    {
        $subkbks = SubKbk::all();
        return view('dashboard.mahasiswa.proposals.edit', compact('proposal', 'subkbks'));
    }


    /**
     * Update the specified resource in storage.
     */
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProposalRequest $request, Proposal $proposal)
    {
        $request->validated();

        try {
            // Update main proposal fields
            $proposal->update([
                'topic' => $request->topic,
                'background' => $request->background,
                'subkbk_id' => $request->subkbk_id,
            ]);


            // Update or recreate related data
            $proposal->titles()->delete();
            foreach ($request->titles as $name) {
                $proposal->titles()->create([
                    'name' => $name,
                ]);
            }


            $proposal->backgroundReasons()->delete();
            foreach ($request->backgroundReasons as $backgroundReason) {
                $proposal->backgroundReasons()->create([
                    'reason' => $backgroundReason,
                ]);
            }

            $proposal->previousResearches()->delete();
            foreach ($request->previousResearches as $previousResearches) {
                $proposal->previousResearches()->create([
                    'title' => $previousResearches['title'],
                    'doi' => $previousResearches['doi'],
                    'authors' => $previousResearches['authors'],
                    'problem_statement' => $previousResearches['problem_statement'],
                    'results' => $previousResearches['results'],
                ]);
            }

            $proposal->researchQuestions()->delete();
            foreach ($request->researchQuestions as $researchQuestion) {
                $proposal->researchQuestions()->create([
                    'question' => $researchQuestion,
                ]);
            }

            $proposal->outputs()->delete();
            foreach ($request->outputs as $researchOutput) {
                $proposal->outputs()->create([
                    'research_output' => $researchOutput,
                ]);
            }

            return redirect()->route('proposals.index')->with('status', 'proposal-updated');
        } catch (\Exception $e) {
            return redirect()->back()->with('status', 'proposal-update-failed');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proposal $proposal)
    {
        //
    }
}
