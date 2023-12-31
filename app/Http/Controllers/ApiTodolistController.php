<?php

namespace App\Http\Controllers;

use App\Models\Todolist;
use Illuminate\Http\Request;

class ApiTodolistController extends Controller
{
    public function getList()
    {
        $result = Todolist::orderBy('created_at', 'desc');
        if (\request('search')) {
            $result = $result->where("content", "like", "%" . request('search') . "%");
        }

        $result = $result->get();

        return response()->json($result);
    }



    public function show($id)
    {
        $result = Todolist::findOrFail($id);
        return response()->json($result);
    }
    public function postCreate(Request $request)
    {
        Todolist::create([
            'content' => $request->content
        ]);

        return response()->json(['status' => true, 'message' => 'data berhasil ditambahkan!']);
    }

    public function postUpdate(Request $request, $id)
    {

        Todolist::where('id', $id)->update([
            'content' => $request->content,
        ]);
        return response()->json(['status' => true, 'message' => 'data berhasil diupdate!']);
    }

    public function postDelete($id)
    {
        Todolist::find($id)->delete();

        return response()->json(['status' => true, 'message' => 'data berhasil Dihapus!']);
    }
}
