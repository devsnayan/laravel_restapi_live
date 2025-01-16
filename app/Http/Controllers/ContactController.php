<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;

/**
 * @OA\Tag(name="Contacts", description="API Endpoints for Managing Contacts")
 */
class ContactController extends Controller
{
    /**
     * @OA\Get(
     *     path="/contacts",
     *     summary="Retrieve a list of contacts",
     *     tags={"Contacts"},
     *     @OA\Response(
     *         response=200,
     *         description="List of contacts",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Contact")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $contacts = Contact::all();
        return response()->json(ContactResource::collection($contacts), 200);
    }

    /**
     * @OA\Post(
     *     path="/contacts",
     *     summary="Create a new contact",
     *     tags={"Contacts"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ContactRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Contact created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Contact")
     *     )
     * )
     */
    public function store(StoreContactRequest $request)
    {
        $contact = Contact::create($request->validated());
        return response()->json(new ContactResource($contact), 201);
    }

    /**
     * @OA\Get(
     *     path="/contacts/{id}",
     *     summary="Get a specific contact",
     *     tags={"Contacts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the contact",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contact details",
     *         @OA\JsonContent(ref="#/components/schemas/Contact")
     *     )
     * )
     */
    public function show(Contact $contact)
    {
        return response()->json(new ContactResource($contact));
    }

    /**
     * @OA\Put(
     *     path="/contacts/{id}",
     *     summary="Update a specific contact",
     *     tags={"Contacts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the contact",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ContactRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contact updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Contact")
     *     )
     * )
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        $contact->update($request->validated());
        return response()->json(new ContactResource($contact));
    }

    /**
     * @OA\Delete(
     *     path="/contacts/{id}",
     *     summary="Delete a specific contact",
     *     tags={"Contacts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the contact",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Contact deleted successfully"
     *     )
     * )
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return response()->noContent();
    }
}
