<form action="/user/{{ $user->id }}/delete" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit">Supprimer</button>
</form>