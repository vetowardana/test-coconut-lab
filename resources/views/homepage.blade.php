<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('vendor/datatables/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/datatables-plugins/responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/datatables-plugins/buttons/css/buttons.bootstrap4.min.css')}}">

    <title>Coconut Lab Test</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
      <div class="container-fluid px-5">
        <a class="navbar-brand" href="{{route('root')}}">Coconut Lab Test</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-flex" id="navbarNavAltMarkup">
          <div class="navbar-nav ml-auto">
            @if (Route::has('login'))
              @auth
                <a href="{{ route('dashboard') }}" class="nav-item nav-link">Home</a>
              @else
                <a href="{{ route('login') }}" class="nav-item nav-link">Log in</a>

                @if (Route::has('register'))
                  <a href="{{ route('register') }}" class="nav-item nav-link">Register</a>
                @endif
              @endauth
            @endif
          </div>
        </div>
      </div>
    </nav>

    <main class="py-2">
      <div class="container">
        <div class="card rounded">
          <div class="card-header">
            <h3 class="card-title">Users Table</h3>
          </div>
          <div class="card-body">
            <table id="table" class="table table-bordered table-hover">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">No.</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
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
                    <td colspan="3" class="text-center">No record.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>

    <footer>
      <div class="bg-dark py-2 fixed-bottom">
        <div class="container text-center">
          <p class="text-muted mb-0 py-2">&copy; 2022 Veto Wardana | All risghts reserved.</p>
        </div>
      </div>
    </footer>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{asset('vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('vendor/datatables-plugins/responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('vendor/datatables-plugins/responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('vendor/datatables-plugins/buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('vendor/datatables-plugins/buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('vendor/datatables-plugins/jszip/jszip.min.js')}}"></script>
    <script src="{{asset('vendor/datatables-plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{asset('vendor/datatables-plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{asset('vendor/datatables-plugins/buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('vendor/datatables-plugins/buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('vendor/datatables-plugins/buttons/js/buttons.colVis.min.js')}}"></script>

    <script>
      $(function () {
        $('#table').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
        });
      });
    </script>
  </body>
</html>