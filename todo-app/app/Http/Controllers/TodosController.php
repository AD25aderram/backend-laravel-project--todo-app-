<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodosController extends Controller
{
    public function index()
    {
        
        return response()->json(Todo::latest()->get(), 200);
    }

   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'completed'   => 'boolean',
            'priority'    => 'in:low,medium,high',
        ]);

        $todo = Todo::create($validated);

        return response()->json([
            'message' => 'Tâche créée avec succès !',
            'data'    => $todo
        ], 201);
    }

    
    public function show(string $id)
    {
        $todo = Todo::find($id);

        if (!$todo) {
            return response()->json(['message' => 'Tâche non trouvée'], 404);
        }

        return response()->json($todo, 200);
    }

    
    public function update(Request $request, string $id)
    {
        $todo = Todo::find($id);

        if (!$todo) {
            return response()->json(['message' => 'Tâche non trouvée'], 404);
        }

        $validated = $request->validate([
            'title'       => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'completed'   => 'boolean',
            'priority'    => 'in:low,medium,high',
        ]);

        $todo->update($validated);

        return response()->json([
            'message' => 'Tâche mise à jour !',
            'data'    => $todo
        ], 200);
    }

    
    public function destroy(string $id)
    {
        $todo = Todo::find($id);

        if (!$todo) {
            return response()->json(['message' => 'Tâche non trouvée'], 404);
        }

        $todo->delete();

        return response()->json(['message' => 'Tâche supprimée avec succès'], 200);
    }
}
