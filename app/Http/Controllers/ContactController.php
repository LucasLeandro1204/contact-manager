<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use App\Jobs\CreateContact as Create;
use App\Jobs\UpdateContact as Update;
use App\Jobs\DeleteContact as Delete;

class ContactController extends Controller
{
    /**
     * Return all contacts ordered by name.
     */
    public function index(): Collection
    {
        return Contact::orderBy('name')->get();
    }

    /**
     * Store a new contact.
     */
    public function store(Request $request): JsonResponse
    {
        $data = array_values($request->validate([
            'first_name' => 'required|string|min:3|max:30',
            'last_name' => 'required|string|min:3|max:30',
            'phone' => 'required|string|min:3|max:30',
            'email' => 'required|email',
        ]));

        return JsonResponse::create(Create::dispatchNow(...$data), JsonResponse::HTTP_CREATED);
    }

    /**
     * Update a contact.
     */
    public function update(Contact $contact, Request $request): void
    {
        $data = $request->validate([
            'first_name' => 'string|min:3|max:30',
            'last_name' => 'string|min:3|max:30',
            'phone' => 'string|min:3|max:30',
            'email' => 'email',
        ]);

        Update::dispatchNow($contact, $data);
    }

    /**
     * Delete a contact.
     */
    public function destroy(Contact $contact): void
    {
        Delete::dispatchNow($contact);
    }
}
