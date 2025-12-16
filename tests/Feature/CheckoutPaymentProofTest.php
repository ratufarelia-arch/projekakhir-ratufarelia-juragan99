<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;


class CheckoutPaymentProofTest extends TestCase
{
    use RefreshDatabase;

    public function test_uploading_payment_proof_stores_file_on_order(): void
    {
        Storage::fake('public');

        $product = Product::create([
            'name' => 'Test Product',
            'slug' => 'test-product',
            'price' => 250000,
            'stock' => 10,
        ]);

        $cartEntries = [
            'entry-1' => [
                'product_id' => $product->id,
                'quantity' => 1,
                'unit_price' => 250000,
                'weight_in_kg' => 1,
                'weight_label' => '1 kg',
            ],
        ];

        $proof = UploadedFile::fake()->image('proof.jpg');

        $response = $this->withSession(['cart' => $cartEntries])
            ->post(route('shop.checkout.store'), [
                'customer_name' => 'Test Customer',
                'customer_email' => 'customer@example.com',
                'customer_address' => 'Jl Test',
                'payment_proof' => $proof,
            ]);

        $response->assertRedirect(route('shop.checkout.index'));

        $order = Order::first();
        $this->assertNotNull($order);

        $orderItem = $order->items()->first();
        $this->assertNotNull($orderItem);
        $this->assertNotNull($order->payment_proof);
        $this->assertNull($orderItem->payment_proof);

       Storage::fake('public');


    }
}