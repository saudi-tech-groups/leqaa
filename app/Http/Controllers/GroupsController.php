<?php

namespace App\Http\Controllers;

use App\Group;
use App\GroupMembership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class GroupsController extends Controller
{
    public function index()
    {
        $groups = Group::paginate();

        return view('groups.show')
            ->with('groups', $groups);
    }

    public function show(Group $group)
    {
        return view('groups.show')
            ->with('group', $group);
    }

    public function create()
    {
        Gate::authorize('create', \App\Group::class);

        return view('groups.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('create', \App\Group::class);

        $group = new Group();

        $group->name = $request->get('name');
        $group->description = $request->get('description');

        $group->save();

        $group->organizers()->attach(Auth::user()->id);

        GroupMembership::newOwner($group, Auth::user());
    }

    public function remove(Request $request, Group $group)
    {
        Gate::authorize('delete', $group);

        return view('groups.delete')
            ->with('group', $group);
    }

    public function destroy(Request $request, Group $group)
    {
        Gate::authorize('delete', $group);

        $group->delete();

        return redirect()->action('HomeController@index');
    }
}
