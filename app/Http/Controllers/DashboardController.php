<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Admin;
use App\Models\Course;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{

    public function departmentData()
    {
        $data = [
            [
                'name' => 'COMPUTER ENGINEERING', 
                'image' => 'department/COT Buea people.jpg', 
                'description' => '',
                'slogan' => 'CET',
                'options' => json_encode([
                    [
                        ['id' => 1, 'name' => 'first year undergraduate - BTech'],
                        ['id' => 2, 'name' => 'third year undergraduate - BTech'],
                        ['id' => 3, 'name' => 'Post Graduate (Masters) - MTech'],
                    ],
                    [
                        'degree' => [
                            [
                                'id' => 1, 
                                'name' => 'SOFTWARE', 
                                'description' => '',
                                'image' => 'department/COT Buea people.jpg'
                            ],
                            [
                                'id' => 2, 
                                'name' => 'NETWORK',
                                'description' => '',
                                'image' => 'department/COT Buea people.jpg'
                            ],
                            [
                                'id' => 3, 
                                'name' => 'DATA SCIENCE',
                                'description' => '',
                                'image' => 'department/COT Buea people.jpg'
                            ],
                        ],
                        'masters' => [
                            [
                                'id' => 1, 
                                'name' => 'SOFTWARE', 
                                'description' => '',
                                'image' => 'department/COT Buea people.jpg'
                            ],
                            [
                                'id' => 2, 
                                'name' => 'NETWORK',
                                'description' => '',
                                'image' => 'department/COT Buea people.jpg'
                            ],
                        ],
                    ]
                ])
            ],
            [
                'name' => 'ELECTRICAL AND ELECTRONIC ENGINEERING', 
                'image' => 'department/COT Buea people.jpg', 
                'description' => '',
                'slogan' => 'EET',
                'options' => json_encode([
                    [
                        ['id' => 1, 'name' => 'first year undergraduate - BTech'],
                        ['id' => 2, 'name' => 'third year undergraduate - BTech'],
                        ['id' => 3, 'name' => 'Post Graduate (Masters) - MTech'],
                    ],
                    [
                        'degree' => [
                            [
                                'id' => 1, 
                                'name' => 'ELECTRIC POWER SYSTEM', 
                                'description' => '',
                                'image' => 'department/COT Buea people.jpg'
                            ],
                            [
                                'id' => 2, 
                                'name' => 'TELECOMMUNICATION',
                                'description' => '',
                                'image' => 'department/COT Buea people.jpg'
                            ],
                        ],
                        'masters' => [
                            [
                                'id' => 1, 
                                'name' => 'ELECTRIC POWER SYSTEM', 
                                'description' => '',
                                'image' => 'department/COT Buea people.jpg'
                            ],
                            [
                                'id' => 2, 
                                'name' => 'TELECOMMUNICATION AND NETWORK',
                                'description' => '',
                                'image' => 'department/COT Buea people.jpg'
                            ],
                        ],
                    ]
                ])
            ],
            [
                'name' => 'MECHANICAL ENGINEERING', 
                'image' => 'department/COT Buea people.jpg', 
                'slogan' => 'MET',
                'description' => '',
                'options' => json_encode([
                    [
                        ['id' => 1, 'name' => 'first year undergraduate - BTech'],
                        ['id' => 2, 'name' => 'third year undergraduate - BTech'],
                        ['id' => 3, 'name' => 'Post Graduate (Masters) - MTech'],
                    ],
                    [
                        'degree' => [
                            [
                                'id' => 1, 
                                'name' => 'COASTAL AND HABOUR ENGINEERING', 
                                'description' => '',
                                'image' => 'department/COT Buea people.jpg'
                            ],
                            [
                                'id' => 2, 
                                'name' => 'MANUFACTURING ENGINEERING',
                                'description' => '',
                                'image' => 'department/COT Buea people.jpg'
                            ],
                            [
                                'id' => 3, 
                                'name' => 'MECHANTRONICS',
                                'description' => '',
                                'image' => 'department/COT Buea people.jpg'
                            ],
                            [
                                'id' => 4, 
                                'name' => 'AUTOMOBILE',
                                'description' => '',
                                'image' => 'department/COT Buea people.jpg'
                            ],
                        ],
                        'masters' => [
                            [
                                'id' => 1, 
                                'name' => 'MECHANTRONICS', 
                                'description' => '',
                                'image' => 'department/COT Buea people.jpg'
                            ],
                            [
                                'id' => 2, 
                                'name' => 'THERMOFLUID',
                                'description' => '',
                                'image' => 'department/COT Buea people.jpg'
                            ],
                            [
                                'id' => 3, 
                                'name' => 'MECHANICAL FABRICATION',
                                'description' => '',
                                'image' => 'department/COT Buea people.jpg'
                            ],
                            [
                                'id' => 4, 
                                'name' => 'STRUCTURAL AND MECHANICAL CONSTRUCTION',
                                'description' => '',
                                'image' => 'department/COT Buea people.jpg'
                            ],
                        ],
                    ]
                ])
            ],
        ];

        return Department::insert($data);
    }

    public function checkPassword(Request $request)
    {
        $data = $request->validate([
            'password' => 'required|string'
        ]); 
        $admin = Admin::all()[0];   
        if (Hash::check($data['password'], $admin->password)) {
            return response([]);
        } 
        return response([], 401);
    }

    public function departments()
    {
        return Department::all(['id', 'name', 'image', 'description', 'slogan']);
    }
    
    public function dept_options($id)
    {
        $dept = Department::find($id);
        return json_decode($dept->options);
    }

    public function store_UB_Requirements()
    {
        $courses = [
            [
                'course_code' => 'FRE101', 
                'course_title' => 'FUNCTIONAL FRENCH I', 
                'credit_value' => 2,
                'course_master' => 'Mrs FIOBA',
                'semester' => 1
            ],
            [
                'course_code' => 'FRE102', 
                'course_title' => 'FUNCTIONAL FRENCH II', 
                'credit_value' => 2,
                'course_master' => 'Mrs FIOBA',
                'semester' => 2
            ],
            [
                'course_code' => 'ENG101', 
                'course_title' => 'USE OF ENGLISH I', 
                'credit_value' => 2,
                'course_master' => 'Mr JOHN',
                'semester' => 1
            ],
            [
                'course_code' => 'ENG102', 
                'course_title' => 'USE OF ENGLISH II', 
                'credit_value' => 2,
                'course_master' => 'Mr JOHN',
                'semester' => 2
            ],
            [
                'course_code' => 'CVE100', 
                'course_title' => 'CIVICS AND ETHICS', 
                'credit_value' => 4,
                'course_master' => 'Mrs SOFIE EKUME',
            ],
            [
                'course_code' => 'SPT100', 
                'course_title' => 'SPORTS', 
                'credit_value' => 2,
                'course_master' => 'LUCAS ONANA',
            ],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
        return;
    }
}
