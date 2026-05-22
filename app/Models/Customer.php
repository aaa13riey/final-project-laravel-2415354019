<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = ["customer_id", "name", "email", "phone", "address", "status"];

    // Casting tipe data
    protected function casts(): array
    {
        return [
            "status" => "boolean",
        ];
    }

    /**
     * Relasi: 1 Customer bisa punya banyak Subscription
     * @return HasMany<Subscription, $this>
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}