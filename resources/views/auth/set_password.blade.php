@extends('layouts.accueil')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">Créer votre mot de passe</h2>

        @if(session('error'))
            <div class="mb-4 text-sm text-red-700 bg-red-100 p-3 rounded">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('password.reset') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="email" value="{{ $user->email }}">

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                <input id="password" type="password" name="password"  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border">
                @error('password')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmez le mot de passe</label>
                <input id="password_confirmation" type="password" name="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border ">
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:underline">Retour</a>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
@endsection