<?php

namespace App\Http\Controllers;

use App\Interfaces\AssignmentRepository;
use App\Models\Assignment;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Traits\SchoolSession;
use App\Http\Requests\StoreFileRequest;

class AssignmentController extends Controller
{

    private $repository;

    public function __construct(AssignmentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|\Illuminate\Http\Response
     */
    public function getCourseAssignments(Request $request)
    {
        $courseId = $request->query('course_id', 0);
        return view('assignments.index')
            ->with(['assignments'   => $this->repository->getAssignments($request->school_session_id, $courseId)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(Request $request)
    {
        return view('assignments.create')
            ->with([
                'current_school_session_id' => $request->school_session_id,
                'class_id'  => $request->query('class_id', 0),
                'section_id'  => $request->query('section_id', 0),
                'course_id'  => $request->query('course_id', 0),
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreFileRequest $request)
    {
        $valid = $request->validated();
        $valid['class_id'] = $request->class_id;
        $valid['section_id'] = $request->section_id;
        $valid['course_id'] = $request->course_id;
        $valid['semester_id'] = $request->semester_id;
        $valid['assignment_name'] = $request->assignment_name;
        $valid['session_id'] = $request->school_session_id;

        try {
            $this->repository->store($valid);
            return back()->with('status', 'Creating assignment was successful!');
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function show(Assignment $assignment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function edit(Assignment $assignment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assignment $assignment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assignment $assignment)
    {
        //
    }
}
