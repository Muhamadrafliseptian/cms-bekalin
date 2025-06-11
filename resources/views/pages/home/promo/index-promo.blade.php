@extends('layout.main')

@section('content')
    <div class="section-header">
        <h1>Promo</h1>
        <x-breadcrumb :items="[['title' => 'Dashboard', 'url' => route('dashboard.index')], ['title' => 'Promo']]" />

    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Promo</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('master.section-contents.store', ['id' => 3]) }}" enctype="multipart/form-data">
                            @csrf
                            @php
                                $imagePath = $section['image'] ?? null;
                                $isUrl =
                                    $imagePath &&
                                    (strpos($imagePath, 'http://') === 0 || strpos($imagePath, 'https://') === 0);
                                $imageUrl = $isUrl ? $imagePath : asset('storage/' . $imagePath);
                            @endphp

                            @if ($imageUrl)
                                <x-form.image-preview :src="$imageUrl" label="Gambar Sekarang" />
                            @endif
                            <x-form.input-file name="img" label="Image" />
                            <div class="form-group row mb-4">
                                <x-form.submit-button />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <x-alert.alert />
@endsection
