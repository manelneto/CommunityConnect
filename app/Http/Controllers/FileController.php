<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    static string $disk = 'CommunityConnect';
    static array $types = [
        'profile' => ['png', 'jpg', 'jpeg'],
        'question' => ['doc', 'pdf', 'txt', 'png', 'jpg', 'jpeg'],
        'answer' => ['doc', 'pdf', 'txt', 'png', 'jpg', 'jpeg']
    ];

    function upload(Request $request, int $id): bool
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

        switch ($type) {
            case 'profile':
                try {
                    $user = User::findOrFail($id);
                    $user->image = "profile/$filename";
                    $user->save();
                } catch (Exception) {
                    return false;
                }
                break;
            case 'question':
                try {
                    $question = Question::findOrFail($id);
                    $question->file = "question/$filename";
                    $question->save();
                } catch (Exception) {
                    return false;
                }
                break;
            case 'answer':
                try {
                    $answer = Answer::findOrFail($id);
                    $answer->file = "answer/$filename";
                    $answer->save();
                } catch (Exception) {
                    return false;
                }
                break;
            default:
                return false;
        }

        $file->storeAs($type, $filename, self::$disk);
        return true;
    }

    public function delete(string $type, int $id): bool
    {
        try {
            if ($type === 'profile' && User::findOrFail($id)?->image !== 'profile/default.png') {
                $user = User::findOrFail($id);
                $filename = $user->image;
                Storage::disk(self::$disk)->delete($filename);
                $user->image = 'profile/default.png';
            } else if ($type === 'question' && Question::findOrFail($id)?->file) {
                $question = Question::findOrFail($id);
                $filename = $question->file;
                Storage::disk(self::$disk)->delete($filename);
                $question->file = null;
            } else if ($type === 'answer' && Answer::findOrFail($id)?->file) {
                $answer = Answer::findOrFail($id);
                $filename = $answer->file;
                Storage::disk(self::$disk)->delete($filename);
                $answer->file = null;
            } else {
                return false;
            }
        } catch (Exception) {
            return false;
        }
        return true;
    }
}
