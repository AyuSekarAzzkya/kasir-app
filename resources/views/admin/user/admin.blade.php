@extends('template')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.bootstrap5.css">
@endpush

@section('content')
    <div class="container">
        <div class="page-inner">

            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <h3 class="fw-bold mb-3">Data Admin</h3>
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
                            <h4 class="card-title mb-0">List Admin</h4>

                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddAdmin">
                                <i class="fa fa-plus"></i> Tambah Admin
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
                                        @foreach ($admins as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->email }}</td>

                                                <td>
                                                    <div class="d-flex gap-2">

                                                        <a href="#" class="btn btn-sm btn-info btn-edit"
                                                            data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                                            data-email="{{ $item->email }}" data-bs-toggle="modal"
                                                            data-bs-target="#modalEditAdmin">
                                                            Edit
                                                        </a>

                                                        <a href="#" class="btn btn-sm btn-danger btn-delete"
                                                            data-id="{{ $item->id }}">
                                                            Hapus
                                                        </a>

                                                        <form id="formDeleteAdmin{{ $item->id }}"
                                                            action="{{ route('admin.destroy', $item->id) }}" method="POST"
                                                            style="display:none;">
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

    {{-- ================= MODAL ADD ADMIN ================= --}}
    <div class="modal fade" id="modalAddAdmin" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-xl-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('admin.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama Admin</label>
                            <input type="text" name="name" class="form-control" placeholder="Masukkan nama admin">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Admin</label>
                            <input type="email" name="email" class="form-control" placeholder="Masukkan email admin">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password admin">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- ================= MODAL EDIT ADMIN ================= --}}
    <div class="modal fade" id="modalEditAdmin" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-xl-down">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form method="POST" id="formEditAdmin">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nama Admin</label>
                            <input type="text" name="name" id="editName" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Admin</label>
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

        $('.btn-edit').on('click', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var email = $(this).data('email');

            let url = "{{ route('admin.update', ':id') }}";
            url = url.replace(':id', id);

            $('#formEditAdmin').attr('action', url);
            $('#editName').val(name);
            $('#editEmail').val(email);
        });


        $('.btn-delete').on('click', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data admin akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#formDeleteAdmin' + id).submit();
                }
            });
        });
    </script>
@endpush
