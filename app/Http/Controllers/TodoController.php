<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoCreateRequest;
use App\Http\Requests\TodoUpdateRequest;
use App\Models\Todo;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Resources\TodoResource;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->query('limit') ?? 10;
        $search = $request->query('search') ?? '';

        $todos = TodoResource::collection(
            Todo::with(['user'])
                ->where(function ($query) use ($search) {
                    $query->where('todo', 'like', "%$search%");
                })
                ->latest()
                ->paginate($limit)
        );

        return Inertia::render('Todo/Index', [
            'todos' => $todos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Todo/Form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TodoCreateRequest $request)
    {
        $data = $request->only('todo', 'description', 'status');

        Todo::create([
            ...$data,
            'user_id' => Auth::user()->id
        ]);

        return to_route('todo-task.index')->with([
            'message' => 'Created sucessfully',
            'status' => 'created'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo_task)
    {
        $todo = $todo_task;

        return Inertia::render('Todo/Form', [
            'data' => $todo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TodoUpdateRequest $request, Todo $todo_task)
    {
        $todo_task->update([
            ...$request->toArray(),
            'user_id' => Auth::user()->id
        ]);

        return to_route('todo-task.index')->with([
            'message' => 'Updated sucessfully',
            'status' => 'updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo_task)
    {
        $todo_task->delete();

        return to_route('todo-task.index')->with([
            'message' => 'Deleted sucessfully',
            'status' => 'deleted'
        ]);
    }
}
