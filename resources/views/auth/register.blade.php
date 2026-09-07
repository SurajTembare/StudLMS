<x-guest-layout>
    <div class="relative mx-auto flex min-h-screen max-w-6xl items-center justify-center p-5 sm:p-8">
        <div class="lms-auth-card grid w-full max-w-5xl overflow-hidden lg:grid-cols-[1.05fr_0.95fr]">
            <div class="lms-illustration relative hidden p-10 text-white lg:flex lg:flex-col lg:justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white/20 backdrop-blur-sm">
                        <i class="fa-solid fa-user-plus text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.28em] text-indigo-100">Student LMS</p>
                        <h2 class="mt-1 text-2xl font-bold">Start today</h2>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <p class="text-sm uppercase tracking-[0.24em] text-indigo-100/80">Build your future</p>
                        <h1 class="mt-3 max-w-sm text-4xl font-black leading-tight">Create your free learning account.</h1>
                    </div>

                    <div class="rounded-2xl border border-white/15 bg-white/10 p-5 backdrop-blur-sm">
                        <p class="text-sm text-indigo-100/80">Unlock guided lessons, expert courses, and a more focused path to academic and career growth.</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 text-sm text-indigo-100/90">
                    <span class="inline-flex h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                    Join thousands of learners
                </div>
            </div>

            <div class="bg-white/80 p-7 sm:p-10 lg:p-12">
                <div class="mb-8 text-center lg:text-left">
                    <span class="inline-flex items-center rounded-full border border-violet-100 bg-violet-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.22em] text-violet-600">Register</span>
                    <h3 class="mt-5 text-3xl font-bold tracking-tight text-slate-900">Create your account</h3>
                    <p class="mt-2 text-sm text-slate-500">Get started with a personalized learning experience.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Name')" class="text-slate-700" />
                        <x-text-input id="name" class="lms-input" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-slate-700" />
                        <x-text-input id="email" class="lms-input" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-slate-700" />
                        <x-text-input id="password" class="lms-input" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-slate-700" />
                        <x-text-input id="password_confirmation" class="lms-input" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <button type="submit" class="lms-button w-full mt-3">
                        {{ __('Register') }}
                    </button>
                </form>

                <p class="mt-7 text-center text-sm text-slate-500">
                    Already registered?
                    <a href="{{ route('login') }}" class="font-semibold text-indigo-600 transition hover:text-indigo-500">Log in</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
