@extends('layout.main')
<x-modal.modal-form id="editModal" title="Edit Data" action="" method="POST">
    @method('POST')
    <input type="text" id="edit_menu_id" name="menu_id" class="d-none">
    <x-modal.modal-input id="edit_meta_description" name="meta_description" label="Meta Description" />
    <x-modal.modal-input id="edit_meta_keywords" name="meta_keywords" label="Meta Keywords" />
</x-modal.modal-form>

<x-modal.modal-form id="createModal" title="Tambah Meta" action="{{ route('master.meta.store') }}">
    <label for="menu_id">Pilih Menu Header</label>
    <select name="menu_id" id="menu_id" class="form-control mb-4" required>
        @foreach ($menu as $item)
            <option value="{{ $item->id }}">
                {{ $item->name }}
            </option>
        @endforeach
    </select>
    <x-modal.modal-input id="meta_description" name="meta_description" label="Meta Description" />
    <x-modal.modal-input id="meta_keywords" name="meta_keywords" label="Meta Keywords" />
</x-modal.modal-form>
@section('content')
    <div class="section-header">
        <h1>Meta</h1>
        <x-breadcrumb :items="[['title' => 'Dashboard', 'url' => route('dashboard.index')], ['title' => 'Meta Data']]" />

    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <h4 class="mb-0">Meta Data</h4>
                            <x-table.add-button label="Tambah Data Meta +" target="#createModal" />
                        </div>
                    </div>
                    <div class="card-body">
                        @php
                            $headers = ['Meta Title', 'Meta Description', 'Meta Keywords'];

                            $rows = $data
                                ->map(function ($item) {
                                    return [
                                        'id' => $item->id,
                                        'Meta Title' => $item->meta_title,
                                        'Meta Description' => $item->meta_description,
                                        'Meta Keywords' => $item->meta_keywords,
                                        'edit_url' => route('master.meta.put', $item->id),
                                        'delete_url' => route('master.meta.destroy', $item->id),
                                        'edit_data' => [
                                            'meta_title' => $item->meta_title,
                                            'meta_description' => $item->meta_description,
                                            'meta_keywords' => $item->meta_keywords,
                                            'menu_id' => $item->menu->id,
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
                form.querySelector('[name="meta_description"]').value = btn.dataset.meta_description;
                form.querySelector('[name="meta_keywords"]').value = btn.dataset.meta_keywords;
                form.querySelector('[name="menu_id"]').value = btn.dataset.menu_id;
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
