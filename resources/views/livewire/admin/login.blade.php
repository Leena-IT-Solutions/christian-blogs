<div class="container" style="max-width: 500px; margin: 80px auto;">
    <div style="background-color: var(--card-bg); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 40px; box-shadow: var(--shadow-lg);">
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 70px; width: auto;">
        </div>
        <h2 style="font-family: var(--font-heading); text-align: center; margin-bottom: 8px;">Admin Access</h2>
        <p style="text-align: center; color: var(--text-muted); margin-bottom: 30px; font-size: 0.9rem;">Please log in to manage your website</p>

        <form wire:submit.prevent="login">
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input 
                    type="email" 
                    id="email" 
                    wire:model.blur="email" 
                    class="form-control" 
                    placeholder="admin@example.com"
                    required
                    autocomplete="email"
                    autofocus
                >
                @error('email') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    wire:model.blur="password" 
                    class="form-control" 
                    placeholder="••••••••"
                    required
                    autocomplete="current-password"
                >
                @error('password') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" style="display: flex; align-items: center; gap: 8px;">
                <input type="checkbox" id="remember" wire:model="remember" style="accent-color: var(--accent-color); width: 16px; height: 16px; cursor: pointer;">
                <label for="remember" style="color: var(--text-color); font-size: 0.9rem; cursor: pointer; user-select: none;">Remember me</label>
            </div>

            <button type="submit" class="btn" style="width: 100%; margin-top: 10px;">
                <span wire:loading.remove>Sign In</span>
                <span wire:loading>Authenticating...</span>
            </button>
        </form>
    </div>
</div>
