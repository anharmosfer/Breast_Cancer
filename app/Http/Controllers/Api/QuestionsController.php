<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuestionsRequest;
use Illuminate\Http\Request;
use App\Models\Questions;

class QuestionsController extends Controller
{
    public function store(StoreQuestionsRequest $request)
    {
        $validatedData = $request->validated();

        $question = new Questions([
            'name' => $validatedData['name'],
            'gender' => json_encode($validatedData['gender']),
            'marital_status' => json_encode($validatedData['marital_status']),
            'birthdate' => json_encode($validatedData['birthdate']),
            'rate' => $validatedData['rate'],
        ]);

        $question->save();

        return response()->json(['message' => 'Question created successfully'], 201);
    }
}
