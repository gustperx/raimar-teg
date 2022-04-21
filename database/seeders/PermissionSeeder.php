<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = collect(config('permission_rules'));

        $final = [];
        foreach ($permissions as $key => $permission) {
            $collect = collect($permission);
            $plucked = $collect->pluck('permission', 'display_name');
            $final[$key] = $plucked->all();
        }

        $collect = collect($final);
        $finalPermissions = $collect->flatten()->toArray();

        foreach ($finalPermissions as $permission) {
            Permission::create([
                'name' => $permission,
            ]);
        }

        // add to user
        $user = User::find(1);
        $user->givePermissionTo($finalPermissions);
    }
}
