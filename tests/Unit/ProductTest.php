<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;

class ProductTest extends TestCase
{
    /** @test */
    public function it_creates_a_product_correctly()
    {
        // Crear un producto de prueba
        $product = Product::factory()->create([
            'name' => 'Zapatilla Funky',
            'price' => 299000,
            'stock' => 10,
            'is_active' => true,
        ]);

        // Verificar que se haya creado correctamente
        $this->assertDatabaseHas('products', [
            'name' => 'Zapatilla Funky',
        ]);

        // Verificar campos
        $this->assertEquals(299000, $product->price);
        $this->assertTrue($product->is_active);
    }
}
