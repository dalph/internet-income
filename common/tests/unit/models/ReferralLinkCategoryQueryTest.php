<?php

declare(strict_types = 1);

namespace common\tests\unit\models;

use common\models\ReferralLinkCategory;
use common\models\ReferralLinkCategoryQuery;
use common\enum\ReferralLinkCategoryStatusEnum;
use common\tests\UnitTester;

/**
 * Тестирует методы ReferralLinkCategoryQuery
 */
class ReferralLinkCategoryQueryTest extends \Codeception\Test\Unit
{
    /**
     * @var UnitTester
     */
    protected UnitTester $tester;

    /**
     * Проверяет фильтр active()
     */
    public function testActive()
    {
        $query = new ReferralLinkCategoryQuery(ReferralLinkCategory::class);
        $query->active();
        $where = $query->where;
        $this->assertArrayHasKey('status', $where);
        $this->assertEquals(ReferralLinkCategoryStatusEnum::STATUS_ACTIVE, $where['status']);
    }

    /**
     * Проверяет фильтр inactive()
     */
    public function testInactive()
    {
        $query = new ReferralLinkCategoryQuery(ReferralLinkCategory::class);
        $query->inactive();
        $where = $query->where;
        $this->assertArrayHasKey('status', $where);
        $this->assertEquals(ReferralLinkCategoryStatusEnum::STATUS_INACTIVE, $where['status']);
    }

    /**
     * Проверяет сортировку byPriority()
     */
    public function testByPriority()
    {
        $query = new ReferralLinkCategoryQuery(ReferralLinkCategory::class);
        $query->byPriority();
        $orderBy = $query->orderBy;
        $this->assertArrayHasKey('prior', $orderBy);
        $this->assertEquals(SORT_DESC, $orderBy['prior']);
    }

    /**
     * Проверяет сортировку latest()
     */
    public function testLatest()
    {
        $query = new ReferralLinkCategoryQuery(ReferralLinkCategory::class);
        $query->latest();
        $orderBy = $query->orderBy;
        $this->assertArrayHasKey('created_at', $orderBy);
        $this->assertEquals(SORT_DESC, $orderBy['created_at']);
    }

    /**
     * Проверяет сортировку oldest()
     */
    public function testOldest()
    {
        $query = new ReferralLinkCategoryQuery(ReferralLinkCategory::class);
        $query->oldest();
        $orderBy = $query->orderBy;
        $this->assertArrayHasKey('created_at', $orderBy);
        $this->assertEquals(SORT_ASC, $orderBy['created_at']);
    }

    /**
     * Проверяет фильтр byTitle()
     */
    public function testByTitle()
    {
        $query = new ReferralLinkCategoryQuery(ReferralLinkCategory::class);
        $query->byTitle('Test');
        $where = $query->where;
        $this->assertIsArray($where);
        $this->assertEquals(['like', 'title', 'Test'], $where);
    }
} 