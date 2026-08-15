<x-guest-layout>
    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-info" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email')
                <div class="text-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password">
            @error('password')
                <div class="text-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">
                    Remember me
                </label>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary w-100">
                Log in
            </button>
        </div>

        <div class="auth-links">
            @if (Route::has('register'))
                <a href="{{ route('register') }}">Register</a>
            @endif

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Forgot your password?</a>
            @endif
        </div>
    </form>
</x-guest-layout>
