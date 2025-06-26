<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
     public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->get()->groupBy('status');
        return view('dashboard', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required']);
        Task::create([
            'title' => $request->title,
            'status' => 'To Do',
            'user_id' => Auth::id(),
        ]);
        return back();
    }

public function update(Request $request, $id)
{
    $task = Task::findOrFail($id);

    if ($task->user_id !== auth()->id()) {
        return redirect()->route('dashboard')->with('error', 'Unauthorized action.');
    }

    // Agar status update ho raha hai (dropdown se)
    if ($request->has('status')) {
        $request->validate([
            'status' => 'in:To Do,In Progress,Done',
        ]);

        $task->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Task status updated.');
    }

    // Agar title/description update ho raha hai (edit form se)
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $task->update([
        'title' => $request->title,
        'description' => $request->description,
    ]);

    return redirect()->route('dashboard')->with('success', 'Task updated successfully.');
}

       public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard'); // Or wherever
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }   
    public function destroy($id)
{
    $task = Task::findOrFail($id);
    
    // Only allow deletion if the task belongs to the logged-in user
    if ($task->user_id === auth()->id()) {
        $task->delete();
        return redirect()->route('dashboard')->with('success', 'Task deleted successfully.');
    }

    return redirect()->route('dashboard')->with('error', 'Unauthorized action.');
}
public function edit($id)
{
    $task = Task::findOrFail($id);

    if ($task->user_id !== auth()->id()) {
        return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
    }

    return view('tasks.edit', compact('task'));
}
public function register()
{
    return view('auth.register');
}
public function logout()
{
    Auth::logout(); // Laravel's built-in logout method
    return redirect('/login'); // Redirect to login after logout
}
}
