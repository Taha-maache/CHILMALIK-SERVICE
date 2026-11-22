@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="row justify-content-center">

        <div class="col-md-10">

            <div class="card shadow border-0 rounded-4">

                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">تعديل طلب تسمية</h4>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('names.update', $name->id) }}">
                        @csrf
                        @method('PUT')

                        {{-- FULL NAME --}}
                        <div class="mb-3">
                            <label class="form-label">الاسم الكامل</label>
                            <input type="text"
                                   name="full_name"
                                   class="form-control"
                                   value="{{ $name->full_name }}"
                                   required>
                        </div>

                        {{-- ADDRESS --}}
                        <div class="mb-3">
                            <label class="form-label">العنوان</label>
                            <input type="text"
                                   name="address"
                                   class="form-control"
                                   value="{{ $name->address }}"
                                   required>
                        </div>
                        <select name="type" class="form-control" id="typeSelect">
    <option value="physique" {{ $name->type == 'physique' ? 'selected' : '' }}>
        شخص طبيعي
    </option>

    <option value="moral" {{ $name->type == 'moral' ? 'selected' : '' }}>
        شخص معنوي
    </option>
</select>

<div class="mb-3" id="formJuridiqueBox"
     style="display: {{ $name->type == 'moral' ? 'block' : 'none' }};">
    <label>Forme Juridique</label>
    <input type="text" name="form_juridique"
           class="form-control"
           value="{{ $name->form_juridique }}">
</div>

                        <hr>

                        <h5 class="mb-3 text-primary">Nom Commercial (AR)</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <textarea name="nom_commercial_ar_1" class="form-control" rows="2" style="resize:none;">{{ $name->nom_commercial_ar_1 }}</textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <textarea name="nom_commercial_ar_2" class="form-control" rows="2" style="resize:none;">{{ $name->nom_commercial_ar_2 }}</textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <textarea name="nom_commercial_ar_3" class="form-control" rows="2" style="resize:none;">{{ $name->nom_commercial_ar_3 }}</textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <textarea name="nom_commercial_ar_4" class="form-control" rows="2" style="resize:none;">{{ $name->nom_commercial_ar_4 }}</textarea>
                            </div>
                        </div>

                        <hr>

                        <h5 class="mb-3 text-success">Nom Commercial (FR)</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <textarea name="nom_commercial_fr_1" class="form-control" rows="2" style="resize:none;">{{ $name->nom_commercial_fr_1 }}</textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <textarea name="nom_commercial_fr_2" class="form-control" rows="2" style="resize:none;">{{ $name->nom_commercial_fr_2 }}</textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <textarea name="nom_commercial_fr_3" class="form-control" rows="2" style="resize:none;">{{ $name->nom_commercial_fr_3 }}</textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <textarea name="nom_commercial_fr_4" class="form-control" rows="2" style="resize:none;">{{ $name->nom_commercial_fr_4 }}</textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">

                            <a href="{{ route('names.index') }}" class="btn btn-secondary">
                                رجوع
                            </a>

                            <button class="btn btn-primary">
                                تحديث
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>
<script>
document.getElementById('typeSelect').addEventListener('change', function () {
    let box = document.getElementById('formJuridiqueBox');

    if (this.value === 'moral') {
        box.style.display = 'block';
    } else {
        box.style.display = 'none';
    }
});
</script>
@endsection