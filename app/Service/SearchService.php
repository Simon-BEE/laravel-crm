<?php

namespace App\Service;

use Illuminate\Database\Eloquent\Builder;

class SearchService
{
    /**
     * Search some keywords in database
     *
     * @param Builder $model
     * @param string $keywords
     * @param string|array $attributes
     * @return void
     */
    public function searchByKeywords(Builder $model, string $keywords, $attributes)
    {
        if (!is_null($keywords) && strlen($keywords) > 2) {
            foreach (explode(' ', $keywords) as $keyword) {
                $model->whereLike($attributes, $keyword);
            }
        }
    }
}
