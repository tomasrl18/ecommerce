<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug');

            $table->text('description');

            $table->float('price');

            $table->foreignId('subcategory_id')
                ->references('id')
                ->on('subcategories')
                ->onDelete('CASCADE');

            $table->foreignId('brand_id')
                ->references('id')
                ->on('brands')
                ->onDelete('CASCADE');

            $table->integer('quantity')->nullable();

            // 1 = Borrador
            // 2 = Publicado
            $table->enum('status', [Product::BORRADOR, Product::PUBLICADO])->default(Product::BORRADOR);

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
        Schema::dropIfExists('products');
    }
}
