<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\Helpers;

use Eonx\TestUtils\Helpers\SearchClientStub;
use Eonx\TestUtils\TestCases\UnitTestCase;
use LoyaltyCorp\Search\DataTransferObjects\DocumentUpdate;

/**
 * @covers \Eonx\TestUtils\Helpers\SearchClientStub
 */
class SearchClientStubTest extends UnitTestCase
{
    /**
     * Test creating the stub.
     *
     * @return void
     */
    public function testConstructor(): void
    {
        $client = new SearchClientStub(
            true,
            true,
            ['transaction', 'coupon'],
            [['name' => 'alias1', 'index' => 'index1'], ['name' => 'alias2', 'index' => 'index1']]
        );

        self::assertSame(
            [['name' => 'alias1', 'index' => 'index1'], ['name' => 'alias2', 'index' => 'index1']],
            $client->getAliases()
        );
        self::assertSame(['transaction', 'coupon'], $client->getIndices());
        self::assertTrue($client->isAlias('transaction_123'));
        self::assertTrue($client->isIndex('transaction'));
        self::assertSame(0, $client->count('transaction'));
    }

    /**
     * Test stub captures creating of indices and aliases.
     *
     * @return void
     */
    public function testCreateIndicesAndAliases(): void
    {
        $client = new SearchClientStub();

        $client->createIndex(
            'subscription',
            ['doc' => ['dynamic' => 'strict']],
            ['settings' => 'OK']
        );
        $client->createAlias('subscription', 'subscription_123');

        self::assertSame([
            [
                'name' => 'subscription',
                'mappings' => [
                    'doc' => [
                        'dynamic' => 'strict'
                    ]
                ],
                'settings' => ['settings' => 'OK']
            ]
        ], $client->getCreatedIndices());
        self::assertSame(['subscription_123'], $client->getCreatedAliases());
    }

    /**
     * Test deleting aliases is captured by stub.
     *
     * @return void
     */
    public function testDeletingAliasesAndIndices(): void
    {
        $client = new SearchClientStub();
        $client->deleteIndex('transaction');
        $client->deleteAlias(['transaction_123']);

        self::assertSame(['transaction_123'], $client->getDeletedAliases());
        self::assertSame(['transaction'], $client->getDeletedIndices());
    }

    /**
     * Test swapping aliases is captured by stub.
     *
     * @return void
     */
    public function testMovingAlias(): void
    {
        $client = new SearchClientStub();

        $client->moveAlias(
            [
                ['index' => 'tran', 'alias' => 'tran_123'],
                ['index' => 'coupon', 'alias' => 'coupon_123']
            ]
        );

        self::assertSame([
            'tran_123' => 'tran',
            'coupon_123' => 'coupon'
        ], $client->getSwappedAliases());
    }

    /**
     * Test created and updated indices can be reset for testing purposes.
     *
     * @return void
     */
    public function testResettingIndices(): void
    {
        $client = new SearchClientStub();
        $client->createIndex(
            'subscription',
            ['doc' => ['dynamic' => 'strict']],
            ['settings' => 'OK']
        );
        $client->createAlias('subscription', 'subscription_123');
        $client->moveAlias(
            [
                ['index' => 'tran', 'alias' => 'tran_123'],
                ['index' => 'coupon', 'alias' => 'coupon_123']
            ]
        );
        $client->bulkUpdate([
            new DocumentUpdate(
                'transaction',
                'trans_id_1',
                ['key' => 'value']
            )
        ]);
        $client->deleteIndex('transaction');
        $client->deleteAlias(['transaction_123']);

        $client->reset();

        self::assertSame([], $client->getIndices());
        self::assertSame([], $client->getAliases());
        self::assertSame([], $client->getCreatedIndices());
        self::assertSame([], $client->getCreatedAliases());
        self::assertSame([], $client->getSwappedAliases());
        self::assertSame([], $client->getDeletedIndices());
        self::assertSame([], $client->getDeletedAliases());
    }

    /**
     * Test stub captures updating indices.
     *
     * @return void
     */
    public function testUpdateIndices(): void
    {
        $client = new SearchClientStub();

        $update = new DocumentUpdate(
            'transaction',
            'trans_id_1',
            ['key' => 'value']
        );
        $client->bulkUpdate([$update]);

        self::assertSame([[$update]], $client->getUpdatedIndices());
    }
}
