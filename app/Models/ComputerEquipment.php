<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComputerEquipment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'computer_equipments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'status_id',
        'code',
        'description',
        'brand',
        'model',
        'serial',
    ];

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
        $categories = Category::where('parent_id', '1')->get();

        $equipments = ComputerEquipment::select('id', 'description', 'code', 'serial', 'category_id')
            ->where('status_id', '1')->get();

        $final = [];
        foreach ($categories as $category) {
            $filtered = $equipments->filter(function ($item) use ($category) {
                return $item->category_id == $category->id;
            });

            $items = collect($filtered->all());

            if ($items->count() > 0) {

                $itemsF = [];
                foreach ($items as $a) {
                    $itemsF[] = ['id' => $a->id, 'name' => $a->code];
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
