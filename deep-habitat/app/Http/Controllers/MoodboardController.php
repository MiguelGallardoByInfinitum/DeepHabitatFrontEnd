<?php

namespace App\Http\Controllers;

use App\Models\Moodboard;

class MoodboardController extends Controller
{
    public function mostrarMoodboards()
    {
        $moodboards = Moodboard::all();
        return view('moodboard', ['moodboards' => $moodboards]);
    }

    public function insertarMoodboard($title, $moodboardId)
    {
        
        $moodboard = new Moodboard();
        $moodboard->title = $title;
        $moodboard->moodboard_id = $moodboardId;
        

        $moodboard->save();

        return redirect('/moodboard');
    }
}

?>