<x-guest-layout>
    <div class="relative mx-auto flex min-h-screen max-w-6xl items-center justify-center p-5 sm:p-8">
        <div class="lms-auth-card grid w-full max-w-5xl overflow-hidden lg:grid-cols-[1.05fr_0.95fr]">
            <div class="lms-illustration relative hidden p-10 text-white lg:flex lg:flex-col lg:justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white/20 backdrop-blur-sm">
                        <i class="fa-solid fa-graduation-cap text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.28em] text-indigo-100">Student LMS</p>
                        <h2 class="mt-1 text-2xl font-bold">Welcome back</h2>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <p class="text-sm uppercase tracking-[0.24em] text-indigo-100/80">Your learning journey</p>
                        <h1 class="mt-3 max-w-sm text-4xl font-black leading-tight">Keep learning. Keep growing.</h1>
                    </div>

                    <div class="rounded-2xl border border-white/15 bg-white/10 p-5 backdrop-blur-sm">
                        <p class="text-sm text-indigo-100/80">Access all your courses, saved lessons, and recent progress in one place.</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 text-sm text-indigo-100/90">
                    <span class="inline-flex h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                    Secure access for every learner
                </div>
            </div>

            <div class="bg-white/80 p-7 sm:p-10 lg:p-12">
                <div class="mb-8 text-center lg:text-left">
                    <span class="inline-flex items-center rounded-full border border-indigo-100 bg-indigo-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.22em] text-indigo-600">Sign in</span>
                    <h3 class="mt-5 text-3xl font-bold tracking-tight text-slate-900">Login to your account</h3>
                    <p class="mt-2 text-sm text-slate-500">Enter your details to continue learning.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-slate-700" />
                        <x-text-input id="email" class="lms-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-slate-700" />
                        <x-text-input id="password" class="lms-input" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between gap-3 pt-1">
                        <label for="remember_me" class="inline-flex items-center gap-3">
                            <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                            <span class="text-sm text-slate-600">{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="lms-muted-link" href="{{ route('password.request') }}">
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="lms-button w-full mt-3">
                        {{ __('Log in') }}
                    </button>
                </form>

                <p class="mt-7 text-center text-sm text-slate-500">
                    Don’t have an account?
                    <a href="{{ route('register') }}" class="font-semibold text-indigo-600 transition hover:text-indigo-500">Create one</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
