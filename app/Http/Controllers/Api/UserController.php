<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Criteria;
use App\Models\User_C;
use App\Models\Questions_C;


class UserController extends Controller
{
    // دالة لحساب العمر وتخزين المعايير الخاصة بكل يوزر
    public function calculateAgeAndStoreCriteria(Request $request)
{
    // حساب العمر من تاريخ الميلاد المُرسل في الطلب
    $age = $this->calculateAge($request->birthdate);

    // البحث عن المعيار المحتوي على العمر المحسوب في جدول criteria
    $criteria = Criteria::where('name', $age)
                         ->where(function ($query) use ($request) {
                             $query->where('name', $request->gender)
                                   ->orWhere('name', $request->marital_status);
                         })
                         ->first();

    // التحقق مما إذا كان العثور على المعيار المناسب
    if (!$criteria) {
        return response()->json(['message' => 'No matching criteria found'], 404);
    }

    // تخزين المعايير للمستخدم في جدول user__c_s
    $userCriteria = new User_C(); // إنشاء مثيل جديد من العلاقة بين المستخدم والمعايير
    $userCriteria->user_id = $request->user_id; // تخزين معرف المستخدم
    $userCriteria->criteria_id = $criteria->id; // تخزين معرف المعيار المطابق
    $userCriteria->save(); // حفظ السجل في قاعدة البيانات

    // إرجاع استجابة JSON بنجاح التخزين
    return response()->json(['message' => 'User criteria stored successfully'], 201);
}


     private function calculateAge($birthdate)
{
    // حساب العمر من تاريخ الميلاد
    $birthdate = strtotime($birthdate); // تحويل تاريخ الميلاد إلى نوع زمني
    $today = strtotime('today'); // اليوم الحالي
    $age = floor(($today - $birthdate) / 31556926); // حساب العمر بالسنوات

    // تحديد فئة العمر بناءً على القيم المحددة
    if ($age >= 20 && $age < 30) {
        return '20-29';
    } elseif ($age >= 30 && $age < 40) {
        return '30-39';
    } elseif ($age >= 40 && $age < 50) {
        return '40-49';
    } else {
        return '50+';
    }
}

//=============== دالة لعرض المعايير والأسئلة المرتبطة بها
    public function showUserCriteriaAndQuestions(Request $request)
    {
        // الحصول على المعايير التي حددها المستخدم من جدول الuser_c
        $userCriteria = User_C::where('user_id', $request->user_id)->get();

        // استخراج معرفات المعايير
        $criteriaIds = $userCriteria->pluck('criteria_id')->toArray();

        // البحث عن الأسئلة المرتبطة بالمعايير من جدول الquestions_c
        $questions = Questions_C::whereIn('criteria_id', $criteriaIds)->get();

        return response()->json(['user_criteria' => $userCriteria, 'questions' => $questions], 200);
    }
}









