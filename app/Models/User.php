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
        'dni_type',
        'allow_login',
        'password',
        'department_id',
        'address',
        'phone',
        'code_phone',
        'gender',
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

    public function department()
    {
        return $this->belongsTo(Department::class, $this->department_id);
    }


    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query
                    ->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('dni', 'like', '%' . $search . '%');
            });
        });
    }

    public static function getDepartmentList($department_id = false, $parent_id = false)
    {
        if (!empty($department_id && is_numeric($department_id))) {
            $departments = Department::whereNotNull('parent_id')->where('id', $department_id)->get();
        } elseif (!empty($department_id && is_array($department_id))) {
            $departments = Department::whereNotNull('parent_id')->whereIn('id', $department_id)->get();
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
                    'label' => $department->name,
                    'items' => $itemsF
                ];
            }
        }

        return $final;
    }


    public static function getDniTypes()
    {
        return [
            ['value' => 'V', 'label' => 'V'],
            ['value' => 'E', 'label' => 'E'],
        ];
    }


    public static function getAllowLogin()
    {
        return [
            ['value' => 0, 'label' => 'No'],
            ['value' => 1, 'label' => 'Si'],
        ];
    }

    public static function getGenderTypes()
    {
        return [
            ['value' => 'M', 'label' => 'Hombre'],
            ['value' => 'F', 'label' => 'Mujer'],
            ['value' => 'O', 'label' => 'Otro'],
        ];
    }

    public static function getCodePhone()
    {
        return [
            ['value' => '0412', 'label' => '0412'],
            ['value' => '0414', 'label' => '0414'],
            ['value' => '0424', 'label' => '0424'],
            ['value' => '0416', 'label' => '0416'],
            ['value' => '0426', 'label' => '0426'],
        ];
    }
}
