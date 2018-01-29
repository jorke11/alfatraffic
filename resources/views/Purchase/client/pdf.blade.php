<html>
    <head>
        <title>Receipt Alfa Driving School</title>
    </head>
    <style>
        body{
            font-size: 11px;
        }
        .space-title{
            width: 350px;
            margin: 0 auto;
        }

        .font-subtitle{
            font-size: 11px;
            font-weight: bold;
            padding-bottom: 15px;
        }
        .font-invoice{
            font-size: 20px;
            font-weight: bold;
            padding-bottom: 15px;
        }
        .font-detail{
            font-size: 12px;
        }
        .font-detail-cont{
            font-size: 12px;
            font-weight: bold;
        }

/*        @font-face {
            font-family: dancing;
            src: url("https://fonts.googleapis.com/css?family=Dancing+Script");
        }


        @font-face {
            font-family: pacifico;
            src: url(https://fonts.googleapis.com/css?family=Pacific);
        }
        @font-face {
            font-family: indie;
            src: url(https://fonts.googleapis.com/css?family=Indie+Flower);
        }*/

        @font-face {
            font-family: tangerine;
            src: url("https://fonts.googleapis.com/css?family=Tangerine");
        }

    </style>
        <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Indie+Flower" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Tangerine" rel="stylesheet">

    <style>
        .pacifico{
            font-family: 'Pacifico', cursive;font-size: 28px
        }
        .indie{
            font-family: 'Indie+Flower', cursive;font-size: 28px
        }
        .dancing{
            font-family: 'Dancing+Script', cursive;font-size: 28px
        }
        .tangerine{
            font-family: 'tangerine', cursive;font-size: 28px
        }
    </style>
   

    <body>

        <table align='left'  width='100%'>
            <tr>
                <td width="10%">
                    <img src="{{url("images/logo100x32.png")}}">
                </td>
                <td align="center"><br><br><br><strong style="font-size: 22px">!!1ALFADRIVINGSCHOOL.COM</strong>
                    <br>www.AlfaDrivingSchool.com<br>
                    8610 Roswell Road • Suite 340 • Atlanta, Georgia 30350 • 770-650-7787
                    <br>
                    <hr>Defensive Driving Student Contract<br>
                    E-mail: info@superfuds.com.co</td>
                <td width="13%">
                    <b style="font-size: 22px">{{$client->id}}</b>
                </td>
            </tr>
        </table>
        <br>
        <br>
        <table width='100%'>
            <tr>
                <td style="font-size: 16px">Name:</td>
                <td style="font-size: 16px" colspan="3"><u>{{$client->last_name}}, {{$client->name}}</u></td>
                <td style="font-size: 16px">Course Date:</td>
                <td style="font-size: 16px"><u>{{$client->date_course}}</u></td>
            </tr>
            <tr>
                <td style="font-size: 16px">Address:</td>
                <td style="font-size: 16px" colspan="3"><u>{{$client->address}}</u></td>
                <td style="font-size: 16px">Course Time:</td>
                <td style="font-size: 16px"><u>9:00 Am - 4:00 Pm</u></td>
            </tr>
            <tr>
                <td style="font-size: 16px">City/State/Zip:</td>
                <td style="font-size: 16px" colspan="3"><u>{{$client->city_id}} {{$client->state_short}}, {{$client->zip_code}}</u></td>
                <td style="font-size: 16px">Course Location</td>
                <td style="font-size: 16px"><u>Sandy Springs: Roswell Rd (974)</u></td>
            </tr>
            <tr>
                <td style="font-size: 16px">Date of Birth:</td>
                <td style="font-size: 16px" colspan="3">{{$client->date_birth}}</td>
                <td colspan="2" style="font-size: 16px"><u>8610 Roswell Rd, Suite 340, Atlanta 30350</u></td>

            </tr>
            <tr>
                <td style="font-size: 16px">Drivers License No:</td>
                <td style="font-size: 16px"><u>{{$client->license}}</u></td>
                <td style="font-size: 16px">State</td>
                <td style="font-size: 16px"><u>{{$client->state_short}}</u></td>
                <td style="font-size: 16px">Course Intent</td>
                <td style="font-size: 16px"><u>Point Reduction</u></td>
            </tr>
            <tr>
                <td style="font-size: 16px">Telephone:</td>
                <td style="font-size: 16px" colspan="3"><u>{{$client->telephone}}</u></td>
                <td style="font-size: 16px">Amount Paid</td>
                <td style="font-size: 16px"><u>$ {{$client->value}}</u></td>
            </tr>
            <tr>
                <td style="font-size: 16px">Email:</td>
                <td style="font-size: 16px" colspan="5"><u>{{$client->email}}</u></td>
            </tr>

        </table>
        <br>
        <br>
        <br>
        <table width='100%'>
            <tr>
                <td>
                    I, the undersigned student, agree to complete the above course, consisting of 1 class(es) 6 hours each, totaling 6 hours of instruction by the above named Driver Improvement Clinic. It is understood that this Clinic is licensed by the Georgia Department of Driver Services (the DDS) in accordance with Georgia Law Title 40-5-80 (DRIVER IMPROVEMENT ACT) and the rules and regulations adopted there under and that each instructor is certified by the DDS. This course is approved by DDS.
                </td>
            </tr>
        </table>
        <br>
        <table width='100%' align="center">
            <tr>
                <td>
                    THE STUDENTS SUCCESSFUL COMPLETION OF ABOVE-NAMED COURSE REQUIRES OF THE FOLLOWING:
                </td>
            </tr>
        </table>
        <br>
        <table width='100%' align="center">
            <tr>
                <td>
                    1) Attendance at all classes sober and free from illicit drugs. 
                </td>
            </tr>
            <tr>
                <td>
                    2) Attendance on time for all sessions.
                </td>
            </tr>
            <tr>
                <td>
                    3) Reasonable attentiveness and participation in all classes.
                </td>
            </tr>
            <tr>
                <td>
                    4) Attendance at all sessions unless medically excused.
                </td>
            </tr>
            <tr>
                <td>
                    5) All sessions must be completed within 60 days.
                </td>
            </tr>
            <tr>
                <td>
                    6) Successfully passing a written or oral examination with a grade of at least 70.
                </td>
            </tr>
            <tr>
                <td>
                    7) To pay course fee prior to start time. Any chargebacks or NSF will be assessed a $35 fee and subject to criminal prosecution.
                </td>
            </tr>
        </table>
        <br>
        <table width='100%' align="center">
            <tr>
                <td>This Driver Improvement Clinic will not refund any tuition or part of tuition if the Clinic is ready, willing, and able to fulfill its part of this contract. I understand that if I fail to comply with the terms and conditions of this agreement, I am in breach of contract and the school will not be under any obligation to fulfill the terms of this contract, and may, at its option, terminate this agreement immediately.</td>
            </tr>
            <tr>
                <td>It is agreed that an owner, instructor, or employee of this Clinic shall not give the impression to a student that upon completion of their instruction; this Clinic will guarantee the securing of a driver’s license to operate a motor vehicle. However, immediately upon the student’s successful completion of the course as described above, the Clinic agrees to provide certification of said completion to the student.</td>
            </tr>
            <tr>
                <td>This Clinic has and will maintain for the protection of the contractual rights of the student a performance bond in the principal sum of ten thousand ($10,000.00) dollars for the students to be written by a company authorized to do business in the State of Georgia.</td>
            </tr>
            <tr>
                <td>This agreement constitutes the contract between the above-named Driver Improvement Clinic and the above-named student and no verbal statements will be recognized.</td>
            </tr>
        </table>
        <br>
        <br>

        <table width='100%' align="center">

            <tr>
                @if($client->type_sign=='digital')
                <td width="50%">
                    @if($client->type_font != '')
                    <span class="{{$client->type_font}}">{{$client->text_sign}}</span>
                     <!--<span class="Tangerine">{{$client->text_sign}}</span>-->
                     <!--<span class="indie">{{$client->text_sign}}</span>-->
                     <!--<span class="dancing">{{$client->text_sign}}</span>-->
                    @else
                    <span style="font-size: 23px">{{$client->text_sign}}</span>
                    @endif
                </td>
                @elseif($client->type_sign=='sign')
                <td width="50%"><img src='{{url($client->img_sign)}}'></td>
                @else
                <td width="50%"></td>
                @endif
                <td width="50%">Firma de Alvaro driving</td>
            </tr>

            <tr>
                <td width="50%">_____________________________________________________________________</td>
                <td width="50%">_____________________________________________________________________</td>
            </tr>
            <tr>
                <td>Signature of Student</td>
                <td>Signature of Authorized Program Official</td>
            </tr>
        </table>
    </body>
</html>




