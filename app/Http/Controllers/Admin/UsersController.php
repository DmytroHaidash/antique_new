<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserSavingRequest;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\MessageBag;
use Illuminate\View\View;

class UsersController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $users = User::latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * @param UserSavingRequest $request
     * @return RedirectResponse
     */
    public function store(UserSavingRequest $request): RedirectResponse
    {
        $attrs = $request->only('name', 'email', 'role');
        $attrs['password'] = Hash::make($request->input('password'));

        $user = User::create($attrs);

        return redirect(route('admin.users.edit', $user))->with('success', new MessageBag(['Пользователь создан.']));
    }

    /**
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * @param UserSavingRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UserSavingRequest $request, User $user): RedirectResponse
    {
        $user->fill($request->only('name', 'email', 'role'));

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return back()->with('success', new MessageBag(['Пользователь обновлен.']));
    }

    /**
     * @param User $user
     * @return RedirectResponse
     * @throws /Exception
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect(route('admin.users.index'))->with('success', new MessageBag(['Пользователь удален.']));
    }
}
