@extends('template')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.bootstrap5.css">
@endpush
@section('content')
    <div class="container">
        <div class="page-inner">

            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <h3 class="fw-bold mb-3">Data Kasir</h3>
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
                            <h4 class="card-title mb-0">List Kasir</h4>

                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddCashier">
                                <i class="fa fa-plus"></i> Tambah Kasir
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table" id="datatable">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($cashiers as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->email }}</td>

                                                <td>
                                                    <div class="d-flex gap-2">

                                                        <a href="#" class="btn btn-sm btn-info btn-edit"
                                                            data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                                            data-email="{{ $item->email }}" data-bs-toggle="modal"
                                                            data-bs-target="#modalEditCashier">
                                                            Edit
                                                        </a>

                                                        <a href="#" class="btn btn-sm btn-danger btn-delete"
                                                            data-id="{{ $item->id }}">
                                                            Hapus
                                                        </a>

                                                        <form id="formDelete{{ $item->id }}"
                                                            action="{{ route('admin.user.destroy', $item->id) }}"
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


    {{-- MODAL ADD --}}
    <div class="modal fade" id="modalAddCashier" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-xl-down">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kasir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('admin.user.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama Kasir</label>
                            <input type="text" name="name" class="form-control" placeholder="Masukkan nama">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Kasir</label>
                            <input type="email" name="email" class="form-control" placeholder="Masukkan email">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- MODAL EDIT --}}
    <div class="modal fade" id="modalEditCashier" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-xl-down">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Kasir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form id="formEditCashier" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nama Kasir</label>
                            <input type="text" name="name" id="editName" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Kasir</label>
                            <input type="email" name="email" id="editEmail" class="form-control">
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

        $(document).on('click', '.btn-delete', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: "Hapus Kasir?",
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Hapus",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formDelete' + id).submit();
                }
            });
        });

        // SET FORM EDIT
        $(document).on('click', '.btn-edit', function() {
            let id = $(this).data('id');
            $('#editName').val($(this).data('name'));
            $('#editEmail').val($(this).data('email'));
            $('#formEditCashier').attr('action', '/users/' + id);
        });
    </script>
@endpush
