<?php

namespace App\Service;

use Illuminate\Database\Eloquent\Builder;

class SearchService
{
    public function searchByCustomer(Builder $model, int $customerId)
    {
        if ($customerId > 0) {
            $searchData = request()->validate(['customers' => 'required|exists:users,id']);
            $model->where('customer_id', $searchData['customers']);
        }
    }
    /**
     * Search some keywords in database
     *
     * @param Builder $model
     * @param string $keywords
     * @param string|array $attributes
     * @return void
     */
    public function searchByKeywords(Builder $model, ?string $keywords, $attributes)
    {
        if (!is_null($keywords) && strlen($keywords) > 2) {
            foreach (explode(' ', $keywords) as $keyword) {
                $model->whereLike($attributes, $keyword);
            }
        }
    }

    /**
     * Search by status
     *
     * @param Builder $model
     * @param integer $status
     * @return void
     */
    public function searchByStatus(Builder $model, int $statusId)
    {
        if ($statusId > 0) {
            $searchData = request()->validate(['status' => 'required|exists:statuses,id']);
            $model->where('status_id', $searchData['status']);
        }
    }

    /**
     * Search by range amount between $min and $max
     *
     * @param Builder $model
     * @param integer $range
     * @param integer $min
     * @param integer $max
     * @return void
     */
    public function searchBetweenByRange(Builder $model, $range, int $min = 100, int $max = 10000)
    {
        if (is_numeric($range) && $range > $min && $range < $max) {
            $model->where('amount', '>', $range);
        }
    }
}
