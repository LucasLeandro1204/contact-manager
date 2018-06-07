<?php

namespace Tests\Feature;

use App\Contact;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_list_contacts()
    {
        factory(Contact::class, 5)->create();

        $response = $this->getJson(route('contact.index'));
        $response->assertStatus(200);

        $this->assertCount(5, $response->decodeResponseJson());
    }
}
