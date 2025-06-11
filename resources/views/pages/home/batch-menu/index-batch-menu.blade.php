@extends('layout.main')

@section('css')

@endsection
@section('content')
    <div class="section-header">
        <h1>Batch Menu</h1>
        <x-breadcrumb :items="[['title' => 'Dashboard', 'url' => route('dashboard.index')], ['title' => 'Batch Menu']]" />

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
                        <h4>Batch Menu Data</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped w-100" id="datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Image</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        1
                                    </td>
                                    <td>
                                        Image
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
@endsection
