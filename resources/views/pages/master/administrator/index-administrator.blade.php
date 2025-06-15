@extends('layout.main')
<x-modal.modal-form id="editModal" title="Edit Administrator" action="" method="POST">
    @csrf
    <input type="hidden" name="id" id="edit_id">
    <div class="form-group">
        <label for="edit_name">Nama</label>
        <input type="text" name="name" id="edit_name" class="form-control" value="{{ old('name') }}">
    </div>
    <div class="form-group">
        <label for="edit_email">Email</label>
        <input type="email" name="email" id="edit_email" class="form-control" value="{{ old('email') }}">
    </div>
    <div class="form-group">
        <label for="edit_password">Password</label>
        <input type="password" name="password" id="edit_password" class="form-control" value="{{ old('password') }}">
    </div>
</x-modal.modal-form>
<x-modal.modal-form id="createModal" title="Tambah Administrator" action="{{ route('profile.administrator.store') }}"
    method="POST">
    @csrf
    <div class="form-group">
        <label for="name">Nama</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}">
    </div>
</x-modal.modal-form>

@section('content')
    <div class="section-header">
        <h1>Administrator</h1>
        <x-breadcrumb :items="[['title' => 'Dashboard', 'url' => route('dashboard.index')], ['title' => 'Administrator']]" />
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <h4 class="mb-0">Administrator Data</h4>
                            <x-table.add-button label="Tambah Data Administrator +" target="#createModal" />
                        </div>
                    </div>
                    <div class="card-body">
                        @php
                            $headers = ['Nama', 'Email'];

                            $rows = $data
                                ->map(function ($item) {
                                    return [
                                        'id' => $item->id,
                                        'Nama' => $item->name,
                                        'Email' => $item->email,
                                        'edit_url' => route('profile.administrator.put', $item->id),
                                        'delete_url' => route('profile.administrator.destroy', $item->id),
                                        'edit_data' => [
                                            'name' => $item->name,
                                            'email' => $item->email,
                                            'password' => $item->password,
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
                form.querySelector('[name="name"]').value = btn.dataset.name;
                form.querySelector('[name="email"]').value = btn.dataset.email;
                // form.querySelector('[name="password"]').value = btn.dataset.password;
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
