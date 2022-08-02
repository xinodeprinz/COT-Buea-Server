<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\PublishResult;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function store()
    {
        $current_semester = 1;
        $current_academic_year = '2021/2022';
        $data = json_encode([
            'semesters' => [
                [ 'id' => 1, 'name' => 'first semester' ],
                [ 'id' => 2, 'name' => 'second semester' ],
                [ 'id' => 3, 'name' => 'first semester resit' ],
                [ 'id' => 4, 'name' => 'second semester resit' ],
            ],
            'levels' => [
                '200', '300', '400', '500', '600', '700', '800',
            ],
            'academic_years' => [
                '2020/2021', '2021/2022', '2022/2023', '2023/2024', '2024/2025',
                '2025/2026', '2026/2027', '2027/2028', '2028/2029', '2029/2030',
                '2030/2031', '2031/2032', '2032/2033', '2033/2034', '2034/2035',
                '2035/2036', '2036/2037', '2037/2038', '2038/2039', '2039/2040',
                '2040/2041', '2041/2042', '2042/2043', '2043/2044', '2044/2045',
                '2045/2046', '2046/2047', '2047/2048', '2048/2049', '2049/2050',
            ],
        ]);

        $fee_types = json_encode([
            [ 'id' => 1, 'name' => 'tuition (school) fee', 'amount' => 60000 ],
            [ 'id' => 2, 'name' => 'medical fee', 'amount' => 5000 ],
        ]);

        $to_store = [
            'current_semester' => $current_semester,
            'current_academic_year' => $current_academic_year,
            'data' => $data,
            'password' => Hash::make('00000'),
            'fee_types' => $fee_types
        ];

        return Admin::create($to_store);
    }

    public function get()
    {
        $encoded_data = Admin::all(['id', 'current_semester', 'current_academic_year', 'data'])[0];
        $encoded_data->data = json_decode($encoded_data->data);
        return response($encoded_data);
    }

    public function update(Request $request) 
    {
        $request->validate([
            'semester' => 'required|string',
            'academic_year' => 'required|string',
        ]);

        $data = Admin::all()[0];
        $cur_arr = explode('/', $data->current_academic_year);
        $ex_arr = explode('/', $request->academic_year);

        if ($ex_arr[0] == $cur_arr[0]) { //&& $request->semester > $data->current_semester
            $data->current_semester = $request->semester;
            return $data->update();
        }
        if ($ex_arr[0] > $cur_arr[0]) {
            $data->current_semester = $request->semester;
            $data->current_academic_year = $request->academic_year;
            // Updating students class
            $students = User::all();
            foreach ($students as $student) {
                if ($student->level < 400 && !$student->has_graduated) {
                    $student->level += 100;
                    $student->update();
                } else if ($student->level == 400 && !$student->has_graduated) {
                    $student->level += 50;
                    $student->update();
                }
            }
            return $data->update();
        }
        return response(0, 400);
    }

    public function publishResults(Request $request)
    {
        $request->validate([
            'semester' => 'required',
            'academic_year' => 'required|string'
        ]);
        $semester = $request->semester;
        $academic_year = $request->academic_year;
        $sem_text = '';
        if ($semester == 1) {
            $sem_text = 'first semester';
        } else if ($semester == 2) {
            $sem_text = 'second semester';
        } else if ($semester == 3) {
            $sem_text = 'first semester resit';
        } else {
            $sem_text = 'second semester resit';
        }
        if (
            PublishResult::where('semester', $semester)
            ->where('academic_year', $academic_year)
            ->exists()
        ) {
            return response("The exam results for $academic_year $sem_text have already been published", 401);
        }

        PublishResult::create([
            'semester' => $semester,
            'academic_year' => $academic_year
        ]);

        return;
    }

    public function check_if_results_have_been_published()
    {
        $semester = request()->query('semester');
        $academic_year = request()->query('academic_year');
        $sem_text = '';
        if ($semester == 1) {
            $sem_text = 'first semester';
        } else if ($semester == 2) {
            $sem_text = 'second semester';
        } else if ($semester == 3) {
            $sem_text = 'first semester resit';
        } else {
            $sem_text = 'second semester resit';
        }
        if (
            PublishResult::where('semester', $semester)
            ->where('academic_year', $academic_year)
            ->exists()
        ) {
            return response("The exam results for $academic_year $sem_text have already been published", 401);
        }
        return;
    }
}
