<?php

use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\Customer\Customer;
use App\Models\PaymentMethod\PaymentMethod;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Branch::class);
            $table->foreignIdFor(Customer::class)->nullable();
            $table->foreignIdFor(PaymentMethod::class);
            $table->decimal('total_sale', 10,2);
            $table->decimal('received_amount', 10,2);
            $table->string('reference_code')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
};
