@extends('layout.main')
<x-modal.modal-form id="editModal" title="Edit Datas" action="" method="POST" enctype="multipart/form-data">
    @csrf
    @method('POST')
    <input type="hidden" name="id" id="edit_id">
    <x-form.image-preview id="preview_image" src="" label="Gambar Sekarang" />
    <x-modal.modal-input-file id="edit_image" name="image" label="Image" />
</x-modal.modal-form>

<x-modal.modal-form id="createModal" title="Tambah Data" action="{{ route('home.batch-menu.store') }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    <label for="batch_id">Pilih Batch</label>
    <select name="batch_id" id="batch_id" class="form-control mb-4" required>
        @foreach ($data as $item)
            <option value="{{ $item->id }}">
                {{ $item->name }} -
                ({{ \Carbon\Carbon::parse($item->start_date)->translatedFormat('d F Y') }} -
                {{ \Carbon\Carbon::parse($item->end_date)->translatedFormat('d F Y') }})
            </option>
        @endforeach
    </select>
    @php
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    @endphp
    @foreach ($days as $index => $day)
        <div class="border p-3 mb-3 rounded shadow-sm">
            <strong class="text-primary mb-2 d-block">{{ $day }}</strong>
            <input type="hidden" name="menus[{{ $index }}][day]" value="{{ $day }}">
            <x-modal.modal-input-file id="image_{{ $index }}" name="menus[{{ $index }}][image]"
                label="Image Menu" />
        </div>
    @endforeach
</x-modal.modal-form>
@section('css')
@endsection
@section('content')
    <div class="section-header">
        <h1>Batch Menu</h1>
        <x-breadcrumb :items="[['title' => 'Dashboard', 'url' => route('dashboard.index')], ['title' => 'Batch Maenu']]" />
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Batch Menu</h4>
                    </div>
                    <div class="card-body">
                        <x-form.textarea name="headline" label="Headline" />

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <h4 class="mb-0">Batch Menu Data</h4>
                            <x-table.add-button label="Tambah Data Menu +" target="#createModal" />
                        </div>
                    </div>
                    <div class="card-body">
                        @php
                            $headers = ['Batch', 'Day', 'Image', 'Tanggal'];
                            $rows = $data_menu
                                ->map(function ($item) {
                                    return [
                                        'id' => $item->id,
                                        'Day' => $item->day,
                                        'Batch' => $item->batch->name,
                                        'Tanggal' =>
                                            \Carbon\Carbon::parse($item->batch->start_date)->translatedFormat('d F Y') .
                                            ' s/d ' .
                                            \Carbon\Carbon::parse($item->batch->end_date)->translatedFormat('d F Y'),
                                        'Image' => $item->image,
                                        'edit_url' => route('home.batch-menu.put', $item->id),
                                        'delete_url' => route('home.batch-menu.put', $item->id),
                                        'edit_data' => [
                                            'id' => $item->id,
                                            'day' => $item->day,
                                            'image' => asset('storage/' . $item->image),
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
                form.querySelector('#edit_id').value = btn.dataset.id;

                const previewImage = form.querySelector('#preview_image img');
                if (previewImage && btn.dataset.image) {
                    previewImage.src = btn.dataset.image;
                }
            });

            $('#editModal').on('hidden.bs.modal', function() {
                form.reset();
                form.action = '';
                const previewImage = form.querySelector('#preview_image img');
                if (previewImage) previewImage.src = '';
            });
        });
    </script>
@endsection
