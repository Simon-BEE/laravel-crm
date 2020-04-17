<?php

namespace App\Service;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class SearchService
{
    /**
     * Search by customer id
     *
     * @param mixed $models
     * @param integer $customerId
     * @return void
     */
    public function searchByCustomer($models, int $customerId)
    {
        if ($customerId > 0) {
            $searchData = request()->validate(['customers' => 'required|exists:users,id']);
            foreach (Arr::wrap($models) as $model) {
                $model->where('customer_id', $searchData['customers']);
            }
        }
    }
    /**
     * Search some keywords in database
     *
     * @param mixed $models
     * @param string $keywords
     * @param string|array $attributes
     * @return void
     */
    public function searchByKeywords($models, ?string $keywords, $attributes)
    {
        if (!is_null($keywords) && strlen($keywords) > 2) {
            foreach (Arr::wrap($models) as $model) {
                foreach (explode(' ', $keywords) as $keyword) {
                    $model->whereLike($attributes, $keyword);
                }
            }
        }
    }

    /**
     * Search by status
     *
     * @param mixed $models
     * @param integer $status
     * @return void
     */
    public function searchByStatus($models, int $statusId)
    {
        if ($statusId > 0) {
            $searchData = request()->validate(['status' => 'required|exists:statuses,id']);
            foreach (Arr::wrap($models) as $model) {
                $model->where('status_id', $searchData['status']);
            }
        }
    }

    /**
     * Search by range amount between $min and $max
     *
     * @param mixed $models
     * @param integer $range
     * @param integer $min
     * @param integer $max
     * @return void
     */
    public function searchBetweenByRange($models, $range, int $min = 100, int $max = 10000)
    {
        if (is_numeric($range) && $range > $min && $range < $max) {
            foreach (Arr::wrap($models) as $model) {
                $model->where('amount', '>', $range);
            }
        }
    }
}
