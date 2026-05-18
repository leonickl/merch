<?php

namespace App\Controllers;

use App\Enums\MerchStatus;
use App\Enums\Size;
use App\Models\Merch;
use PXP\Http\Controllers\Controller;
use PXP\Http\Response\Redirect;
use PXP\Http\Response\Response;

class MerchController extends Controller
{
    public function index(): Response
    {
        return view('merchs.index', [
            'merchs' => Merch::all(),
        ]);
    }

    public function create(): Response
    {
        return view('merchs.create', [
            'sizes' => Size::all(),
        ]);
    }

    public function store(): Response
    {
        $data = request()->validate(fn ($req) => [
            $req->title->string()->min(3)->max(40),
            $req->sizes->array()->nullable(),
        ]);

        Merch::create(
            title: $data->title,
            sizes: Size::combineValues($data->sizes ?? []),
            status: MerchStatus::ORDERABLE->value,
        );

        return Redirect::route('merchs.index');
    }

    public function setStatus(int $id): Response
    {
        $status = request()->int('status');

        if (! in_array($status, MerchStatus::values())) {
            throw new ValidationException('No valid status given');
        }

        Merch::find($id)->fill(status: $status)->save();

        return Redirect::route('merchs.index');
    }
}
