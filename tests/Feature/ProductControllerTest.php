<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * Verifica que solo los productos activos se muestren en el catálogo.
     */
    public function muestra_solo_productos_activos_en_el_catalogo()
    {
        // 🧱 1️⃣ Creamos productos de prueba (3 activos, 2 inactivos)
        $activos = Product::factory()->count(3)->create(['is_active' => true]);
        $inactivos = Product::factory()->count(2)->create(['is_active' => false]);

        // 🚀 2️⃣ Hacemos una solicitud GET al catálogo
        $response = $this->get(route('catalog.index'));

        // ✅ 3️⃣ La respuesta debe ser exitosa (HTTP 200)
        $response->assertStatus(200);

        // 🕵️ 4️⃣ Los productos activos deben aparecer
        foreach ($activos as $producto) {
            $response->assertSee($producto->name);
        }

        // 🚫 5️⃣ Los inactivos NO deben aparecer
        foreach ($inactivos as $producto) {
            $response->assertDontSee($producto->name);
        }
    }

    /**
     * @test
     * Verifica que los filtros de búsqueda funcionen correctamente.
     */
    public function puede_filtrar_por_nombre_o_descripcion()
    {
        // 1️⃣ Creamos productos con nombres distintos
        $zapato = Product::factory()->create(['name' => 'Zapato Funky', 'is_active' => true]);
        $camisa = Product::factory()->create(['name' => 'Camisa Elegante', 'is_active' => true]);

        // 2️⃣ Hacemos la búsqueda por nombre
        $response = $this->get(route('catalog.index', ['search' => 'Zapato']));

        // 3️⃣ Debe ver el zapato pero no la camisa
        $response->assertSee('Zapato Funky');
        $response->assertDontSee('Camisa Elegante');
    }
}
