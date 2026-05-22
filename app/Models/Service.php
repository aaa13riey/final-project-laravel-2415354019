<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    // Kolom mana saja yang bisa diisi (mass assignable)
    protected $fillable = ["name", "price", "description", "status"];

    // Casting tipe data
    protected function casts(): array
    {
        return [
            "status" => "boolean",
            "price" => "integer",
        ];
    }

    /**
     * @return HasMany<Subscription, $this>
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}