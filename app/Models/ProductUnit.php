<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductUnit extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'company_id',
    ];

    /**
     * Define Relation with Product Model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Define Relation with Company Model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * List Product Units for Select2 Javascript Library.
     *
     * @param mixed $company_id
     *
     * @return json
     */
    public static function getSelect2Array($company_id)
    {
        // return
        return self::findByCompany($company_id)
            ->select('id', 'name AS text')
            ->get();
    }

    /**
     * Scope a query to only include Product Units of a given company.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int                                   $company_id
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFindByCompany($query, $company_id)
    {
        $query->where('company_id', $company_id);
    }
}
