<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    static $disk = 'CommunityConnect';
    static $types = [
        'profile' => ['png', 'jpg', 'jpeg'],
        'question' => ['doc', 'pdf', 'txt', 'png', 'jpg', 'jpeg'],
    ];

    function upload(Request $request, int $id)
    {
        $type = $request->type;
        if (!$request->hasFile('file') || !array_key_exists($type, self::$types)) {
            return false;
        }

        $file = $request->file('file');
        $extension = $file->extension();
        if (!in_array(strtolower($extension), self::$types[$type])) {
            return false;
        }

        $this->delete($type, $id);
        $filename = $file->hashName();

        if ($type === 'profile') {
            try {
                $user = User::findOrFail($id);
                $user->image = "profile/$filename";
                $user->save();
            } catch (ModelNotFoundException $e) {
                return "User not found";
            }
        } else if ($type === 'question') {
            try {
                $question = Question::findOrFail($id);
                $question->file = "question/$filename";
                $question->save();
            } catch (ModelNotFoundException $e) {
                return "Question not found";
            }
        } else {
            return false;
        }

        $file->storeAs($type, $filename, self::$disk);
        return true;
    }

    private static function delete(string $type, int $id)
    {
        if ($type === 'profile' && User::find($id)->image !== 'profile/default.png') {
            $filename = User::find($id)->image;
            Storage::disk(self::$disk)->delete($filename);
            User::find($id)->image = 'profile/default.png';
        } else if ($type === 'question' && Question::find($id)->file) {
            $filename = Question::find($id)->file;
            Storage::disk(self::$disk)->delete($filename);
            Question::find($id)->file = null;
        } else {
            return false;
        }
        return true;
    }
}
