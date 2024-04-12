<?php

namespace App\Criteria\User;

use App\Enums\User\Status;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class SearchCriteria
 *
 * @package namespace App\Criteria\User
 */
class SearchCriteria implements CriteriaInterface
{
    /**
     * @var array<string,mixed>
     */
    private array $params;

    /**
     * @param array<string,mixed> $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Apply criteria in query repository
     *
     * @param mixed $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $params = $this->params;

        if (empty($params['in_deactivate'])) {
            $model = $model->whereIn('users.status', [
                Status::Pending,
                Status::Activated,
            ]);
        }

        return $model;
    }
}
