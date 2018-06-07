<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ContactController extends Controller
{
    /**
     * Return all contacts ordered by name.
     */
    public function index(): Collection
    {
        return Contact::orderBy('name')->get();
    }
}
