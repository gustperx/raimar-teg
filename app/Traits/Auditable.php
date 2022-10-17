<?php

namespace App\Traits;

use App\Models\Audit;
use Illuminate\Support\Str;

trait Auditable
{
    public function audit($module, $event)
    {
        Audit::create([
            'user_id' => auth()->user()->id,
            'module' => Str::lower($module),
            'event' => Str::lower($event),
        ]);
    }
}
