<?php

namespace App\Imports;

use App\Models\ActivityFr;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class ActivitiesFrImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            if (empty($row[0]) || empty($row[1])) continue;

            ActivityFr::create([
                'code' => trim($row[1]),
                'activity' => trim($row[0]),
            ]);
        }
    }
}