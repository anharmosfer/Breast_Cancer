<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Criteria;
use App\Models\User_C;
use App\Models\Questions_C;


class UserController extends Controller
{


     // Function to show questions based on user criteria
     public function showQuestions(Request $request)
     {
         // Retrieve user criteria from the request
         $criteria = $request->only(['gender', 'marital_status', 'birthdate']);

         // Retrieve questions based on user criteria
         $questions = Questions::where('gender', $criteria['gender'])
                               ->where('marital_status', $criteria['marital_status'])
                               ->where('birthdate', $criteria['birthdate'])
                               ->get();

         // Return the questions as a JSON response
         return response()->json($questions);
     }
}








