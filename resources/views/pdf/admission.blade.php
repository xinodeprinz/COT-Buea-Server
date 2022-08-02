<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admission Letter - COT</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif }
        #head {
            display: flex;
            align-items: center;
            text-transform: uppercase;
            font-weight: bold;
        }
        .ndetek {}
        #logo {
            margin-left: 290px;
            margin-top: 0;
        }
        .cameroon {
            text-align: right;
        }
        #head h3, hr, #dynamic h2 { color: #0354ac }
        .break { margin-top: -160px }
        #student-info { display: flex }
        .right { text-align: right }
        .uppercase { text-transform: uppercase; color: #0354ac }
        .y { margin-top: -145px }
        #dynamic h2 { text-transform: uppercase; text-align: center }
        p, li { line-height: 2em; font-size: 18px; text-align: justify }
        .stamp { margin-top: -50px; text-align: right }
        .stamp h4 { margin-top: -20px; font-style: italic }
    </style>
</head>
<body>
    <div id="head">
        <div class="ndetek">
            <h3>COLLEGE OF TECHNOLOGY</h3>
            <h5>TRAIN LOCALLY, QUALIFY GLOBALLY</h5>
        </div>
        <div>
            <img id="logo" src="{{ storage_path('app/public').'/images/COT logo.jpg' }}" alt="" class="img-fluid" width="120">
        </div>
        <div class="cameroon">
            <h3>Republic of Cameroon</h3>
            <h5>Peace-Work-Fatherland</h5>
        </div>
    </div><hr class="break">
    {{-- Students section --}}
    <section id="student-info">
        <div class="left">
            <h4>Name: <strong class="uppercase">{{ $name }}</strong></h4>
            <h4>Date of Birth: <strong class="uppercase">{{ $date_of_birth }}</strong></h4>
            <h4>Matricule: <strong class="uppercase">{{ $matricule }}</strong></h4>
        </div>
        <div class="right">
            <h4>Department: <strong class="uppercase">{{ $department }}</strong></h4>
            <h4>Option: <strong class="uppercase">{{ $option }} - {{ $cert }}</strong></h4>
            <h4>Admitted Date: <strong class="uppercase">{{ $admitted_on }}</strong></h4>
        </div>
    </section> <hr class="y">

    {{-- Dynamic section --}}
    <div id="dynamic">
        <h2>Admission Letter</h2>
        <h4>Dear Mr/Mrs/Miss <strong class="uppercase">{{ $name }}</strong></h4>
        <p>
            We are pleased to offer you a place to study for a {{ strtolower($cert) == 'btech' ? 'Barchelors' : 'Masters' }} programme in
            <span class="uppercase">{{ $option }}</span> at the department of
            <span class="uppercase">{{ $department }}</span> at the College of Technology (COT), 
            University of Buea. You have been issued the matriculation number 
            <span class="uppercase">{{ $matricule }}</span>.
        </p>
        <p>
            The academic activites of this College are being run by the institution's online platform,
            and it helps facilites both students and administrators in the aspects of: 
            <ul>
                <li>Payment of school fee</li>
                <li>Course Registration by students</li>
                <li>Uploading of departmental courses</li>
                <li>Publication of students examination marks</li>
                <li>Registration of courses by students</li>
            </ul>
        </p>
    </div>
    {{-- Stamp section --}}
    <div class="stamp">
        <img width="250" class="img-fluid" src="{{ storage_path('app/public').'/images/signed_stamp.jpg' }}" alt="">
        <h4 class="uppercase">The Registrar</h4>
    </div>
</body>
</html>