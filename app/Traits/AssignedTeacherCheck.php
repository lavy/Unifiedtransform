<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Repositories\AssignedTeacherRepositoryImpl;

trait AssignedTeacherCheck
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param int $current_school_session_id
     * @return string
     */
    public function checkIfLoggedInUserIsAssignedTeacher(Request $request, $current_school_session_id)
    {
        $assignedTeacherRepository = new AssignedTeacherRepositoryImpl();

        $assignedTeacher = $assignedTeacherRepository->getAssignedTeacher($current_school_session_id, $request->semester_id, $request->class_id, $request->section_id, $request->course_id);

        if (is_null($assignedTeacher) || $assignedTeacher->teacher_id !== $request->user()->id) {
            abort(404);
        }
    }
}
