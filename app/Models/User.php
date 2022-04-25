<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'dni',
        'allow_login',
        'password',
        'department_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];


    public function isAdministrator()
    {
        return $this->id == 1;
    }

    public static function getDepartmentList($department_id = false, $parent_id = false)
    {
        if (!empty($department_id && is_numeric($department_id))) {
            $departments = Department::whereNotNull('parent_id')->where('id', $department_id)->get();
        } elseif (!empty($parent_id && is_numeric($parent_id))) {
            $departments = Department::where('parent_id', $parent_id)->get();
        } else {
            $departments = Department::whereNotNull('parent_id')->get();
        }

        $users = User::select('id', 'name', 'department_id')->get();

        $final = [];
        foreach ($departments as $department) {
            $filtered = $users->filter(function ($item) use ($department) {
                return $item->department_id == $department->id;
            });

            $items = collect($filtered->all());

            if ($items->count() > 0) {

                $itemsF = [];
                foreach ($items as $a) {
                    $itemsF[] = ['id' => $a->id, 'name' => $a->name];
                }

                $final[] = [
                    'department' => $department->name,
                    'items' => $itemsF
                ];
            }
        }

        return $final;
    }
}
