<html>
    <head>
        <title>Order</title>
        <style type="text/css">
            .detail {font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size: 12px;border-collapse: collapse;}
            .detail th {font-size: 13px;font-weight: normal;padding: 8px;background: #00b065;border-top: 4px solid #aabcfe;border-bottom: 1px solid #fff; color: #039;color:white;}
            .detail tbody td {padding: 8px;background: #f9f9f9;border-bottom: 1px solid #fff;color: #669;border-top: 1px solid transparent;}
            .footer tbody td {padding: 8px;background: white;border-bottom: 1px solid #fff;color: #669;border-top: 1px solid transparent;}
            .detailend {font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size: 12px;border-collapse: collapse;}
            .detailend tbody td {padding: 8px;background: #FFFF00;border-bottom: 1px solid #fff;color: #669;border-top: 1px solid transparent;}
        </style>
    </head>

    <body>
        <table align="center" width="850" align="center" id="main"  border="0" cellspacing="0"cellpadding="0">
            <tr>
                <td><img src="{!!asset('images/logo.png')!!}" width="200px" style="display:block"></td>
                <td align="right">DDS Licensed and Court Approved</td>
            </tr>
            <tr>
                <td colspan="2" align="center" style="background-color:yellow;font-size: 28px;font-weight: bold;padding-top: 10px;padding-bottom: 10px"  valign="bottom">YOUR REGISTRATION WAS SUCCESSFULLY RECEIVED</td>
            </tr>
        </table>

        <br>

        <table class="detail" align="center" width="850" align="center" id="main"  border="0" cellspacing="0"cellpadding="0" > 
            <tr>
                <td width="45%" >Dear {{$name}} {{$last_name}}</td>
                <td><img src="{!!asset('images/email.png')!!}" width="30px" style="display:block"></td>
                <td>Email us: <a href="mailto:info@alfadrivingschool.com">info@alfadrivingschool.com</a></td>
            </tr>
            <tr>
                <td>
                    <p>You did it!!  Now, remember DDS requires all students to complete a 130-question assessment/survey prior to starting class. Assessment take approximately 20-minutes. You may also come prior to your appointment as a walk-in (see office hours below).</p>
                </td>
                <td><img src="{!!asset('images/phone.png')!!}" width="30px" style="display:block"></td>
                <td>Call us @ 770-650-7787 (9am-6pm)</td>
            </tr>
            <tr>
                <td>See registration details below.</td>
                <td><img src="{!!asset('images/operadora.png')!!}" width="30px" style="display:block"></td>
                <td>Chat LIVE with our staff (8am-8pm)</td>
            </tr>
        </table>
        <br>
        <table class="detail" align="center" width="850" align="center" id="main"  border="0" cellspacing="0"cellpadding="0" >
            <tr>
                <td align="center"><h3><u>Assessment Appointment</u></h3></td>
                <td align="center"><h3><u>Class Location</u></h3></td>
            </tr>
            <tr>
                <td align="center">Wednesday, August 16 at 1:00PM<br>@ 1533 Howell Mill Road, Atlanta 30318.</td>
                <td align="center">{{$sche[0]["address"]}}, {{$sche[0]["location"]}} {{$sche[0]["phone"]}}<br>
                    Mon-Fri 9:00AM to 6:00PM and Sat 9:00AM-2:00PM</td>
            </tr>

        </table>
        <br>
        <table class="detail" align="center" width="850" align="center" id="main"  border="0" cellspacing="0"cellpadding="0" >
            <tr>
                <td align="center"><h3><u>Class Schedule</u></h3></td>
            </tr>
            @foreach($sche as $i => $val)
            <tr>
                <td align="center">Day {{($i+1)}} {{$val["dateFormated"]}} .....{{$val["hour"]}} - {{$val["hour_end"]}}</td>
            </tr>
            @endforeach
        </table>
        <br>
        <table class="detailend" align="center" width="850" align="center" id="main"  border="0" cellspacing="0"cellpadding="0" bgcolor="#F4FF77">
            <tr>
                <td colspan="3"><b>OUR STUDENTS KNOW MORE and SAVE MORE $:</b><br>
                    9 out of 10 attorneys recommend completing DUI School, MADD Victim Impact Panel and obtaining an Alcohol Clinical Evaluation may avoid jail time, license suspensions or lower court cost. ALFA is DDS and Court approved.
                </td>
            </tr>
            <tr>
                <td align="center"><b>VICTIM IMPACT PANEL</b></td>
                <td align="center"><b>ALCOHOL CLINICAL EVALUATION</b></td>
                <td align="center"><b>DEFENSIVE DRIVING CLAS</b></td>
            </tr>
            <tr>
                <td align="center"><img src="{!!asset('images/22.png')!!}" width="100px" style="display:block"></td>
                <td align="center"><img src="{!!asset('images/risk%20reduction%20alfa.png')!!}" width="110px" style="display:block"></td>
                <td align="center"><img src="{!!asset('images/adult%20drivers%20training.png')!!}" width="100px" style="display:block"></td>
            </tr>
            <tr>
                <td align="center">2-Hours, Offered Weekly, $50</td>
                <td align="center">30 minutes, by appt, $95-$150</td>
                <td align="center">Lowers 7pts, Lowers Insurance</td>
            </tr>
        </table>

        <br>
        <table align="center" width="850" align="center" id="main"  border="0" cellspacing="0"cellpadding="0" >
            <tr>
                <td align="center">Alfa Driving School</td>
            </tr>
            <tr>
                <td align="center">DDS Licensed, Court Approved</td>
            </tr>
            <tr>
                <td align="center"><a href="http://www.AlfaDrivingSchool.com">www.AlfaDrivingSchool.com</a></td>
            </tr>
        </table>

    </body>
</html>

