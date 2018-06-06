<?php

namespace Tests\Unit;

use App\Contact;
use Tests\TestCase;
use App\Jobs\CreateContact as Create;
use App\Jobs\UpdateContact as Update;
use App\Jobs\DeleteContact as Delete;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function we_can_create_a_contact(): void
    {
        $this->assertNull(Contact::first());

        $response = Create::dispatchNow('Foo', 'Bar', 'foo@bar.com', '000000000');

        $this->assertInstanceOf(Contact::class, $response);

        $this->assertNotNull($contact = Contact::first());

        $this->assertEquals('Foo', $contact->first_name);
        $this->assertEquals('Bar', $contact->last_name);
        $this->assertEquals('foo@bar.com', $contact->email);
        $this->assertEquals('000000000', $contact->phone);
    }

    /**
     * @test
     */
    public function we_can_update_a_contact(): void
    {
        $old = factory(Contact::class)->create();

        $this->assertNotEquals('Foo', $old->first_name);

        $contact = Update::dispatchNow($old, [
            'first_name' => 'Foo',
        ]);

        $this->assertEquals('Foo', $contact->first_name);
    }

    /**
     * @test
     */
    public function we_can_delete_a_contact(): void
    {
        $this->assertNull(Contact::first());

        Delete::dispatchNow($contact = factory(Contact::class)->create());

        $this->assertNull($contact->fresh());
    }
}
