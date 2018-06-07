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
    public function can_list_all_contacts(): void
    {
        factory(Contact::class, 5)->create();

        $response = $this->getJson(route('contact.index'));
        $response->assertStatus(200);

        $this->assertCount(5, $response->decodeResponseJson());
    }

    /**
     * @test
     */
    public function can_create_a_contact(): void
    {
        $this->assertNull(Contact::first());

        /**
         * First name, last name, email and phone are required.
         */
        $response = $this->postJson(route('contact.store'), [
            //
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'first_name', 'last_name', 'email', 'phone',
            ]);

        /**
         * First name, last name and phone should be string, min length 3 (why not) and max length of 30.
         * Email should be email (makes sense right?).
         */
        $response = $this->postJson(route('contact.store'), [
            'first_name' => false,
            'last_name' => '',
            'phone' => str_pad('', 100, '-'),
            'email' => 'foo@.com',
        ]);

        $payload = [
            'first_name' => 'Foo',
            'last_name' => 'Bar',
            'email' => 'foo@.com',
            'phone' => '+554899999999',
        ];

        $response = $this->postJson(route('contact.store'), $payload);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'email',
            ]);

        $payload['email'] = 'foo@bar.com';

        $response = $this->postJson(route('contact.store'), $payload);
        $response->assertStatus(201)
            ->assertJsonStructure([
                'id', 'first_name', 'last_name', 'created_at', 'updated_at',
            ])
            ->assertJsonFragment([
                'first_name' => 'Foo',
                'last_name' => 'Bar',
                'email' => 'foo@bar.com',
                'phone' => '+554899999999',
            ]);

        $this->assertNotNull($contact = Contact::first());
        $this->assertEquals($response->original->id, $contact->id);
    }

    /**
     * @test
     */
    public function can_update_a_contact(): void
    {
        $contact = factory(Contact::class)->create();

        $response = $this->putJson(route('contact.update', 999));
        $response->assertStatus(404);

        /**
         * Same validation as store, but not required.
         */
        $response = $this->putJson(route('contact.update', $contact), [
            'first_name' => false,
            'last_name' => '',
            'phone' => str_pad('', 100, '-'),
            'email' => 'foo@.com',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'first_name',
                'last_name',
                'phone',
                'email',
            ]);

        $response = $this->putJson(route('contact.update', $contact), [
            //
        ]);
        $response->assertStatus(200);

        $payload = [
            'first_name' => 'Foo',
            'last_name' => 'Bar',
            'phone' => '+5548999999999',
            'email' => 'foo@bar.com',
        ];

        $this->assertNotEquals($payload, $contact->only('first_name', 'last_name', 'phone', 'email'));

        $response = $this->putJson(route('contact.update', $contact), $payload);
        $response->assertStatus(200);

        $this->assertEquals($payload, $contact->fresh()->only('first_name', 'last_name', 'phone', 'email'));
    }

    /**
     * @test
     */
    public function can_delete_a_contact(): void
    {
        $contact = factory(Contact::class)->create();

        $response = $this->deleteJson(route('contact.destroy', 999));
        $response->assertStatus(404);

        $response = $this->deleteJson(route('contact.destroy', $contact));
        $response->assertStatus(200);

        $this->assertNull($contact->fresh());
    }
}
