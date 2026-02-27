<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Cartelera de cine online: descubre películas, horarios y promociones.')">
    <title>@yield('title', 'Pordede - Plataforma de Cine')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-background font-sans text-foreground antialiased">

    <a href="#contenido-principal" class="fixed left-4 top-2 z-[100] -translate-y-16 rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground transition-transform duration-200 ease-out focus-visible:translate-y-0 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring">
        Saltar al contenido
    </a>

    <x-demo-disclaimer />

    {{-- Navbar --}}
    <nav x-data="{ mobileOpen: false }" class="border-b border-border bg-card/60 backdrop-blur">
        <div class="container flex h-16 items-center justify-between">
            <a href="{{ route('inicio') }}" class="flex items-center gap-2 text-lg font-extrabold tracking-wide text-primary">
                <i class="bi bi-film"></i> PORDEDE
            </a>

            <div class="hidden items-center gap-1 md:flex">
                <x-ui.button href="{{ route('inicio') }}" variant="ghost" size="sm">
                    <i class="bi bi-house"></i> Inicio
                </x-ui.button>

                @auth
                    @if(auth()->user()->admin)
                        <x-ui.dropdown>
                            <x-slot:trigger>
                                <x-ui.button variant="ghost" size="sm" type="button">
                                    <i class="bi bi-gear"></i> Admin <i class="bi bi-chevron-down text-xs"></i>
                                </x-ui.button>
                            </x-slot:trigger>

                            <a href="{{ route('peliculas.index') }}" class="flex items-center gap-2 rounded-sm px-2 py-1.5 text-sm text-popover-foreground transition-colors hover:bg-accent">
                                <i class="bi bi-film"></i> Películas
                            </a>
                            <a href="{{ route('generos.index') }}" class="flex items-center gap-2 rounded-sm px-2 py-1.5 text-sm text-popover-foreground transition-colors hover:bg-accent">
                                <i class="bi bi-tags"></i> Géneros
                            </a>
                            <a href="{{ route('promociones.index') }}" class="flex items-center gap-2 rounded-sm px-2 py-1.5 text-sm text-popover-foreground transition-colors hover:bg-accent">
                                <i class="bi bi-gift"></i> Promociones
                            </a>
                            <div class="my-1 h-px bg-border"></div>
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 rounded-sm px-2 py-1.5 text-sm text-popover-foreground transition-colors hover:bg-accent">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </x-ui.dropdown>
                    @endif
                @endauth
            </div>

            <div class="hidden items-center gap-3 md:flex">
                @auth
                    <span class="text-sm text-warning">
                        <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                    </span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <x-ui.button variant="ghost" size="sm" type="submit">
                            <i class="bi bi-box-arrow-right"></i> Salir
                        </x-ui.button>
                    </form>
                @else
                    <x-ui.button href="{{ route('login') }}" variant="ghost" size="sm">
                        <i class="bi bi-box-arrow-in-right"></i> Ingresar
                    </x-ui.button>
                    <x-ui.button href="{{ route('register') }}" variant="default" size="sm">
                        <i class="bi bi-person-plus"></i> Registrarse
                    </x-ui.button>
                @endauth
            </div>

            <button @click="mobileOpen = !mobileOpen" type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-md text-foreground transition-colors hover:bg-accent md:hidden" aria-label="Abrir menú">
                <i class="bi bi-list text-xl" x-show="!mobileOpen"></i>
                <i class="bi bi-x-lg text-xl" x-show="mobileOpen" x-cloak></i>
            </button>
        </div>

        <div
            x-show="mobileOpen"
            x-cloak
            x-transition:enter="transition-[opacity,transform] duration-200 ease-out"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition-[opacity,transform] duration-150 ease-in-out"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="border-t border-border px-4 pb-4 pt-2 md:hidden"
        >
            <div class="flex flex-col gap-1">
                <x-ui.button href="{{ route('inicio') }}" variant="ghost" size="sm" class="w-full !justify-start">
                    <i class="bi bi-house"></i> Inicio
                </x-ui.button>

                @auth
                    @if(auth()->user()->admin)
                        <x-ui.button href="{{ route('peliculas.index') }}" variant="ghost" size="sm" class="w-full !justify-start"><i class="bi bi-film"></i> Películas</x-ui.button>
                        <x-ui.button href="{{ route('generos.index') }}" variant="ghost" size="sm" class="w-full !justify-start"><i class="bi bi-tags"></i> Géneros</x-ui.button>
                        <x-ui.button href="{{ route('promociones.index') }}" variant="ghost" size="sm" class="w-full !justify-start"><i class="bi bi-gift"></i> Promociones</x-ui.button>
                        <x-ui.button href="{{ route('admin.dashboard') }}" variant="ghost" size="sm" class="w-full !justify-start"><i class="bi bi-speedometer2"></i> Dashboard</x-ui.button>
                    @endif
                    <div class="my-1 h-px bg-border"></div>
                    <span class="px-3 py-1 text-sm text-warning"><i class="bi bi-person-circle"></i> {{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <x-ui.button variant="ghost" size="sm" type="submit" class="w-full !justify-start"><i class="bi bi-box-arrow-right"></i> Salir</x-ui.button>
                    </form>
                @else
                    <x-ui.button href="{{ route('login') }}" variant="ghost" size="sm" class="w-full !justify-start"><i class="bi bi-box-arrow-in-right"></i> Ingresar</x-ui.button>
                    <x-ui.button href="{{ route('register') }}" variant="default" size="sm" class="w-full !justify-start"><i class="bi bi-person-plus"></i> Registrarse</x-ui.button>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Promociones --}}
    @if(isset($promocionesActivas) && $promocionesActivas->count() > 0)
        <div class="container mt-4 flex flex-col gap-3">
            @foreach($promocionesActivas as $promocion)
                <x-ui.alert variant="default">
                    <i class="bi bi-star-fill mt-0.5"></i>
                    <div class="flex-1">
                        <p class="font-semibold">{{ $promocion->titulo }}</p>
                        <p class="mt-0.5 text-foreground/80">{{ $promocion->mensaje }}</p>
                        <p class="mt-1 text-xs text-muted-foreground"><i class="bi bi-clock"></i> Válido hasta {{ $promocion->fecha_fin }}</p>
                    </div>
                    <x-ui.button href="{{ route('inicio') }}" variant="outline" size="sm">
                        Ver películas <i class="bi bi-arrow-right"></i>
                    </x-ui.button>
                </x-ui.alert>
            @endforeach
        </div>
    @endif

    <main id="contenido-principal" class="relative pb-16">
        @yield('content')
    </main>

    <footer class="mt-12 border-t border-border bg-card/40">
        <div class="container flex flex-col items-center justify-between gap-3 py-6 md:flex-row">
            <div>
                <span class="font-extrabold text-primary"><i class="bi bi-film"></i> PORDEDE</span>
                <span class="ml-2 text-sm text-muted-foreground">| Tu cine en casa</span>
            </div>
            <div class="flex items-center gap-4 text-muted-foreground">
                <a href="#" class="transition-colors hover:text-foreground"><i class="bi bi-facebook"></i></a>
                <a href="#" class="transition-colors hover:text-foreground"><i class="bi bi-twitter-x"></i></a>
                <a href="#" class="transition-colors hover:text-foreground"><i class="bi bi-instagram"></i></a>
            </div>
        </div>
        <div class="border-t border-border py-3 text-center text-xs text-muted-foreground">
            &copy; 2026 Pordede. Todos los derechos reservados.
        </div>
    </footer>

</body>
</html>
