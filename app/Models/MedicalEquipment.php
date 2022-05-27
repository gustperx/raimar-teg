<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class MedicalEquipment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'medical_equipments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'status_id',
        'department_id',
        'code',
        'description',
        'brand',
        'model',
        'serial',
    ];


    /**
     * Get the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function code(): Attribute
    {
        $lastId = 1;
        $prefix = "CCMED";
        $query = MedicalEquipment::withTrashed()->latest()->first();
        if (!empty($query)) {
            $lastId = $query->id + 1;
        }

        $codeId = empty($this->id) ? $lastId : $this->id;

        $preZero = "";
        if (Str::length($lastId) == 1) {
            $preZero = "00";
        } else if (Str::length($lastId) == 2) {
            $preZero = "0";
        }

        return Attribute::make(
            set: fn ($value, $attributes) => $prefix . $preZero . $codeId,
        );
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query
                    ->where('description', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%')
                    ->orWhere('serial', 'like', '%' . $search . '%');
            });
        });
    }

    public static function getEquipmentList()
    {
        $categories = Category::where('parent_id', '2')->get();

        $equipments = MedicalEquipment::where('status_id', '1')->get();

        $final = [];
        foreach ($categories as $category) {
            $filtered = $equipments->filter(function ($item) use ($category, $final) {
                return $item->category_id == $category->id;
            });

            $items = collect($filtered->all());

            if ($items->count() > 0) {

                $itemsF = [];
                foreach ($items as $a) {
                    $itemsF[] = ['id' => $a->id, 'name' => "{$a->code} - {$a->brand} - {$a->model}"];
                }

                $final[] = [
                    'label' => $category->name,
                    'items' => $itemsF
                ];
            }
        }

        return $final;
    }

    public static function getEquipmentMaintenanceList()
    {
        $categories = Category::where('parent_id', '2')->get();

        $equipments = MedicalEquipment::where('status_id', '!=', '1')->get();

        $final = [];
        foreach ($categories as $category) {
            $filtered = $equipments->filter(function ($item) use ($category, $final) {
                return $item->category_id == $category->id;
            });

            $items = collect($filtered->all());

            if ($items->count() > 0) {

                $itemsF = [];
                foreach ($items as $a) {
                    $itemsF[] = ['id' => $a->id, 'name' => "{$a->code} - {$a->brand} - {$a->model}"];
                }

                $final[] = [
                    'label' => $category->name,
                    'items' => $itemsF
                ];
            }
        }

        return $final;
    }
}
