<?php

namespace App\Traits;

trait HandlesRelationships
{
    /**
     * Apply relationships (eager loading) to a query based on query parameters.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $queryParams
     * @return void
     */
    public function applyRelationships($query, array $queryParams): void
    {
        if (!empty($queryParams['with'])) {
            $relationships = explode(',', $queryParams['with']);
            $query->with($relationships);
        }
    }
}
