<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $activities = DB::table('activities_fr')->get();

        foreach ($activities as $a) {
            DB::table('activities_fr')
                ->where('id', $a->id)
                ->update([
                    'code' => $a->activity,
                    'activity' => $a->code,
                ]);
        }
    }

    public function down(): void
    {
        $activities = DB::table('activities_fr')->get();

        foreach ($activities as $a) {
            DB::table('activities_fr')
                ->where('id', $a->id)
                ->update([
                    'code' => $a->activity,
                    'activity' => $a->code,
                ]);
        }
    }
};