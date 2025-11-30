@extends('template')

@section('content')
    <div class="container">
        <h3>Laporan Penjualan</h3>

        <div class="card mt-3">
            <div class="card-header">
                <strong>Filter Laporan</strong>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.report.index') }}" method="GET" class="row g-3">

                    <div class="col-md-3">
                        <label>Jenis Laporan</label>
                        <select name="type" class="form-control" id="typeSelect">
                            <option value="daily" {{ request('type') == 'daily' ? 'selected' : '' }}>Harian</option>
                            <option value="monthly" {{ request('type') == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                            <option value="yearly" {{ request('type') == 'yearly' ? 'selected' : '' }}>Tahunan</option>
                        </select>
                    </div>

                    <div class="col-md-3 filter-daily">
                        <label>Tanggal</label>
                        <input type="date" name="date" class="form-control"
                            value="{{ request('date', date('Y-m-d')) }}">
                    </div>

                    <div class="col-md-2 filter-monthly d-none">
                        <label>Bulan</label>
                        <select name="month" class="form-control">
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-2 filter-monthly d-none">
                        <label>Tahun</label>
                        <input type="number" name="year" class="form-control" value="{{ request('year', date('Y')) }}">
                    </div>

                    <div class="col-md-3 filter-yearly d-none">
                        <label>Tahun</label>
                        <input type="number" name="year" class="form-control" value="{{ request('year', date('Y')) }}">
                    </div>

                    <div class="col-md-2">
                        <label>&nbsp;</label>
                        <button class="btn btn-primary w-100">Tampilkan</button>
                    </div>

                </form>
            </div>
        </div>

        @include('admin.report.result', ['transactions' => $transactions])

    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.5/js/dataTables.bootstrap5.js"></script>
    <script>
        $('#datatable').DataTable();
        function updateFilter() {
            let type = document.getElementById('typeSelect').value;

            document.querySelectorAll('.filter-daily').forEach(e => e.classList.add('d-none'));
            document.querySelectorAll('.filter-monthly').forEach(e => e.classList.add('d-none'));
            document.querySelectorAll('.filter-yearly').forEach(e => e.classList.add('d-none'));

            if (type === "daily") {
                document.querySelectorAll('.filter-daily').forEach(e => e.classList.remove('d-none'));
            }
            if (type === "monthly") {
                document.querySelectorAll('.filter-monthly').forEach(e => e.classList.remove('d-none'));
            }
            if (type === "yearly") {
                document.querySelectorAll('.filter-yearly').forEach(e => e.classList.remove('d-none'));
            }
        }

        updateFilter();
        document.getElementById('typeSelect').addEventListener('change', updateFilter);
    </script>
@endpush
