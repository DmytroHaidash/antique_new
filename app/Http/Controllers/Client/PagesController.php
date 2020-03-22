<?php

namespace App\Http\Controllers\Client;

use App\Mail\AskQuestion;
use App\Mail\Order;
use App\Models\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class PagesController extends Controller
{
    public function show(Page $page, Page $subpage = null): View
    {
        if ($subpage) {
            $page = $subpage;
        }

        return view('client.pages.default', compact('page'));
    }

    public function question(Request $request): RedirectResponse
    {
        $data = [
            'user' => (object)$request->only('name', 'phone', 'email'),
            'message' => $request->input('message'),
        ];
        Mail::send(new AskQuestion($data));

        return redirect()->route('client.index');
    }

    public function order(Request $request)
    {
        $data = [
            'user' => (object)$request->only('name', 'phone', 'email'),
        ];
        Mail::send(new Order($data));
        return redirect()->route('client.index');
    }
}
