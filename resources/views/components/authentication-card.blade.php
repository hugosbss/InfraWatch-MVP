<div class="min-h-screen flex flex-col justify-center items-center px-4 py-8 bg-[radial-gradient(circle_at_top_left,_#ccfbf1,_transparent_32%),linear-gradient(135deg,_#f8fafc,_#e2e8f0)]">
    <div class="mb-6">
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md overflow-hidden rounded-2xl border border-white/70 bg-white/90 px-6 py-6 shadow-xl shadow-slate-200/70 backdrop-blur">
        {{ $slot }}
    </div>
</div>
