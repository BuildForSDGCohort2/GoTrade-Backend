<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesV1 extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 128)->unique();
            $table->timestamps();
        });

        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name', 128);
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')
                ->references('id')
                ->on('countries');
            $table->timestamps();
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 128);
            $table->unsignedBigInteger('state_id');
            $table->foreign('state_id')
                ->references('id')
                ->on('states');
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('display_name', 32);
            $table->string('first_name', 32);
            $table->string('last_name', 32)->nullable();
            $table->string('mobile_number', 32)->unique();
            $table->date('date_of_bith')->nullable();
            $table->string('email',128)->unique();
            $table->text('address')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onDelete('set null');
            $table->unsignedBigInteger('state_id')->nullable();
            $table->foreign('state_id')
                ->references('id')
                ->on('states')
                ->onDelete('set null');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')
                ->references('id')
                ->on('cities')
                ->onDelete('set null');
            $table->enum('gender', [
                'male',
                'female'
            ])->nullable();
            $table->unsignedBigInteger('photo_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_active');
            $table->boolean('is_online')->default(0);
            $table->enum('role', [
                'admin',
                'trader',
                'customer'
            ]);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email',128)->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 32)->unique();
            $table->string('slug', 128)->unique();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('product_group_names', function (Blueprint $table) {
            $table->id();
            $table->string('name', 32)->unique();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 32);
            $table->string('sku', 32)->unique();
            $table->string('slug', 128)->unique();
            $table->decimal('amount', 32, 2);
            $table->decimal('discount', 5, 2)->default(0);
            $table->integer('quantity')->default(0);
            $table->text('short_description');
            $table->longText('long_description');
            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')
                ->references('id')
                ->on('product_categories');
            $table->unsignedBigInteger('own_by');
            $table->foreign('own_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('product_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->unsignedBigInteger('group_id');
            $table->foreign('group_id')
                ->references('id')
                ->on('product_group_names')
                ->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('product_medias', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_default')->default(0);
            $table->unsignedBigInteger('file_id');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('stars')->default(1);
            $table->text('review')->nullable();
            $table->unsignedBigInteger('posted_by');
            $table->foreign('posted_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 32, 2);
            $table->integer('quantity')->default(1);
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->unsignedBigInteger('own_by');
            $table->foreign('own_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('order_no')->unique();
            $table->text('address');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onDelete('set null');
            $table->unsignedBigInteger('state_id')->nullable();
            $table->foreign('state_id')
                ->references('id')
                ->on('states')
                ->onDelete('set null');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')
                ->references('id')
                ->on('cities')
                ->onDelete('set null');
            $table->unsignedBigInteger('own_by');
            $table->foreign('own_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->ipAddress('ip_address');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 32, 2);
            $table->integer('quantity')->default(1);
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->uuid('transaction_no')->unique();
            $table->decimal('amount', 32, 2);
            $table->json('response')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('set null');
            $table->tinyInteger('status')->default(0);
            $table->ipAddress('ip_address');
            $table->timestamps();
        });

        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->string('name', 32);
            $table->string('email', 128);
            $table->string('mobile_number', 16);
            $table->string('subject', 16);
            $table->text('body');
            $table->ipAddress('ip_address');
            $table->boolean('is_read')->default(0);
            $table->timestamps();
        });

        Schema::create('storage_files', function (Blueprint $table) {
            $table->id();
            $table->enum('file_type', [
                'image',
                'video'
            ]);
            $table->string('file_name', 32);
            $table->string('file_extension', 128);
            $table->string('file_mime', 128);
            $table->timestamps();
        });

        // alter tables - add references
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('photo_id')
                ->references('id')
                ->on('storage_files')
                ->onDelete('cascade');
        });

        Schema::table('product_medias', function (Blueprint $table) {
            $table->foreign('file_id')
                ->references('id')
                ->on('storage_files')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('failed_jobs');
    }
}
