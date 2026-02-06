<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }

        body {
            font-family: "THSarabunNew";
            font-size: 16pt;
            line-height: 1.15;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .school-name {
            font-size: 22pt;
            font-weight: bold;
        }

        .report-title {
            font-size: 18pt;
            font-weight: bold;
            margin-top: 5px;
        }

        .student-info {
            width: 100%;
            margin-bottom: 20px;
        }

        .student-info td {
            padding: 2px 5px;
        }

        .grade-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .grade-table th,
        .grade-table td {
            border: 1px solid black;
            padding: 4px 8px;
            text-align: center;
        }

        .grade-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .text-left {
            text-align: left !important;
        }

        .footer {
            margin-top: 50px;
            width: 100%;
        }

        .signature-box {
            float: right;
            width: 250px;
            text-align: center;
        }

        .signature-line {
            margin-top: 50px;
            border-bottom: 1px solid black;
            width: 100%;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    @foreach($students as $student)
        <div class="{{ !$loop->last ? 'page-break' : '' }}">
            <div class="header">
                <div class="school-name">โรงเรียนเมธีวุฒิกร</div>
                <div class="report-title">ใบรับรองผลการเรียน (Transcript)</div>
            </div>

            <table class="student-info">
                <tr>
                    <td width="15%"><b>ชื่อ-นามสกุล:</b></td>
                    <td width="45%">{{ $student->title_th }}{{ $student->first_name_th }} {{ $student->last_name_th }}</td>
                    <td width="15%"><b>รหัสนักเรียน:</b></td>
                    <td width="25%">{{ $student->student_id }}</td>
                </tr>
                <tr>
                    <td><b>หลักสูตร:</b></td>
                    <td>{{ $student->course->course_name_th ?? $student->course_name }}</td>
                    <td><b>รุ่น/Batch:</b></td>
                    <td>{{ $student->batch }}</td>
                </tr>
            </table>

            @php
                $semesters = $student->grades->groupBy('semester')->sortKeys();
            @endphp

            @foreach($semesters as $semester => $grades)
                <div style="font-weight: bold; margin-bottom: 5px;">ภาคเรียนที่ {{ $semester }}</div>
                <table class="grade-table">
                    <thead>
                        <tr>
                            <th width="15%">รหัสวิชา</th>
                            <th width="55%" class="text-left">ชื่อวิชา</th>
                            <th width="10%">หน่วยกิต</th>
                            <th width="10%">คะแนน</th>
                            <th width="10%">เกรด</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grades as $grade)
                            <tr>
                                <td>{{ $grade->subject->subject_code }}</td>
                                <td class="text-left">{{ $grade->subject->subject_name_th }}</td>
                                <td>{{ $grade->subject->credits }}</td>
                                <td>{{ $grade->score ?? '-' }}</td>
                                <td>{{ $grade->grade ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach

            <div class="footer">
                <div class="signature-box">
                    <p>ลงชื่อ......................................................</p>
                    <p>(นายทะเบียน)</p>
                    <p>วันที่.........เดือน........................พ.ศ. .........</p>
                </div>
            </div>
        </div>
    @endforeach
</body>

</html>