@extends('layout.main')
<x-modal.modal-form id="editModal" title="Edit Data" action="" method="POST">
    @method('POST')
    <x-modal.modal-input-file id="edit_image" name="image" label="Image" />
    <x-modal.modal-textarea id="edit_headline" name="headline" label="Headline" />
    <x-modal.modal-textarea id="edit_subheadline" name="subheadline" label="Sub Headline" />
</x-modal.modal-form>

<x-modal.modal-form id="createModal" title="Tambah Why Us" action="{{ route('home.why-us.store') }}">
    <x-modal.modal-input-file id="image" name="image" label="Image" />
    <x-modal.modal-textarea id="headline" name="headline" label="Headline" />
    <x-modal.modal-textarea id="subheadline" name="subheadline" label="Sub Headline" />
</x-modal.modal-form>
@section('content')
    <div class="section-header">
        <h1>Why Us</h1>
        <x-breadcrumb :items="[['title' => 'Dashboard', 'url' => route('dashboard.index')], ['title' => 'Why Us']]" />

    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Why Us</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('master.section-contents.store', ['id' => 5]) }}" method="POST"
                            enctype="multipart/form-data">
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
                            <h4 class="mb-0">Why Us Data</h4>
                            <x-table.add-button label="Tambah Data Why Us +" target="#createModal" />
                        </div>
                    </div>
                    <div class="card-body">
                        @php
                            $headers = ['Headline', 'Sub Headline','Image'];

                            $rows = $data
                                ->map(function ($item) {
                                    return [
                                        'id' => $item->id,
                                        'Headline' => $item->headline,
                                        'Sub Headline' => $item->subheadline,
                                        'Image' => $item->image,
                                        'edit_url' => route('home.why-us.put', $item->id),
                                        'delete_url' => route('home.why-us.destroy', $item->id),
                                        'edit_data' => [
                                            'headline' => $item->headline,
                                            'subheadline' => $item->subheadline,
                                            'image' => $item->image,
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
                form.querySelector('[name="headline"]').value = btn.dataset.headline;
                form.querySelector('[name="subheadline"]').value = btn.dataset.subheadline;
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
