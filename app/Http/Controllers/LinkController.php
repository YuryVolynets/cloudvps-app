<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLinkRequest;
use App\Http\Requests\UpdateLinkRequest;
use App\Models\Link;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('links.index', [
            'links' => Link::getLinks(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response([
            'title' => __('links.create_modal_title'),
            'body' => view(
                'links.modalEdit',
                [
                    'action' => route('links.store', absolute: false),
                ]
            )
                ->render(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws ValidationException
     */
    public function store(Request $request): Response
    {
        $validator = Validator::make($request->all(), (new StoreLinkRequest())->rules());
        if ($validator->fails()) {
            return response(
                [
                    'errors' => $validator->errors(),
                ],
                ResponseAlias::HTTP_BAD_REQUEST
            );
        } else {
            Link::storeLink($validator->validated());
            return response([], ResponseAlias::HTTP_OK);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Link $link): Response
    {
        return response([
            'title' => __('links.edit_modal_title'),
            'body' => view(
                'links.modalEdit',
                [
                    'action' => route('links.update', $link, false),
                    'method' => 'PATCH',
                    'link' => $link,
                ]
            )
                ->render(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws ValidationException
     */
    public function update(Request $request, Link $link): Response
    {
        $validator = Validator::make($request->all(), (new UpdateLinkRequest())->rules($link));
        if ($validator->fails()) {
            return response(
                [
                    'errors' => $validator->errors(),
                ],
                ResponseAlias::HTTP_BAD_REQUEST
            );
        } else {
            Link::updateLink($link, $validator->validated());
            return response([], ResponseAlias::HTTP_OK);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link): RedirectResponse
    {
        Link::destroyLink($link);

        return Redirect::route('links.index');
    }

    public function redirect(string $short_url): RedirectResponse
    {
        $link = Link::getLink($short_url);

        if ($link) {
            return Redirect::to(
                $link->incrementCounter()->original_url
            );
        } else {
            abort(404);
        }
    }
}
