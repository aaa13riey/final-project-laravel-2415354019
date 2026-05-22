<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
        protected $fillable = ["customer_id", "service_id", "start_date", "end_date", "status"];

    // Casting tipe data
    protected function casts(): array
    {
        return [
            "start_date" => "date",
            "end_date" => "date",
        ];
    }

    /**
     * Relasi: 1 Subscription punya 1 Customer
     * @return BelongsTo<Customer, $this>
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Relasi: 1 Subscription punya 1 Service
     * @return BelongsTo<Service, $this>
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}