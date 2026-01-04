@extends('guest')

@section('content')
<div class="min-h-screen bg-slate-200 py-10">
    <div class="mx-auto max-w-5xl px-4">
        <!-- HERO / JUDUL -->
        <div class="mt-2 rounded-md bg-white px-6 py-14 md:px-10">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold tracking-tight md:text-5xl">
                    Tentang Kami
                </h1>

                <!-- garis bawah judul -->
                <div class="mx-auto mt-6 h-3 w-[60%] rounded bg-slate-200"></div>
            </div>
        </div>

<!-- KONTEN 1 (teks kiri - gambar kanan) -->
<div class="mt-10 rounded-md bg-white p-6 md:p-10">
    <div class="grid gap-10 md:grid-cols-2 md:items-center">

        <!-- TEKS -->
        <div class="space-y-4">
            <p class="text-slate-700 leading-relaxed text-justify">
                Hotel Pantai Indah adalah destinasi penginapan yang mengutamakan kenyamanan, ketenangan, dan pelayanan terbaik bagi setiap tamu. Berlokasi strategis di kawasan pesisir, kami menghadirkan suasana menginap yang menyatu dengan keindahan alam pantai serta keramahan khas Indonesia.

                Sejak awal berdiri, Hotel Pantai Indah berkomitmen untuk memberikan pengalaman menginap yang menyenangkan, baik bagi wisatawan, keluarga, maupun pelaku perjalanan bisnis. Setiap kamar dirancang dengan konsep modern dan fungsional, dilengkapi dengan fasilitas yang mendukung kenyamanan selama menginap.
            </p>
        </div>

        <!-- GAMBAR -->
        <img
            src="{{ asset('images/hotel1.jpg') }}"
            alt="Lobby Hotel Pantai Indah"
            class="mx-auto h-56 w-full max-w-md rounded object-cover shadow-md"
        />

    </div>
</div>

<!-- KONTEN 1 (teks kiri - gambar kanan) -->
<div class="mt-10 rounded-md bg-white p-6 md:p-10">
    <div class="grid gap-10 md:grid-cols-2 md:items-center">

                <!-- GAMBAR -->
        <img
            src="{{ asset('images/hotel1.jpg') }}"
            alt="Lobby Hotel Pantai Indah"
            class="mx-auto h-56 w-full max-w-md rounded object-cover shadow-md"
        />
        <!-- TEKS -->
        <div class="space-y-4">
            <p class="text-slate-700 leading-relaxed text-justify">
                Kami percaya bahwa pelayanan yang baik dimulai dari perhatian terhadap detail. Oleh karena itu, tim kami selalu siap melayani dengan sikap profesional, ramah, dan responsif terhadap kebutuhan tamu. Mulai dari proses pemesanan yang mudah, fasilitas yang terawat, hingga suasana hotel yang aman dan bersih.

                Dengan dukungan sistem pemesanan digital dan QR Code untuk proses check-in, Hotel Pantai Indah terus berinovasi mengikuti perkembangan teknologi demi memberikan kemudahan dan efisiensi bagi para tamu.
            </p>
        </div>



    </div>
</div>

@endsection
