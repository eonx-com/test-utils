<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Stubs\Vendor\Illuminate;

use Eonx\TestUtils\Helpers\ApplyFuzziness;
use Eonx\TestUtils\Helpers\Interfaces\ApplyFuzzinessInterface;
use Illuminate\Support\ServiceProvider;
use stdClass;

class ServiceProviderStub extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register(): void
    {
        $this->app->singleton(ApplyFuzzinessInterface::class, ApplyFuzziness::class);
        $this->app->singleton('string', stdClass::class);
        $this->app->bind(stdClass::class);
    }
}
