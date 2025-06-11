@extends('layout.main')
<x-modal.modal-form id="editModal" title="Edit Data" action="" method="POST">
    @method('POST')
    <x-modal.modal-input-file id="edit_image" name="image" label="Image" />
    <x-modal.modal-textarea id="edit_nama" name="nama" label="Nama" />
    <x-modal.modal-textarea id="edit_review" name="review" label="Review" />
</x-modal.modal-form>

<x-modal.modal-form id="createModal" title="Tambah Why Us" action="{{ route('home.testimoni.store') }}">
    <x-modal.modal-input-file id="image" name="image" label="Image" />
    <x-modal.modal-textarea id="nama" name="nama" label="Nama" />
    <x-modal.modal-textarea id="review" name="review" label="Review" />
</x-modal.modal-form>
@section('content')
    <div class="section-header">
        <h1>Testimoni</h1>
        <x-breadcrumb :items="[['title' => 'Dashboard', 'url' => route('dashboard.index')], ['title' => 'Testimoni']]" />

    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Testimoni</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('master.section-contents.store', ['id' => 7]) }}">
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
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <h4 class="mb-0">Testimoni Data</h4>
                            <x-table.add-button label="Tambah Data Testimoni +" target="#createModal" />
                        </div>
                    </div>
                    <div class="card-body">
                        @php
                            $headers = ['Nama', 'Image', 'Review'];

                            $rows = $data
                                ->map(function ($item) {
                                    return [
                                        'id' => $item->id,
                                        'Nama' => $item->nama,
                                        'Image' => $item->image,
                                        'Review' => $item->review,
                                        'edit_url' => route('home.testimoni.put', $item->id),
                                        'delete_url' => route('home.testimoni.destroy', $item->id),
                                        'edit_data' => [
                                            'nama' => $item->nama,
                                            'image' => $item->image,
                                            'review' => $item->review,
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
                form.querySelector('[name="nama"]').value = btn.dataset.nama;
                form.querySelector('[name="review"]').value = btn.dataset.review;
                form.querySelector('[name="image"]').value = btn.dataset.image;
            });

            $('#editModal').on('hidden.bs.modal', function() {
                form.reset();
                form.action = '';
            });
        });
    </script>
    <script>
        $('#datatable').DataTable({
            scrollX: true,
            responsive: true
        });
    </script>
@endsection
