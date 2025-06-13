@extends('layout.main')
@section('content')
    <div class="section-header">
        <h1>Master Batch</h1>
        <x-breadcrumb :items="[['title' => 'Dashboard', 'url' => route('dashboard.index')], ['title' => 'Master Batch']]" />
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <h4 class="mb-0">Master Batch Data</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        @php
                            $headers = ['Name', 'Tanggal'];

                            $rows = $data
                                ->map(function ($item) {
                                    return [
                                        'id' => $item->id,
                                        'Name' => $item->name,
                                        'Tanggal' =>
                                            \Carbon\Carbon::parse($item->start_date)->translatedFormat('d F Y') .
                                            ' s/d ' .
                                            \Carbon\Carbon::parse($item->end_date)->translatedFormat('d F Y'),
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
