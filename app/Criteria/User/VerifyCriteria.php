<?php

namespace App\Criteria\User;

use App\Enums\User\Status;
use Carbon\CarbonImmutable;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class VerifyCriteria
 *
 * @package namespace App\Criteria\User
 */
class VerifyCriteria implements CriteriaInterface
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

        // 承認コードが一致・有効期限を超過していない・保留ステータス
        $model = $model
            ->where('users.verification_code', $params['verification_code'])
            ->where('users.verification_generated_at', '>=', CarbonImmutable::now()->subHours(config('auth.password_timeout_hour')))
            ->whereIn('users.status', [Status::Pending, Status::Activated]);

        return $model;
    }
}
