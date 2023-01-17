<?php

namespace App\Repositories;

use App\Interfaces\AssignmentRepository;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentRepositoryImpl implements AssignmentRepository
{
    public function store(Request $request)
    {
        // Automatically generate a unique ID for filename...
        $path = Storage::disk('public')->put('assignments', $request['file']);
        try {
            Assignment::create([
                'assignment_name' => $request->assignment_name,
                'assignment_file_path' => $path,
                'teacher_id' => $request->user()->id,
                'class_id' => $request->class_id,
                'section_id' => $request->section_id,
                'course_id' => $request->course_id,
                'semester_id' => $request->semester_id,
                'session_id' => $request->school_session_id
            ]);
        } catch (\Exception $e) {
            throw new \Exception('Failed to create assignment. ' . $e->getMessage());
        }
    }

    public function getAssignments(int $sessionId, int $courseId)
    {
        return Assignment::where('course_id', $courseId)
            ->where('session_id', $sessionId)
            ->get();
    }
}
