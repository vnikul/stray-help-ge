<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\PetCategory;
use App\Model\PetCategoryListItem;
use App\Model\PetCategoryListResponse;
use App\Repository\PetCategoryRepository;
use App\Repository\PetRepository;
use App\Service\PetCategoryService;
use Doctrine\Common\Collections\Criteria;
use PHPUnit\Framework\TestCase;

class PetCategoryServiceTest extends TestCase
{

    public function testGetCategories(): void
    {
        $repository = $this->createMock(PetCategoryRepository::class);

        $repository->expects($this->once())
            ->method('findBy')
            ->with([], ['type' => Criteria::ASC])
            ->willReturn(
                [
                    (new PetCategory())
                        ->setType('test')
                        ->setSlug('test-test')
                        ->setId(13)
                ]);

        $service = new PetCategoryService($repository);
        $res = $service->getCategories();

        $expected = new PetCategoryListResponse([new PetCategoryListItem(13, 'test', 'test-test')]) ;
        $this->assertEquals($expected,$res);
    }
}
