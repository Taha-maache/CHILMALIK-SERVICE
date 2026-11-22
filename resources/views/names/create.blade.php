@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="row justify-content-center">

        <div class="col-md-10">

            <div class="card shadow border-0 rounded-4">

                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">إضافة طلب تسمية</h4>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('names.store') }}">
                        @csrf

                        {{-- FULL NAME --}}
                        <div class="mb-3">
                            <label class="form-label">الاسم الكامل</label>
                            <input type="text"
                                   name="full_name"
                                   class="form-control"
                                   required>
                        </div>

                        {{-- ADDRESS --}}
                        <div class="mb-3">
                            <label class="form-label">العنوان</label>
                            <input type="text"
                                   name="address"
                                   class="form-control"
                                   required>
                        </div>
<div class="mb-3">
    <label class="form-label">Type</label>

    <select name="type" class="form-control" id="typeSelect" required>
        <option value="physique">شخص طبيعي</option>
        <option value="moral">شخص معنوي</option>
    </select>
</div>

<div class="mb-3" id="formJuridiqueBox" style="display:none;">
    <label class="form-label">Forme Juridique</label>
    <input type="text" name="form_juridique" class="form-control">
</div>
                        <hr>

<h5 class="mb-3 text-primary">Nom Commercial (AR)</h5>

<div class="row">
    <div class="col-md-6 mb-3">
        <textarea name="nom_commercial_ar_1" class="form-control" rows="2" placeholder="AR 1" style="resize:none;"></textarea>
    </div>

    <div class="col-md-6 mb-3">
        <textarea name="nom_commercial_ar_2" class="form-control" rows="2" placeholder="AR 2" style="resize:none;"></textarea>
    </div>

    <div class="col-md-6 mb-3">
        <textarea name="nom_commercial_ar_3" class="form-control" rows="2" placeholder="AR 3" style="resize:none;"></textarea>
    </div>

    <div class="col-md-6 mb-3">
        <textarea name="nom_commercial_ar_4" class="form-control" rows="2" placeholder="AR 4" style="resize:none;"></textarea>
    </div>
</div>
                        <hr>

                        <h5 class="mb-3 text-success">Nom Commercial (FR)</h5>

<div class="row">
    <div class="col-md-6 mb-3">
        <textarea name="nom_commercial_fr_1" class="form-control" rows="2" placeholder="FR 1" style="resize:none;"></textarea>
    </div>

    <div class="col-md-6 mb-3">
        <textarea name="nom_commercial_fr_2" class="form-control" rows="2" placeholder="FR 2" style="resize:none;"></textarea>
    </div>

    <div class="col-md-6 mb-3">
        <textarea name="nom_commercial_fr_3" class="form-control" rows="2" placeholder="FR 3" style="resize:none;"></textarea>
    </div>

    <div class="col-md-6 mb-3">
        <textarea name="nom_commercial_fr_4" class="form-control" rows="2" placeholder="FR 4" style="resize:none;"></textarea>
    </div>
</div>

                        <div class="d-flex justify-content-between mt-4">

                            <a href="{{ route('names.index') }}" class="btn btn-secondary">
                                رجوع
                            </a>

                            <button class="btn btn-success">
                                حفظ
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