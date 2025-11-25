@extends('layouts.accueil')

@section('content')
<style>
    .login-container {
        width: 100%;
        max-width: 400px;
        margin: 2rem auto;
        padding: 2rem;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border: 1px solid #ddd;
    }

    .login-container h1 {
        text-align: center;
        margin-bottom: 1.5rem;
        color: #333;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: #555;
        font-weight: bold;
    }

    .form-group input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box; /* To include padding and border in the element's total width and height */
    }

    .error-message {
        color: #e3342f;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    .submit-btn {
        width: 100%;
        padding: 0.75rem;
        background-color: #3490dc;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1rem;
        font-weight: bold;
        transition: background-color 0.3s;
    }

    .submit-btn:hover {
        background-color: #2779bd;
    }
</style>

<div class="login-container">
    <h1>Connexion</h1>

    <form action="{{route('login.authenticate')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Adresse Email</label>
            <input type="email" name="email" id="email"  >
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" name="password"  id="password">
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div class="text-blue-500">
            <a href="{{ route('email') }}">Mot de passe oublié</a>
        </div>
        <button type="submit" class="submit-btn">Se connecter</button>
        
    </form>
</div>
@endsection