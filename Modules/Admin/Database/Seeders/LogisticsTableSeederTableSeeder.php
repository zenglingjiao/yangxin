<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Modules\Admin\Models\Logistics;

class LogisticsTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Logistics::insert(
            [
                ['name'=>'7-11超商取貨','freight'=>60,'status'=>1],
                ['name'=>'全家超商取貨','freight'=>60,'status'=>1],
                ['name'=>'萊爾富超商取貨','freight'=>60,'status'=>1],
                ['name'=>'OK超商取貨','freight'=>60,'status'=>1],
                ['name'=>'黑貓宅急便','freight'=>60,'status'=>1],
            ]
        );
    }
}
