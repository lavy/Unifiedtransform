<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamRuleStoreRequest;
use App\Interfaces\ExamRuleRepository;
use App\Models\ExamRule;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Traits\SchoolSession;
use Illuminate\Http\Response;

class ExamRuleController extends Controller
{
    use SchoolSession;

    private $repository;

    public function __construct(ExamRuleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * \Illuminate\Http\Request  $request
     * @return Application|Factory|View|Response
     */
    public function index(Request $request)
    {
        $currentSchoolSessionId = $request->school_session_id;
        $examId = $request->query('exam_id', 0);
        return view('exams.view-rule')
            ->with(['exam_rules' => $this->repository->getAll($currentSchoolSessionId, $examId)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Application|Factory|View|Response
     */
    public function create(Request $request)
    {
        $examId = $request->query('exam_id');
        return view('exams.add-rule')
            ->with(['exam_id' => $examId, 'current_school_session_id' => $request->school_session_id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ExamRuleStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ExamRuleStoreRequest $request)
    {
        try {
            $this->repository->create($request->validated());
            return back()->with('status', 'Exam rule creation was successful!');
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\ExamRule $examRule
     * @return Response
     */
    public function show(ExamRule $examRule)
    {
        return view('exams.view-rule');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @return Application|Factory|View|Response
     */
    public function edit(Request $request)
    {
        return view('exams.edit-rule')
            ->with(['exam_rule' => $this->repository->getById($request->exam_rule_id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request)
    {
        try {
            $this->repository->update($request);
            return back()->with('status', 'Exam rule update was successful!');
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ExamRule $examRule
     * @return Response
     */
    public function destroy(ExamRule $examRule)
    {
        //
    }
}
