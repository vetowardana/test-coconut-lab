@extends('adminlte::page')

@section('title', 'Approve Delete Address')

@section('content_header')
  <h1 class="m-0 text-dark">Approve Delete Address</h1>
@stop

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          Approve Delete Address
        </div>
        <div class="card-body">
          <h5 class="card-title">Address :</h5>
          <p class="card-text">{{$address->addresses}}</p>
          <a href="javascript:void(0)" class="btn btn-danger btn-sm approve" data-xyz="deleteApproval=approved" data-id="{{ $address->id }}">Approved</a>
        </div>
      </div>
    </div>
  </div>
@stop

@section('js')
  <script>
    $(document).ready(function() {
      // Begin ajax
      $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      // Send delete request
      $('body').on('click', '.approve', function () {
        if (confirm("Approve delete request?") == true) {
          var id = $(this).data('id');
          var xyz = $(this).data('xyz');
          let url = "{{ route('deleteApproval', ':id') }}";
          let urlIndex = "{{ route('addresses.index') }}";
          url = url.replace(":id", id);
          $("#approve").html('Please Wait...');
          $("#approve"). attr("disabled", true);

          // ajax
          $.ajax({
            type:"GET",
            url: url,
            data: xyz,
            dataType: 'json',
            success: function(res){
              $("#approve").html('Approved');
              $("#approve").attr("disabled", false);
              window.location.href = urlIndex;
            }
          });
        }
      });
    });
  </script>
@stop
