<?php

namespace App\Extensions;


use App\Criteria\CriteriaInterface;
use App\Exceptions\ModelDoesNotExistException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class AbstractRepository
{
    /**
     * @var Builder
     */
    protected $query;

    /**
     * AbstractRepository constructor.
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * @return Builder
     */
    abstract protected function newQuery(): Builder;

    /**
     * @return AbstractRepository
     */
    public function reset(): self
    {
        $this->query = $this->newQuery();

        return $this;
    }

    /**
     * @param $relation
     * @param \Closure|null $callback
     * @param string $operator
     * @param int $count
     * @return AbstractRepository
     */
    public function whereHas($relation, \Closure $callback = null, $operator = '>=', $count = 1): self
    {
        $this->query->whereHas($relation, $callback, $operator, $count);

        return $this;
    }

    /**
     * @param int $id
     * @return AbstractRepository
     */
    public function find(int $id): self
    {
        $this->query->find($id);

        return $this;
    }

    /**
     * @return Model|null
     */
    public function getOne(): ?Model
    {
        $result = $this->query->first();
        $this->reset();

        return $result;
    }

    /**
     * @param int $id
     * @return Model|null
     * @throws ModelDoesNotExistException
     */
    public function findOneAndCheckIfExists(int $id): ?Model
    {
        $result = $this->find($id)->getOne();

        if (!$result) {
            throw new ModelDoesNotExistException();
        }

        return $result;

    }


    /**
     * @param string $field
     * @return array
     */
    public function getAllGroupedBy(string $field): array
    {
        $result = $this->query
            ->get()
            ->map(function ($item) {
                return (array)$item;
            })
            ->groupBy($field)
            ->map(function ($collection) {
                return $collection->all();
            })
            ->all();
        $this->reset();
        return $result;
    }


    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        $results = $this->query->get();
        $this->reset();

        return $results;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        $result = $this->query->count();
        $this->reset();
        return $result;
    }

    /**
     * @param string $field
     * @return array
     */
    public function getCountsGroupedBy(string $field): array
    {
        $result = $this->query
            ->select($field . ' as key')
            ->selectRaw('COUNT(*) as count')
            ->groupBy($field)
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->key => $item->count];
            })->all();
        $this->reset();
        return $result;
    }

    /**
     * @param int $limit
     * @return AbstractRepository
     */
    public function take(int $limit): self
    {
        $this->query->take($limit);
        return $this;
    }

    /**
     * @param int $skip
     * @return AbstractRepository
     */
    public function skip(int $skip): self
    {
        $this->query->skip($skip);
        return $this;
    }

    /**
     * @param CriteriaInterface $criteria
     * @param mixed ...$params
     * @return AbstractRepository
     */
    public function pushCriteria(CriteriaInterface $criteria, ...$params): self
    {
        $this->query = $criteria->apply($this->query, ...$params);

        return $this;
    }

    /**
     * @param $relations
     * @return $this
     */
    public function with($relations): self
    {
        $this->query->with($relations);

        return $this;
    }

    /**
     * @param array $data
     * @return Builder|Model
     */
    public function create(array $data)
    {
        $school = $this->query->create($data);
        $this->reset();

        return $school;
    }


    /**
     * @param string|array|\Closure $column
     * @param null $operator
     * @param null $value
     * @return AbstractRepository
     */
    protected function where($column, $operator = null, $value = null): self
    {
        $this->query->orWhere($column, $operator, $value);

        return $this;
    }
}
