<nav x-data="{ open: false }" class="sticky top-0 z-40 border-b border-slate-200 bg-white/90 backdrop-blur">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex items-center gap-4 lg:gap-8">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <x-application-mark class="size-10" />
                    <span class="hidden text-base font-bold text-slate-950 sm:block">InfraWatch</span>
                </a>

                <div class="hidden items-center gap-1 sm:flex">
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>
                    <x-nav-link href="{{ route('monitors.index') }}" :active="request()->routeIs('monitors.*')">
                        Monitoramentos
                    </x-nav-link>
                    <x-nav-link href="{{ route('incidents.index') }}" :active="request()->routeIs('incidents.*')">
                        Incidentes
                    </x-nav-link>
                    <x-nav-link href="{{ route('settings.alerts') }}" :active="request()->routeIs('settings.*')">
                        Alertas
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:gap-4">
                <a href="{{ route('monitors.create') }}" class="hidden rounded-lg bg-slate-950 px-3 py-2 text-xs font-semibold text-white transition hover:bg-slate-800 lg:inline-flex">
                    Novo monitor
                </a>

                <div class="rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                    Sistema online
                </div>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-3 rounded-full border border-slate-200 bg-white py-1 pe-3 ps-1 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                            <img class="size-9 rounded-full object-cover ring-2 ring-teal-100" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                            <span class="max-w-36 truncate">{{ Auth::user()->name }}</span>
                            <svg class="size-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3">
                            <div class="text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</div>
                            <div class="truncate text-xs text-slate-500">{{ Auth::user()->email }}</div>
                        </div>

                        <div class="border-t border-slate-100"></div>

                        <x-dropdown-link href="{{ route('profile.show') }}">
                            Perfil
                        </x-dropdown-link>

                        <x-dropdown-link href="{{ route('settings.alerts') }}">
                            Canais de alerta
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf

                            <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                Sair
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700 focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden border-t border-slate-200 bg-white sm:hidden">
        <div class="space-y-1 px-2 pb-3 pt-2">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('monitors.index') }}" :active="request()->routeIs('monitors.*')">
                Monitoramentos
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('incidents.index') }}" :active="request()->routeIs('incidents.*')">
                Incidentes
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('settings.alerts') }}" :active="request()->routeIs('settings.*')">
                Alertas
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('monitors.create') }}">
                Novo monitor
            </x-responsive-nav-link>
        </div>

        <div class="border-t border-slate-200 pb-3 pt-4">
            <div class="flex items-center px-4">
                <img class="me-3 size-11 rounded-full object-cover ring-2 ring-teal-100" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />

                <div class="min-w-0">
                    <div class="truncate text-base font-semibold text-slate-900">{{ Auth::user()->name }}</div>
                    <div class="truncate text-sm text-slate-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    Perfil
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        Sair
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
