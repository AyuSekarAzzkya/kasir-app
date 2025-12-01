@extends('template')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.bootstrap5.css">
@endpush
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Category</h3>
                </div>
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
                            <h4 class="card-title mb-0">Data Kategori</h4>

                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddCategory">
                                <i class="fa fa-plus"></i> Tambah Kategori
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table" id="datatable">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>Nama Kategori</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>
                                                    <div class="d-flex gap-2">

                                                        <a href="#" class="btn btn-sm btn-info btn-edit"
                                                            data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                                            data-bs-toggle="modal" data-bs-target="#modalEditCategory">
                                                            Edit
                                                        </a>

                                                        <a href="#" class="btn btn-sm btn-danger btn-delete"
                                                            data-id="{{ $item->id }}">
                                                            Hapus
                                                        </a>

                                                        <form id="formDelete{{ $item->id }}"
                                                            action="{{ route('admin.categories.destroy', $item->id) }}"
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

    {{-- modalAddCategory --}}

    <div class="modal fade" id="modalAddCategory" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-xl-down">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text" name="name" class="form-control" placeholder="Masukkan nama kategori">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- modalEditCategory --}}

    <div class="modal fade" id="modalEditCategory" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-xl-down">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form method="POST" id="formEditCategory">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text" name="name" class="form-control" id="editName">
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
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const editButtons = document.querySelectorAll('.btn-edit');
            const editForm = document.querySelector('#formEditCategory');
            const nameInput = document.querySelector('#editName');

            editButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const name = this.dataset.name;

                    editForm.action = "{{ url('admin/categories') }}/" + id;
                    nameInput.value = name;
                });
            });

        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-delete')) {
                e.preventDefault();

                const id = e.target.closest('.btn-delete').dataset.id;

                Swal.fire({
                    title: "Hapus Data?",
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, hapus!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('formDelete' + id).submit();
                    }
                });
            }
        });
    </script>
@endpush
