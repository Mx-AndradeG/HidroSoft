<?php

namespace App\Providers;

use App\Models\Categories\Category;
use App\Models\Customer\Customer;
use App\Models\Payments\Payments\Payment;
use App\Models\Products\Product;
use App\Models\Supplier\Supplier;
use App\Observers\CategoryObserver;
use App\Observers\CustomerObserver;
use App\Observers\PaymentObserver;
use App\Observers\ProductObserver;
use App\Observers\SupplierObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Category::observe(CategoryObserver::class);
        Customer::observe(CustomerObserver::class);
        Supplier::observe(SupplierObserver::class);
        Product::observe(ProductObserver::class);
        Payment::observe(PaymentObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
