<?php

namespace App\Services;

use App\Models\User;

/**
 * @method User store(array $params)
 * @method User update(int $id, array $params)
 * @method User deactivate(int $id)
 * @method User activate(int $id)
 */
interface UserService
{
    /**
     * @param array $params
     *
     * @return User
     */
    public function store(array $params): User;

    /**
     * @param int $id
     * @param array $params
     *
     * @return User
     */
    public function update(int $id, array $params): User;

    /**
     * @param int $id
     */
    public function deactivate(int $id): User;

    /**
     * @param int $id
     */
    public function activate(int $id): User;
}
