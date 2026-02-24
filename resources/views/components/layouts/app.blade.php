<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'MEIMS' }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anuphan:wght@100..700&family=Outfit:wght@100..900&display=swap"
        rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-body antialiased bg-slate-50 text-slate-800">
    {{ $slot }}

    @livewireScripts
    <script>
        // Livewire Events
        window.addEventListener('swal:modal', event => {
            Swal.fire({
                title: event.detail[0].title,
                text: event.detail[0].text,
                icon: event.detail[0].type,
                confirmButtonColor: '#3b82f6',
                confirmButtonText: 'ตกลง'
            });
        });

        window.addEventListener('swal:confirm', event => {
            Swal.fire({
                title: event.detail[0].title,
                text: event.detail[0].text,
                icon: event.detail[0].type,
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#d1d5db',
                confirmButtonText: 'ใช่, ลบเลย!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch(event.detail[0].method, { id: event.detail[0].id });
                }
            });
        });

        // Global SweetAlert2 Handling
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Convert native confirm() in forms to SweetAlert2
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                const onsubmitAttr = form.getAttribute('onsubmit');
                if (onsubmitAttr && onsubmitAttr.includes('return confirm(')) {
                    const match = onsubmitAttr.match(/return confirm\(['"](.*?)['"]\)/);
                    if (match) {
                        const message = match[1];
                        form.removeAttribute('onsubmit'); // Remove default confirm
                        form.addEventListener('submit', function (e) {
                            e.preventDefault();
                            Swal.fire({
                                title: 'ยืนยันการทำรายการ?',
                                text: message,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#ef4444',
                                cancelButtonColor: '#94a3b8',
                                confirmButtonText: 'ยืนยัน',
                                cancelButtonText: 'ยกเลิก',
                                reverseButtons: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    form.submit();
                                }
                            });
                        });
                    }
                }
            });

            // 2. Handle Session Flash Messages
            @if(session()->has('success') || session()->has('message'))
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ!',
                    text: "{{ session('success') ?? session('message') }}",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            @endif

            @if(session()->has('error') || $errors->any())
                let errorMessage = "{{ session('error') ?? '' }}";
                @if($errors->any())
                    errorMessage = "{!! implode('\n', $errors->all()) !!}";
                @endif
                
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด!',
                    text: errorMessage,
                    confirmButtonColor: '#ef4444',
                });
            @endif

            @if(session()->has('warning'))
                Swal.fire({
                    icon: 'warning',
                    title: 'คำเตือน!',
                    text: "{{ session('warning') }}",
                    confirmButtonColor: '#f59e0b',
                });
            @endif
        });
    </script>
</body>

</html>