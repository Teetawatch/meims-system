<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>รายงานข้อมูลนักเรียน</title>
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
            font-family: "THSarabunNew", "Sarabun", sans-serif;
            font-size: 16pt;
            line-height: 1.2;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .title {
            font-size: 20pt;
            font-weight: bold;
        }

        .subtitle {
            font-size: 16pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 5px;
            font-size: 14pt;
        }

        th {
            background-color: #f0f0f0;
            text-align: center;
            font-weight: bold;
        }

        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }

        .filters {
            margin-bottom: 10px;
            font-size: 14pt;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">รายงานข้อมูลนักเรียน</div>
        <div class="subtitle">โรงเรียนเมธีวุฒิกร</div>
        <div class="subtitle">วันที่พิมพ์: {{ \Carbon\Carbon::now()->addYears(543)->format('d/m/Y H:i') }} น.</div>
    </div>

    <div class="filters">
        <b>เงื่อนไข:</b> 
        ปีงบประมาณ: {{ $fiscal_year ?: 'ทั้งหมด' }} | 
        รุ่น: {{ $batch ? 'รุ่น '.$batch : 'ทั้งหมด' }} | 
        หลักสูตร: {{ $course_name ?: 'ทั้งหมด' }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">ลำดับ</th>
                <th style="width: 15%">รหัสนักเรียน</th>
                <th style="width: 25%">ชื่อ - สกุล</th>
                <th style="width: 20%">หลักสูตร</th>
                <th style="width: 10%">รุ่น</th>
                <th style="width: 10%">ปีงบฯ</th>
                <th style="width: 15%">สถานะ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $index => $student)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $student->student_id }}</td>
                    <td>{{ $student->title_th }}{{ $student->first_name_th }} {{ $student->last_name_th }}</td>
                    <td>{{ $student->course_name }}</td>
                    <td class="text-center">{{ $student->batch }}</td>
                    <td class="text-center">{{ $student->fiscal_year }}</td>
                    <td class="text-center">ปกติ</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
