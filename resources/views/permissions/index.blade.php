@extends('template')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.bootstrap5.css">
@endpush

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <h3 class="fw-bold mb-3">Data Permission</h3>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">List Permission</h4>
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddPermission">
                                <i class="fa fa-plus"></i> Tambah Permission
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="datatable">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Permission</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permissions as $permission)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $permission->name }}</td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="#" class="btn btn-sm btn-info btn-edit"
                                                            data-id="{{ $permission->id }}"
                                                            data-name="{{ $permission->name }}" data-bs-toggle="modal"
                                                            data-bs-target="#modalEditPermission">
                                                            Edit
                                                        </a>

                                                        <a href="#" class="btn btn-sm btn-danger btn-delete"
                                                            data-id="{{ $permission->id }}">
                                                            Hapus
                                                        </a>

                                                        <form id="formDelete{{ $permission->id }}"
                                                            action="/permissions/{{ $permission->id }}/destroy"
                                                            method="POST" style="display:none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAddPermission" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-xl-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="/permissions/store" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Permission</label>
                            <input type="text" name="name" class="form-control" placeholder="Masukkan nama permission"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditPermission" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-xl-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="formEditPermission">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Nama Permission</label>
                            <input type="text" name="name" id="editPermissionName" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.5/js/dataTables.bootstrap5.js"></script>
    <script>
        $('#datatable').DataTable();

        $('.btn-edit').click(function() {
            let id = $(this).data('id');
            let name = $(this).data('name');

            $('#editPermissionName').val(name);
            $('#formEditPermission').attr('action', '/permissions/' + id + '/update');
        });

                $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            let id = $(this).data('id');

            Swal.fire({
                title: "Hapus Permission?",
                text: "Role dan permission yang terkait akan hilang!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Hapus",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#formDelete' + id).submit();
                }
            });
        });

    </script>
@endpush
