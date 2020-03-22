<?php

namespace App\Http\Controllers\Admin;

use App\Models\Status;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class StatusesController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return \view('admin.statuses.index', [
            'statuses' => Status::paginate(10),
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return \view('admin.statuses.create');
    }

    /**
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        /** @var Status $status */
        $status = Status::create(['title' => $request->input('title')]);

        return redirect()->route('admin.statuses.index');
    }

    /**
     * @param  Status $status
     * @return View
     */
    public function edit(Status $status): View
    {
        return \view('admin.statuses.edit', compact('status'));
    }

    /**
     * @param  Request  $request
     * @param  Status $status
     * @return RedirectResponse
     */
    public function update(Request $request, Status $status): RedirectResponse
    {
        /** @var Status $status */
        $status = $status->update(['title' => $request->input('title')]);

        return redirect()->route('admin.statuses.index');
    }


    /**
     * @param  Status $status
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Status $status): RedirectResponse
    {
        $status->delete();
        return redirect()->route('admin.statuses.index');
    }
}
