<?php

namespace Tests\Feature;

use App\Note;
use App\Contact;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NoteControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_create_a_note(): void
    {
        $contact = factory(Contact::class)->create();

        $this->assertNull(Note::first());

        /**
         * Contact id is required, but not validated.
         * Description is required and must have min 3 length and max of 180.
         */
        $response = $this->postJson(route('note.store'), [
            //
        ]);
        $response->assertStatus(404);

        $response = $this->postJson(route('note.store'), [
            'contact_id' => 999, // invalid contact
        ]);
        $response->assertStatus(404);

        $response = $this->postJson(route('note.store'), [
            'description' => '',
            'contact_id' => $contact->id,
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'description',
            ]);

        $response = $this->postJson(route('note.store'), [
            'contact_id' => $contact->id,
            'description' => 'Some random description',
        ]);
        $response->assertStatus(201)
            ->assertJsonStructure([
                'id', 'contact_id', 'description', 'created_at', 'updated_at',
            ])
            ->assertJsonFragment([
                'contact_id' => $contact->id,
                'description' => 'Some random description',
            ]);

        $this->assertNotNull($contact = Contact::first());
        $this->assertEquals($response->original->id, $contact->id);
    }

    /**
     * @test
     */
    public function can_update_a_note(): void
    {
        $note = factory(Note::class)->create();

        $response = $this->putJson(route('note.update', 999));
        $response->assertStatus(404);

        /**
         * Same validation as store, but not required.
         */
        $response = $this->putJson(route('note.update', $note), [
            'description' => '',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'description',
            ]);

        $response = $this->putJson(route('note.update', $note), [
            //
        ]);
        $response->assertStatus(200);

        $this->assertNotEquals('Some random description', $note->description);

        $response = $this->putJson(route('note.update', $note), [
            'description' => 'Some random description',
        ]);
        $response->assertStatus(200);

        $this->assertEquals('Some random description', $note->fresh()->description);
    }

    /**
     * @test
     */
    public function can_delete_a_note(): void
    {
        $note = factory(Note::class)->create();

        $response = $this->deleteJson(route('note.destroy', 999));
        $response->assertStatus(404);

        $response = $this->deleteJson(route('note.destroy', $note));
        $response->assertStatus(200);

        $this->assertNull($note->fresh());
    }
}
