<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Informations du Profil
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Mettez à jour les informations de profil et l'adresse e-mail de votre compte.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-user mr-2 text-indigo-600"></i>Nom
            </label>
            <input type="text" id="name" name="name" required autofocus autocomplete="name"
                   value="{{ old('name', $user->name) }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
            @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-envelope mr-2 text-indigo-600"></i>Email
            </label>
            <input type="email" id="email" name="email" required autocomplete="username"
                   value="{{ old('email', $user->email) }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        Votre adresse e-mail n'est pas vérifiée.

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cliquez ici pour renvoyer l'e-mail de vérification.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            Un nouveau lien de vérification a été envoyé à votre adresse e-mail.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition font-medium">
                <i class="fas fa-save mr-2"></i>Enregistrer
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-medium flex items-center"
                >
                    <i class="fas fa-check-circle mr-2"></i>Enregistré avec succès !
                </p>
            @endif
        </div>
    </form>
</section>
