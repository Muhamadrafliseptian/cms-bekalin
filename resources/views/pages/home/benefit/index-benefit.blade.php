@extends('layout.main')
<x-modal.modal-form id="editModal" title="Edit Data" action="" method="POST">
    @method('POST')
    <x-modal.modal-textarea id="edit_headline" name="headline" label="Headline" />
</x-modal.modal-form>

<x-modal.modal-form id="createModal" title="Tambah Benefit" action="{{ route('home.benefit.store') }}">
    <x-modal.modal-textarea id="headline" name="headline" label="Headline" />
</x-modal.modal-form>
@section('content')
    <div class="section-header">
        <h1>Benefit</h1>
        <x-breadcrumb :items="[['title' => 'Dashboard', 'url' => route('dashboard.index')], ['title' => 'Benefit']]" />

    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Benefit</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('master.section-contents.store', ['id' => 4]) }}"
                            enctype="multipart/form-data">
                            @csrf
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
                            <x-form.textarea name="headline" label="Headline Kiri">
                                {{ old('headline', $section['headline'] ?? '') }}
                            </x-form.textarea>
                            <x-form.textarea name="subheadline" label="Headline Kanan">
                                {{ old('subheadline', $section['subheadline'] ?? '') }}
                            </x-form.textarea>
                            <div class="form-group row mb-4">
                                <x-form.submit-button />
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <h4 class="mb-0">Benefit Data</h4>
                            <x-table.add-button label="Tambah Data Benefit +" target="#createModal" />
                        </div>
                    </div>
                    <div class="card-body">
                        @php
                            $headers = ['Headline'];

                            $rows = $data
                                ->map(function ($item) {
                                    return [
                                        'id' => $item->id,
                                        'Headline' => $item->headline,
                                        'edit_url' => route('home.benefit.put', $item->id),
                                        'delete_url' => route('home.benefit.destroy', $item->id),
                                        'edit_data' => [
                                            'headline' => $item->headline,
                                        ],
                                        'data-target' => '#editModal',
                                    ];
                                })
                                ->toArray();
                        @endphp

                        <x-table.datatables :headers="$headers" :rows="$rows" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                scrollX: true,
                responsive: true
            });
        });
    </script>
    <x-alert.alert />
    <x-alert.sweet-alert />
    <x-modal.trigger-js />
    <x-modal.trigger-css />
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('editModal');
            const form = modal.querySelector('form');

            document.body.addEventListener('click', e => {
                if (!e.target.closest('.btn-edit')) return;
                const btn = e.target.closest('.btn-edit');

                form.action = btn.dataset.action;
                form.querySelector('[name="headline"]').value = btn.dataset.headline;
            });

            $('#editModal').on('hidden.bs.modal', function() {
                form.reset();
                form.action = '';
            });
        });
    </script>
@endsection
