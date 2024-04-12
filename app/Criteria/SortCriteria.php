<?php

namespace App\Criteria;

use App\Exceptions\InvalidArgumentException;
use Illuminate\Support\Str;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class AccountCriteria.
 *
 * @package namespace App\Criteria;
 */
abstract class SortCriteria extends Criteria implements CriteriaInterface
{
    protected static array $accepts = [];

    protected array $params = [];
    protected string $delimiter = ':';
    protected string $paramName = 'sort';
    protected string|array $default = '';

    public function __construct(array $params, array $options = [])
    {
        $this->params = $params;

        if (isset($options['delimiter'])) {
            $this->delimiter = $options['delimiter'];
        }

        if (isset($options['param_name'])) {
            $this->paramName = $options['param_name'];
        }
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
        $sorts = $this->params[$this->paramName] ?? [];

        if (!is_array($sorts)) {
            $sorts = [$sorts];
        }

        if (empty($sorts) && !empty($this->default)) {
            $sorts = (array) $this->default;
        }

        foreach (array_reverse($sorts) as $sort) {
            [$column, $direction] = $this->parseParams($sort);
            $model = $this->applySort($model, $column, $direction);
        }

        return $model;
    }

    /**
     * @param mixed $model
     * @param string $column
     * @param string $direction
     *
     * @return mixed
     */
    protected function applySort($model, string $column, string $direction)
    {
        return $model->orderBy($column, $direction);
    }

    /**
     * @param string $value
     *
     * @return array|null
     */
    protected function parseParams(string $value)
    {
        if (!in_array($value, static::getAcceptableValues())) {
            throw new InvalidArgumentException("`{$value}` is not acceptable.");
        }

        [$column, $direction] = explode($this->delimiter, $value);

        $direction = Str::upper($direction);

        if (!in_array($direction, ['ASC', 'DESC'])) {
            throw new InvalidArgumentException("`{$direction}` is invalid value for direction");
        }

        return [$column, $direction];
    }

    /**
     * @return array
     */
    public static function getAcceptableValues(): array
    {
        return array_merge(...array_map(
            fn ($direction) => array_map(
                fn ($target) => "{$target}:{$direction}",
                static::$accepts
            ),
            ['asc', 'desc']
        ));
    }
}
