@extends('layout.main')
<x-modal.modal-form id="editModal" title="Edit FAQ" action="" method="POST">
    @method('POST')
    <x-modal.modal-textarea id="edit_question" name="question" label="Pertanyaan" />
    <x-modal.modal-textarea id="edit_answer" name="answer" label="Jawaban" />
</x-modal.modal-form>

<x-modal.modal-form id="createModal" title="Tambah FAQ" action="{{ route('faq.store') }}">
    <x-modal.modal-textarea id="question" name="question" label="Pertanyaan" />
    <x-modal.modal-textarea id="answer" name="answer" label="Jawaban" />
</x-modal.modal-form>

@section('content')
    <div class="section-header">
        <h1>Faq</h1>
        <x-breadcrumb :items="[['title' => 'Dashboard', 'url' => route('dashboard.index')], ['title' => 'Faq']]" />
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Faq</h4>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('master.section-contents.store', ['id' => 8]) }}">
                            @csrf
                            <x-form.textarea name="headline" label="Headline">
                                {{ old('section', $section['headline'] ?? '') }}
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
                            <h4 class="mb-0">Faq Data</h4>
                            <x-table.add-button label="Tambah Data Faq +" target="#createModal" />
                        </div>
                    </div>
                    <div class="card-body">
                        @php
                            $headers = ['Pertanyaan', 'Jawaban'];

                            $rows = $data
                                ->map(function ($item) {
                                    return [
                                        'id' => $item->id,
                                        'Pertanyaan' => $item->question,
                                        'Jawaban' => $item->answer,
                                        'edit_url' => route('faq.put', $item->id),
                                        'delete_url' => route('faq.destroy', $item->id),
                                        'edit_data' => [
                                            'question' => $item->question,
                                            'answer' => $item->answer,
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
                form.querySelector('[name="question"]').value = btn.dataset.question;
                form.querySelector('[name="answer"]').value = btn.dataset.answer;
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
