@extends('layouts.app')

@section('content')

<div class="container mt-5">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow border-0">

        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">

            <h4 class="mb-0">
                💾 Sauvegardes
            </h4>

            <form action="{{ route('backups.create') }}" method="POST">
                @csrf

                <button class="btn btn-success">
                    ➕ Créer une sauvegarde
                </button>

            </form>

        </div>

        <div class="card-body p-0">

            @if($backups->isEmpty())

                <div class="text-center p-5 text-muted">

                    Aucune sauvegarde disponible.

                </div>

            @else

            <table class="table table-hover mb-0">

                <thead class="table-dark">

                <tr>

                    <th>#</th>

                    <th>Nom</th>

                    <th>Date</th>

                    <th>Taille</th>

                    <th>Actions</th>

                </tr>

                </thead>

                <tbody>

                @foreach($backups as $backup)

                <tr>

                    <td>{{ $backup->id }}</td>

                    <td>{{ $backup->name }}</td>

                    <td>{{ $backup->created_at->format('d/m/Y H:i') }}</td>
                    
                    <td>{{ $backup->size }}</td>

           <td class="d-flex gap-2">

<form action="{{ route('backups.restore',$backup) }}"
      method="POST"
      onsubmit="return confirm('Restaurer cette sauvegarde ?')">

    @csrf

    <button class="btn btn-primary btn-sm">

        🔄 Restaurer

    </button>

</form>

<form action="{{ route('backups.destroy',$backup) }}"
      method="POST"
      onsubmit="return confirm('Supprimer cette sauvegarde ?')">

    @csrf
    @method('DELETE')

    <button class="btn btn-danger btn-sm">

        🗑 Supprimer

    </button>

</form>
<form action="{{ route('backups.copyExternal', $backup) }}"
      method="POST"
      onsubmit="return chooseExternalDisk(this)">

    @csrf

    <input type="hidden" name="destination">

    <button type="submit" class="btn btn-success btn-sm">
        📁 Copier vers disque externe
    </button>

</form>


</td>
                </tr>

                @endforeach

                </tbody>

            </table>

            @endif

        </div>

    </div>

</div>
<script>
function chooseExternalDisk(form) {

    let destination = prompt(
        "Entrez le chemin du disque externe :\nExemple : E:\\"
    );

    if (!destination) {
        return false;
    }

    form.querySelector('input[name="destination"]').value = destination;

    return true;
}
</script>
@endsection