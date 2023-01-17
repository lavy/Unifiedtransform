<?php

namespace App\Interfaces;

interface ExamRuleRepository {
    public function create($request);

    public function update($request);

    public function getAll($session_id, $exam_id);

    public function getById($exam_rule_id);
}
