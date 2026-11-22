@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Credits</h3>
        <a href="{{ route('services.index') }}" class="btn btn-success">
        <i class="fa fa-plus"></i>
        retour
    </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
<div class="mb-3">
    <input type="text" id="searchInput" class="form-control"
           placeholder="Search by client or phone...">
</div>
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Client</th>
                        <th>Phone</th>
                        <th>Total</th>
                        <th>Paid</th>
                        <th>Remaining</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody id="creditsTable">
                @foreach($credits as $credit)
                    <tr>
                        <td>{{ $credit->service->full_name }}</td>
                        <td>{{ $credit->service->phone }}</td>
                        <td>{{ number_format($credit->service->total_price) }}</td>
                        <td>{{ number_format($credit->amount_paid) }}</td>
                        <td>
                            <span class="badge bg-danger">
                                {{ number_format($credit->remaining_amount) }}
                            </span>
                        </td>

                        <td>
                            <a href="{{ route('credits.edit', $credit->id) }}"
                               class="btn btn-sm btn-primary">
                                Edit
                            </a>
                                                        <a href="{{ route('credits.payments', $credit->id) }}"
                               class="btn btn-sm btn-primary">
                                hisotique
                            </a>
                                 <a href="{{ route('credits.show', $credit->id) }}"
                               class="btn btn-sm btn-primary">
                                details
                            </a>
                            <form action="{{ route('credits.destroy', $credit->id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')

    <button class="btn btn-danger btn-sm"
            onclick="return confirm('Are you sure?')">
        Delete
    </button>
</form> 
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>
    </div>

</div>
<script>
document.getElementById('searchInput').addEventListener('keyup', function () {

    let value = this.value.toLowerCase();
    let rows = document.querySelectorAll('#creditsTable tr');

    rows.forEach(row => {

        let client = row.cells[0].textContent.toLowerCase();
        let phone = row.cells[1].textContent.toLowerCase();

        if (client.includes(value) || phone.includes(value)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }

    });

});
</script>
@endsection