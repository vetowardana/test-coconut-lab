@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
  <h1 class="m-0 text-dark">Users</h1>
@stop

@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Users Table</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>No.</th>
          <th>Name</th>
          <th>Email</th>
        </tr>
        </thead>
        <tbody>
          @php $no = 1; @endphp
          @forelse($user as $row)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $row->name }}</td>
              <td>{{ $row->email }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="3" class="text-center">Belum ada data</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
@stop

@section('js')
  <script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
@stop
