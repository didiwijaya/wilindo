<?php

namespace DidiWijaya\WilIndo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'province_code',
        'name',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->table = config('wilindo.prefix') . 'cities';
        parent::__construct($attributes);
    }

    /**
     * Get the province that owns the city.
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }

    /**
     * Get the districts for the city.
     */
    public function districts(): HasMany
    {
        return $this->hasMany(District::class, 'city_code', 'code');
    }

    /**
     * Get the villages for the city.
     */
    public function villages(): HasMany
    {
        return $this->hasManyThrough(Village::class, District::class, 'city_code', 'district_code', 'code', 'code');
    }

    /**
     * Scope a query to only include cities with a specific name.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $name
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByName($query, string $name)
    {
        return $query->where('name', 'like', '%' . $name . '%');
    }

    /**
     * Scope a query to only include cities with a specific code.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $code
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByCode($query, string $code)
    {
        return $query->where('code', $code);
    }

    /**
     * Scope a query to only include cities in a specific province.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $provinceCode
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByProvince($query, string $provinceCode)
    {
        return $query->where('province_code', $provinceCode);
    }
}
