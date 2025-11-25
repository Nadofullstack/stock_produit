@extends('layouts.accueil')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-purple-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto">
        <!-- En-tête -->
        <div class="text-center mb-8">
           
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Créer un compte</h1>
         
        </div>

        <!-- Carte du formulaire -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-purple-700 px-6 py-4">
                <h2 class="text-xl font-semibold text-white text-center">Inscription</h2>
            </div>

            <form action="{{ route('save') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <!-- Champ Nom -->
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 flex items-center">
                        <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Nom complet
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name"
                        value="{{ old('name') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('name') border-red-500 bg-red-50 @enderror"
                        placeholder="Votre nom complet"
                    />
                    @error('name')
                    <div class="flex items-center space-x-2 text-red-600 text-sm bg-red-50 px-3 py-2 rounded-lg border border-red-200">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ $message }}</span>
                    </div>
                    @enderror
                </div>

                <!-- Champ Role -->
                <div class="space-y-2">
                    <label for="role" class="block text-sm font-medium text-gray-700">Rôle</label>
                    <select name="role" id="role" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                         <option value="caisse" {{ old('role')=='caisse' ? 'selected' : '' }}>Caissier</option>
                        <option value="admin" {{ old('role')=='admin' ? 'selected' : '' }}>Admin</option>
                        <option value="manager" {{ old('role')=='manager' ? 'selected' : '' }}>Manager</option>
                    </select>
                    @error('role')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Champ Email -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-700 flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Adresse email
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email"
                        value="{{ old('email') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 @error('email') border-red-500 bg-red-50 @enderror"
                        placeholder="votre@email.com"
                    />
                    @error('email')
                    <div class="flex items-center space-x-2 text-red-600 text-sm bg-red-50 px-3 py-2 rounded-lg border border-red-200">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ $message }}</span>
                    </div>
                    @enderror
                </div>

                <!-- Bouton de soumission -->
                <button 
                    type="submit"
                    class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl flex items-center justify-center"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    Créer un compte
                </button>
            </form>
        </div> 
    </div>
</div>

<style>
    input:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }
</style>
@endsection