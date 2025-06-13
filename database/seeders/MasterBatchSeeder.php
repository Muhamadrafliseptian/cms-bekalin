<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterBatch;
use Carbon\Carbon;

class MasterBatchSeeder extends Seeder
{
    public function run(): void
    {
        $startDate = Carbon::now()->startOfWeek(Carbon::MONDAY); // Senin minggu ini
        $endDate = Carbon::now()->addYear()->endOfYear(); // Akhir tahun depan

        $i = 1;
        while ($startDate->lte($endDate)) {
            $batchStart = $startDate->copy();
            $batchEnd = $startDate->copy()->endOfWeek(Carbon::SUNDAY); // Minggu

            MasterBatch::create([
                'name' => 'Batch ' . $i,
                'code' => 'BATCH-' . $i,
                'start_date' => $batchStart->toDateString(),
                'end_date' => $batchEnd->toDateString(),
            ]);

            $startDate->addWeek(); // lanjut ke minggu berikutnya
            $i++;
        }
    }
}

