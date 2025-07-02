<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Ecommerce' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="bg-slate-200 dark:bg-slate-200">
        {{-- Navbar --}}
        @livewire('partials.navbar')

        {{-- Main Content --}}
        <main>
            {{ $slot }}
        </main>

        {{-- Footer --}}
        @livewire('partials.footer')

        @livewireScripts
        <script src="https://unpkg.com/preline@latest/dist/preline.js"></script>
        {{-- SweetAlert2 --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        {{-- Livewire Alert Listener --}}
        <script>
            Livewire.on('swal', (data) => {
                if (Array.isArray(data)) {
                    Swal.fire(data[0]); // ⬅️ Ambil objek pertama dari array
                } else {
                    Swal.fire(data); // fallback
                }
            });

            Livewire.on('swal:confirm', (data) => {
                Swal.fire({
                    title: data.title || 'Apakah Anda yakin?',
                    text: data.text || '',
                    icon: data.icon || 'warning',
                    showCancelButton: true,
                    confirmButtonText: data.confirmButtonText || 'Ya',
                    cancelButtonText: data.cancelButtonText || 'Batal',
                    ...data
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch(data.confirmEvent || 'confirmed');
                    }
                });
            });
        </script>
    </body>
</html>
