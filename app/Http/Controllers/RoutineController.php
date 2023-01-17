<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoutineStoreRequest;
use App\Models\Routine;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Traits\SchoolSession;
use App\Repositories\RoutineRepository;
use App\Interfaces\SchoolClassInterface;
use Illuminate\Http\Response;

class RoutineController extends Controller
{
    use SchoolSession;

    protected $schoolClassRepository;

    public function __construct(SchoolClassInterface $schoolClassRepository)
    {
        $this->schoolClassRepository = $schoolClassRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        $current_school_session_id = $this->getSchoolCurrentSession();
        return view('routines.create')
            ->with([
                'current_school_session_id' => $current_school_session_id,
                'classes' => $this->schoolClassRepository->getAllBySession($current_school_session_id),
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoutineStoreRequest $request
     * @return RedirectResponse
     */
    public function store(RoutineStoreRequest $request)
    {
        try {
            $routineRepository = new RoutineRepository();
            $routineRepository->saveRoutine($request->validated());
            return back()->with('status', 'Routine save was successful!');
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $routine
     * @return Application|Factory|View|Response
     */
    public function show(Request $request)
    {
        $classId = $request->query('class_id', 0);
        $sectionId = $request->query('section_id', 0);
        $currentSchoolSessionId = $this->getSchoolCurrentSession();
        $routineRepository = new RoutineRepository();
        $routines = $routineRepository->getAll($classId, $sectionId, $currentSchoolSessionId);
        $routines = $routines->sortBy('weekday')->groupBy('weekday');
        return view('routines.show')
            ->with(['routines' => $routines]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Routine $routine
     * @return Response
     */
    public function edit(Routine $routine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Routine $routine
     * @return Response
     */
    public function update(Request $request, Routine $routine)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Routine $routine
     * @return Response
     */
    public function destroy(Routine $routine)
    {
        //
    }
}
