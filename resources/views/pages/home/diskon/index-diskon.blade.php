@extends('layout.main')

@section('content')
    <div class="section-header">
        <h1>Diskon</h1>
        <x-breadcrumb :items="[['title' => 'Dashboard', 'url' => route('dashboard.index')], ['title' => 'Diskon']]" />

    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Diskon</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('master.section-contents.store', ['id' => 2]) }}">
                            @csrf
                            <x-form.textarea name="headline" label="Headline">
                                {{ old('headline', $section['headline'] ?? '') }}
                            </x-form.textarea>

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
