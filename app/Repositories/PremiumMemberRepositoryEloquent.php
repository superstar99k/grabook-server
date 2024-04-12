<?php

namespace App\Repositories;

use App\Models\PremiumMember;

/**
 * Class PremiumMemberRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PremiumMemberRepositoryEloquent extends RepositoryEloquent implements PremiumMemberRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PremiumMember::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
    }
}
