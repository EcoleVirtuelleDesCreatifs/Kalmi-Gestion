<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Mettre à jour le mot de passe
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester sécurisé.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-lock mr-2 text-indigo-600"></i>Mot de passe actuel
            </label>
            <input type="password" id="update_password_current_password" name="current_password"
                   autocomplete="current-password"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
            @error('updatePassword.current_password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-key mr-2 text-indigo-600"></i>Nouveau mot de passe
            </label>
            <input type="password" id="update_password_password" name="password"
                   autocomplete="new-password"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
            @error('updatePassword.password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-check-double mr-2 text-indigo-600"></i>Confirmer le mot de passe
            </label>
            <input type="password" id="update_password_password_confirmation" name="password_confirmation"
                   autocomplete="new-password"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
            @error('updatePassword.password_confirmation')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition font-medium">
                <i class="fas fa-save mr-2"></i>Enregistrer
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-medium flex items-center"
                >
                    <i class="fas fa-check-circle mr-2"></i>Mot de passe mis à jour !
                </p>
            @endif
        </div>
    </form>
</section>
