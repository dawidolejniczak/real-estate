<?php

use App\Extensions\AbstractRepository;
use Illuminate\Database\Eloquent\Builder;
use Mockery\MockInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Criteria\CriteriaInterface;

final class AbstractRepositoryTest extends \Tests\TestCase
{

    public function testGetOne(): void
    {
        $queryMock = $this->_getQueryMock();
        $queryMock
            ->shouldReceive('first')
            ->once()
            ->andReturn(\Mockery::mock(Model::class))
            ->ordered()
            ->getMock();

        $repository = $this->_getRepositoryMock($queryMock);

        $result = $repository->getOne();
        $this->assertInstanceOf(Model::class, $result);
    }


    public function testGetAll(): void
    {
        $queryMock = $this->_getQueryMock();
        $queryMock
            ->shouldReceive('get')
            ->once()
            ->andReturn(\Mockery::mock(Collection::class))
            ->ordered()
            ->getMock();

        $repository = $this->_getRepositoryMock($queryMock);

        $result = $repository->getAll();
        $this->assertInstanceOf(Collection::class, $result);
    }

    public function testPushCriteria(): void
    {
        $repository = $this->_getRepositoryMock($this->_getQueryMock());
        $criteria = Mockery::mock(CriteriaInterface::class)
            ->shouldReceive('apply')
            ->once()
            ->getMock();

        $repository->pushCriteria($criteria);
    }


    /**
     * @param MockInterface $queryMock
     * @return MockInterface
     */
    private function _getRepositoryMock(MockInterface $queryMock): MockInterface
    {
        $mock = \Mockery::mock(AbstractRepository::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods()
            ->shouldReceive('newQuery')
            ->andReturn($queryMock)
            ->getMock();

        $mock->reset();
        return $mock;
    }

    /**
     * @return MockInterface
     */
    private function _getQueryMock(): MockInterface
    {
        return Mockery::mock(Builder::class);
    }
}