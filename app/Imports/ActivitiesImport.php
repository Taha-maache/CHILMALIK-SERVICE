<?php

namespace App\Imports;

use App\Models\Activity;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class ActivitiesImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            if (empty($row[0]) || empty($row[1])) continue;

 Activity::create([
    'code' => trim($row[1]),
    'activity' => trim($row[0]),
]);
        }
    }
}