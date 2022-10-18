<?php

namespace App\Traits;

use App\Models\Audit;
use Illuminate\Support\Str;

trait Auditable
{
    public function audit($module, $event, $user = null)
    {
        Audit::create([
            'user_id' => empty($user) ? auth()->user()->id : $user->id,
            'module' => Str::lower($module),
            'event' => Str::lower($event),
        ]);
    }
}
