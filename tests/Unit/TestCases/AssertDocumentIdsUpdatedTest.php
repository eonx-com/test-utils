<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\TestCases;

use Eonx\TestUtils\Helpers\SearchClientStub;
use Eonx\TestUtils\TestCases\UnitTestCase;
use LoyaltyCorp\Search\DataTransferObjects\DocumentUpdate;
use PHPUnit\Framework\ExpectationFailedException;

/**
 * @covers \Eonx\TestUtils\TestCases\UnitTestCase::assertDocumentIdsUpdated
 */
class AssertDocumentIdsUpdatedTest extends UnitTestCase
{
    /**
     * Test document ids updated assertion.
     *
     * @return void
     */
    public function testDocumentIdsUpdatedAssertion(): void
    {
        $clientStub = new SearchClientStub();
        $clientStub->bulkUpdate(
            [
                new DocumentUpdate(
                    'transaction', 'trans_id_1', ['key' => 'value']
                ),
                new DocumentUpdate(
                    'transaction', 'trans_id_2', ['key' => 'value']
                )
            ]
        );

        $expected = [
            'transaction' => [
                'trans_id_1',
                'trans_id_2',
            ]
        ];

        self::assertDocumentIdsUpdated($expected, $clientStub);
    }

    /**
     * Test document ids updated assertion fails.
     *
     * @return void
     */
    public function testDocumentIdsUpdatedAssertionFails(): void
    {
        $clientStub = new SearchClientStub();
        $clientStub->bulkUpdate(
            [
                new DocumentUpdate(
                    'transaction', 'trans_id_1', ['key' => 'value']
                ),
                new DocumentUpdate(
                    'transaction', 'trans_id_2', ['key' => 'value']
                )
            ]
        );

        // expected ids in reverse order should fail.
        $expected = [
            'transaction' => [
                'trans_id_2',
                'trans_id_1',
            ]
        ];

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Failed asserting that two arrays are identical');

        self::assertDocumentIdsUpdated($expected, $clientStub);
    }
}
