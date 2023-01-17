<?php

namespace App\Http\Controllers;

use App\Models\Syllabus;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Traits\SchoolSession;
use App\Http\Requests\StoreFileRequest;
use App\Interfaces\SchoolClassInterface;
use App\Repositories\SyllabusRepository;
use Illuminate\Http\Response;

class SyllabusController extends Controller
{
    use SchoolSession;

    private $schoolClassRepository;

    public function __construct(SchoolClassInterface $schoolClassRepository)
    {
        $this->schoolClassRepository = $schoolClassRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index(Request $request)
    {
        $courseId = $request->query('course_id', 0);
        $syllabusRepository = new SyllabusRepository();
        $syllabi = $syllabusRepository->getByCourse($courseId);
        return view('syllabi.show')
            ->with(['syllabi' => $syllabi]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        $currentSchoolSessionId = $this->getSchoolCurrentSession();
        return view('syllabi.create')
            ->with([
                'current_school_session_id' => $currentSchoolSessionId,
                'school_classes' => $this->schoolClassRepository->getAllBySession($currentSchoolSessionId),
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFileRequest $request
     * @return RedirectResponse
     */
    public function store(StoreFileRequest $request)
    {
        $validatedRequest = $request->validated();
        $validatedRequest['class_id'] = $request->class_id;
        $validatedRequest['course_id'] = $request->course_id;
        $validatedRequest['syllabus_name'] = $request->syllabus_name;
        $validatedRequest['session_id'] = $this->getSchoolCurrentSession();

        try {
            $syllabusRepository = new SyllabusRepository();
            $syllabusRepository->store($validatedRequest);
            return back()->with('status', 'Creating syllabus was successful!');
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Syllabus $syllabus
     * @return Response
     */
    public function show(Syllabus $syllabus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Syllabus $syllabus
     * @return Response
     */
    public function edit(Syllabus $syllabus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Syllabus $syllabus
     * @return Response
     */
    public function update(Request $request, Syllabus $syllabus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Syllabus $syllabus
     * @return Response
     */
    public function destroy(Syllabus $syllabus)
    {
        //
    }
}
