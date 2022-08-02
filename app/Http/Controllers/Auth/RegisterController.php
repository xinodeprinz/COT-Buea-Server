<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Department;
use App\Models\Admin;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use App\Mail\Gmail;
use Illuminate\Support\Facades\Mail;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => ['required', 'string'],
            'lastname' => ['required', 'string'],
            'date_of_birth' => ['required', 'date'],
            'place_of_birth' => ['required', 'string'],
            'country' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
            'region' => ['required', 'string'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['firstname'].' '. $data['lastname'],
            'date_of_birth' => $data['date_of_birth'],
            'place_of_birth' => $data['date_of_birth'],
            'country' => $data['country'],
            'gender' => $data['gender'],
            'phone_number' => $data['phone_number'],
            'region' => $data['region'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function login()
    {
        $data = request()->validate([
            'matricule' => 'required|string',
            'password' => 'required|string'
        ]);
        $student = User::where('matricule', $data['matricule'])->first();
        $academics = Admin::all(['current_semester', 'current_academic_year'])[0];
        if($student && Hash::check($data['password'], $student->password)){
            $student->date_of_birth = date('jS\ F Y', strtotime($student->date_of_birth));
            $student->registered_date = date('jS\ F Y', strtotime($student->registered_date));
            $dept = Department::where('name', $student->department)->first();
            return response([
                'message' => 'Login Successful',
                'token' => $student->createToken(time())->plainTextToken,
                'student' => $student,
                'academics' => $academics,
                'dept_id' => $dept->id
            ]);
        } else {
            return response(['message' => "The credentials you've provided seem to be invalid."], 401);
        }
    }
    public function register(Request $request)
    {
        $request->validate([
            'fatherName' => 'required|string',
            'motherName' => 'required|string',
            'fatherContact' => 'required|string|size:9',
            'motherContact' => 'required|string|size:9',
            'parentAddress' => 'required|string',
            'imageUrl' => 'required|image',
            'birthCertificate' => 'required|file',
            'gce_ol' => 'required|file',
            'gce_al' => 'required|file'
        ]);
        
        $password = 12345;//self::password();
        $current_year = date('Y');
        $rand_str = self::rand_str();
        $name = $request->firstName.' '. $request->lastName;
        $student = new User();
        $student->name = ucwords(strtolower($name));
        $student->matricule = self::matricule();
        $student->email = $request->email;
        $student->level = $request->level;
        $student->date_of_birth = $request->dateOfBirth;
        $student->sub_division = ucwords(strtolower($request->subDivision));
        $student->place_of_birth = ucwords(strtolower($request->placeOfBirth));
        $student->phone_number = $request->phoneNumber;
        $student->gender = ucwords(strtolower($request->gender));
        $student->region = ucwords(strtolower($request->region));
        $student->father_name = ucwords(strtolower($request->fatherName));
        $student->mother_name = ucwords(strtolower($request->motherName));
        $student->father_contact = $request->fatherContact;
        $student->mother_contact = $request->motherContact;
        $student->parent_address = ucwords(strtolower($request->parentAddress));
        $student->department = ucwords(strtolower($request->department));
        $student->option = ucwords(strtolower($request->option));
        $student->certificate = $request->certificate;
        $student->has_graduated = false;
        $student->image_url =  $request->file('imageUrl')->store("student_profiles/$current_year", 'public');
        $student->birth_certificate =  $request->file('birthCertificate')->storeAs("birth_certificates/$current_year", "$rand_str".'_'."$name.pdf");
        $student->gce_ol =  $request->file('gce_ol')->storeAs("gce_ol/$current_year", "$rand_str".'_'."$name.pdf");
        $student->gce_al =  $request->file('gce_al')->storeAs("gce_al/$current_year", "$rand_str".'_'."$name.pdf");
        $student->password = Hash::make($password);
        $student->passed_concour = false;
        $student->registered_date = date('Y-m-d H:i:s', strtotime($request->registered_on));
        $student->save();

        //Emailing the user // to be commented without internet connection
        // $details = [
        //     'matricule' => $student->matricule,
        //     'password' => $password,
        //     'option' => $student->option,
        //     'department' => $student->department,
        //     'name' => $student->name,
        //     'date_of_birth' =>$student->date_of_birth,
        //     'url' => env('APP_URL'). "/api/pdf/registration-receipt/$student->matricule"
        // ];
        // $gmail = new Gmail($details);
        // Mail::to($request->email)->send($gmail);
        // End of comment
        return response($student->matricule);
    }

    public function validateStudentInfo(Request $request)
    {
        return $request->validate([
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email',
            'subDivision' => 'required|string',
            'dateOfBirth' => 'required|date',
            'placeOfBirth' => 'required|string',
            'phoneNumber' => 'required|size:9',
            'gender' => 'required|string',
            'region' => 'required|string'
        ]);
    }

    private static function password()
    {
        $string = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!@#$%^&*()_+=-";
        $password = '';
        for ($i = 0; $i < rand(5, 8); $i++) {
            $index = rand(0, strlen($string) - 1);
            $password .= $string[$index];
        }
        return $password;
    }

    private static function rand_str()
    {
        $string = "0123456789";
        $str = '';
        for ($i = 0; $i < 3; $i++) {
            $index = rand(0, strlen($string) - 1);
            $str .= $string[$index];
        }
        return $str;
    }

    private static function matricule()
    {
        $matricule = 'CT' . date('y') . 'A';
        $count = User::where('matricule', 'like', "$matricule%")->count();
        $count += 1;
        if ($count < 10) {
            $matricule .= "00$count"; 
        } else if ($count < 100) {
            $matricule .= "0$count"; 
        } else {
            $matricule .= $count;
        }
        return $matricule;
    }
}
