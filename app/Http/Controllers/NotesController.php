<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class NotesController extends Controller
{
    public function notes(Request $req){
        //retornara todas las notas del usuario
        return Note::where('user_id', Auth::user()->id)->get();

    }

    public function createNote(Request $req){

        //validamos la peticion
        $req->validate([
            'title' => 'required|string|min:3|max:250',
            'folder' => 'required|string',
            'note' => 'required||string|min:3',
            'extension' => 'required|alpha|min:2|max:6'
        ]);


        //creamos la nota
        return Note::create([
            'title' => $req->input('title'),
            'folder' => $req->input('folder'),
            'note' => $req->input('note'),
            'extension' => $req->input('extension'),
            'user_id' => Auth::user()->id
        ]);
    }

    public function deleteNote(Request $req){
        //validamos la peticion
        $req->validate([
            'id' => 'required|integer|numeric'
        ]);

        //si la id es valida recuperamos la nota y la borramos
        $note = Note::find($req->input('id'));

        if(!$note || $note->user_id != Auth::user()->id){
            return response([
                "error" => "Note not found or id not valid"
            ]);
        }


        //si la operacion falla, retornamos error
        if(!$note->delete()){
            return response([
                'message' => 'Error deleteing the register'
            ]);
        }

        return response([
            "message"=>"Note deleted succesfully"
        ]);
    }

    public function updateNote(Request $req){

        //validamos los datos
        $req->validate([
            'id' => 'required|integer|numeric',
            'title' => 'required|string|min:3|max:250',
            'folder' => 'required|string',
            'note' => 'required||string|min:3',
            'extension' => 'required|alpha|min:2|max:6'
        ]);

        //recuperamos la nota y en caso de error, retornamos un mensaje de error
        $note = Note::find($req->input('id'));

        if(!$note || $note->user_id != Auth::user()->id){
            return response([
                "error" => "Note not found or id not valid"
            ]);
        }


        //actualizamos el registro en la bbdd
        $note->folder = $req->input('folder');
        $note->title = $req->input('title');
        $note->note = $req->input('note');
        $note->extension = $req->input('extension');

        //si la operacion falla, retornamos error
        if(!$note->save()){
            return response([
                'message' => 'Error updating the database'
            ]);
        }

        return response([
            'message' => 'Success'
        ]);

        
    }


}
