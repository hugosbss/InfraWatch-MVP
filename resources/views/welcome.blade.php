<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'InfraWatch') }}</title>

        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-100 font-sans text-slate-900 antialiased">
        <main class="min-h-screen">
            <section class="flex min-h-screen items-center bg-[linear-gradient(135deg,_#f8fafc_0%,_#dbeafe_45%,_#ccfbf1_100%)] px-4 py-8">
                <div class="mx-auto grid w-full max-w-7xl gap-8 lg:grid-cols-[.95fr_1.05fr] lg:items-center">
                    <div>
                        <a href="/" class="inline-flex items-center gap-3">
                            <x-application-mark class="size-12" />
                            <span class="text-xl font-bold text-slate-950">InfraWatch</span>
                        </a>

                        <div class="mt-10 max-w-2xl">
                            <p class="text-sm font-bold uppercase text-teal-700">MVP SaaS de monitoramento</p>
                            <h1 class="mt-4 text-4xl font-bold leading-tight text-slate-950 sm:text-5xl">InfraWatch</h1>
                            <p class="mt-5 text-lg leading-8 text-slate-700">
                                Plataforma simples para pequenas empresas acompanharem disponibilidade, incidentes e alertas sem depender de ferramentas complexas.
                            </p>
                        </div>

                        @if (Route::has('login'))
                            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center rounded-lg bg-slate-950 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-slate-300 transition hover:bg-slate-800">
                                        Abrir dashboard
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-lg bg-slate-950 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-slate-300 transition hover:bg-slate-800">
                                        Entrar
                                    </a>

                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white/80 px-5 py-3 text-sm font-bold text-slate-800 shadow-sm transition hover:bg-white">
                                            Criar conta
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>

                    <div class="rounded-lg border border-white/70 bg-white/85 p-4 shadow-2xl shadow-slate-300/60 backdrop-blur">
                        <div class="rounded-lg border border-slate-200 bg-slate-950 p-4 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-teal-300">Status geral</p>
                                    <p class="mt-1 text-2xl font-bold">Operacional</p>
                                </div>
                                <span class="rounded-full bg-emerald-400/15 px-3 py-1 text-sm font-bold text-emerald-300">99.98%</span>
                            </div>

                            <div class="mt-6 grid gap-3 sm:grid-cols-3">
                                <div class="rounded-lg bg-white/10 p-4">
                                    <p class="text-xs text-slate-300">Sites</p>
                                    <p class="mt-2 text-2xl font-bold">12</p>
                                </div>
                                <div class="rounded-lg bg-white/10 p-4">
                                    <p class="text-xs text-slate-300">Alertas</p>
                                    <p class="mt-2 text-2xl font-bold">0</p>
                                </div>
                                <div class="rounded-lg bg-white/10 p-4">
                                    <p class="text-xs text-slate-300">Latencia</p>
                                    <p class="mt-2 text-2xl font-bold">142ms</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 space-y-3">
                            <div class="flex items-center justify-between rounded-lg border border-slate-200 bg-white p-4">
                                <div>
                                    <p class="font-semibold text-slate-950">https://empresa.com.br</p>
                                    <p class="text-sm text-slate-500">HTTP monitor</p>
                                </div>
                                <span class="rounded-full bg-emerald-50 px-3 py-1 text-sm font-bold text-emerald-700">online</span>
                            </div>
                            <div class="flex items-center justify-between rounded-lg border border-slate-200 bg-white p-4">
                                <div>
                                    <p class="font-semibold text-slate-950">https://api.empresa.com</p>
                                    <p class="text-sm text-slate-500">API monitor</p>
                                </div>
                                <span class="rounded-full bg-amber-50 px-3 py-1 text-sm font-bold text-amber-700">watching</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>
