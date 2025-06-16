<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psy\TabCompletion\Matcher\FunctionsMatcher;

class DashboardController extends Controller
{
    public function getStats() {
        $totalStudent = Student::count();
        $maleStudent = Student::where('gender', 'Laki-laki')->count();
        $femaleStudent = Student::where('gender', 'Perempuan')->count();
        $studentsByCity = Student::select('city', DB::raw('count(*) as total'))
            ->groupBy('city')
            ->get();
        $studentsByYear = Student::select(DB::raw('YEAR(born_date) as year'), DB::raw('count(*) as total'))
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();
        
            return response()->json([
                'total_students' => $totalStudent,
                'male_students' => $maleStudent,
                'female_students' => $femaleStudent,
                'students_by_city' => $studentsByCity,
                'students_by_year' => $studentsByYear
            ]);
    }
}
