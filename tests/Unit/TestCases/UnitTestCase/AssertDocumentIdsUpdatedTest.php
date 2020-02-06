<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\TestCases\UnitTestCase;

use Eonx\TestUtils\Stubs\Eonx\Search\SearchClientStub;
use Eonx\TestUtils\TestCases\UnitTestCase;
use LoyaltyCorp\Search\DataTransferObjects\DocumentUpdate;
use LoyaltyCorp\Search\DataTransferObjects\IndexAction;
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
        $clientStub->bulk(
            [
                new IndexAction(
                    new DocumentUpdate('trans_id_1', ['key' => 'value']),
                    'transaction'
                ),
                new IndexAction(
                    new DocumentUpdate('trans_id_2', ['key' => 'value']),
                    'transaction'
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
        $clientStub->bulk(
            [
                new IndexAction(
                    new DocumentUpdate('trans_id_1', ['key' => 'value']),
                    'transaction'
                ),
                new IndexAction(
                    new DocumentUpdate('trans_id_2', ['key' => 'value']),
                    'transaction'
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
