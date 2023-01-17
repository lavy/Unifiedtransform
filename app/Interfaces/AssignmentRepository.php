<?php

namespace App\Interfaces;


use Illuminate\Http\Request;

interface AssignmentRepository
{
    public function store(Request $request);

    public function getAssignments(int $sessionId, int $courseId);
}
