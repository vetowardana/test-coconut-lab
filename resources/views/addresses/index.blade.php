@extends('adminlte::page')

@section('title', 'Addresses')

@section('content_header')
  <h1 class="m-0 text-dark">Addresses</h1>
@stop

@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Addresses Table</h3>

      <div class="card-tools mr-2">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
          Add Addresses
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Addresses</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="javascript:void(0)" method="post" id="addressForm" name="addressForm">
                <div class="modal-body field_wrapper">
                  <div class="row row_wrapper">
                    <div class="col-sm-2">
                      <div class="form-group my-2">
                        <div class="form-check">
                          <input class="form-check-input newDefault" type="radio" name="newDefault" id="newDefault" value="1" data-id="1">
                          <label class="form-check-label">Default</label>
                          <input class="form-control" type="hidden" name="default[]" id="default1" value="0">
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-9">
                      <div class="form-group">
                        <input type="text" class="form-control" name="addresses[]" id="addresses" placeholder="Address" required>
                      </div>
                    </div>
                    <div class="col-sm-1">
                      <a type="button" class="btn btn-outline-primary btn-xs my-2 add_button"><i class="fas fa-plus"></i></a>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary closeModal" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary save">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>No.</th>
          <th>Addresses</th>
          <th>Default</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
          @php $no = 1; @endphp
          @php $customSwitchId = 1; @endphp
          @php $customSwitchFor = 1; @endphp
          @php $sendMailBeforeDelete = 1; @endphp
          @php $sendMailBeforeDeleteNumber = 1; @endphp
          @forelse($address as $row)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{$row->addresses}}</td>
              <td>
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input inisiateDefaultAddress" data-id="{{ $row->id }}" id="customSwitch{{ $customSwitchId++ }}" {{$row->default == 1 ? 'checked' : ''}}>
                  <label class="custom-control-label" for="customSwitch{{ $customSwitchFor++ }}">{{$row->default == 1 ? 'On' : 'Off'}}</label>
                </div>
              </td>
              <td>
                @role('Super Admin')
                  <a href="javascript:void(0)" class="btn btn-danger btn-sm delete" data-id="{{ $row->id }}">delete</a>
                @else
                  @if($row->delete_approval == 'no')
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm sendMailBeforeDelete"  data-xyz="deleteApproval=wait" id="sendMailBeforeDelete{{$sendMailBeforeDelete++}}" data-number={{$sendMailBeforeDeleteNumber++}} data-id="{{ $row->id }}">Send delete request</a>
                  @elseif($row->delete_approval == 'wait')
                   <p class="text-secondary">Please wait the approval...</p>
                  @else
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm delete" data-id="{{ $row->id }}">delete</a>
                  @endif
                @endrole
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center">No record.</td>
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
    });

    $(document).ready(function() {
      $('.row_wrapper .add_button').click(function() {
        var maxField = 10;
        var x = 1;
        var countWrapper = $('.row_wrapper').length + 1;
        var box_html = $('<div class="row row_wrapper"><div class="col-sm-2"><div class="form-group my-2"><div class="form-check"><input class="form-check-input newDefault" type="radio" name="newDefault" id="newDefault" value="1" data-id="' + countWrapper + '"><label class="form-check-label">Default</label><input class="form-control" type="hidden" name="default[]" id="default' + countWrapper + '" value="0"></div></div></div><div class="col-sm-9"><div class="form-group"><input type="text" class="form-control" name="addresses[]" id="addresses" placeholder="Address" required></div></div><div class="col-sm-1"><a type="button" class="btn btn-outline-primary btn-xs my-2 remove_button"><i class="fas fa-minus"></i></i></a></div></div>');
        box_html.hide();
        $('.field_wrapper div.row_wrapper:last').after(box_html);
        box_html.fadeIn('slow');
        return false;
      });

      $('.field_wrapper').on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent().parent('div').remove();
      });

      $(document).on("change", ".newDefault", function() {
        var newDefaultVal = $(".newDefault:checked").val();
        var newDefaultId = $(".newDefault:checked").data('id');

        $('input[name="default[]"]').each(function() {
          $(this).val("0");
        });

        $('#default' + newDefaultId).val(newDefaultVal);
      });

      $(document).on("click", ".closeModal", function() {
        window.location.reload();
      });

      // Begin ajax
      $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      // Add
      $('body').on('submit', '#addressForm', function (event) {
        event.preventDefault();
        var actionType = $('#save').val();
        $("#save").html('Please Wait...');
        $("#save"). attr("disabled", true);
        var form_data = new FormData(this);
        let url = "{{ route('addresses.store') }}";
        
        // ajax
        $.ajax({
          type:"POST",
          url: url,
          data:form_data, 
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(res){
            if (res.code == '00') {
              $("#save").html('Save');
              $("#save"). attr("disabled", false);
              window.location.reload();
            } else if (res.code == '02') {
              alert(res.message);
            }
          }
        });
      });

      // Inisiate default address
      $('body').on('change', '.inisiateDefaultAddress', function () {
        var id = $(this).data('id');
        let url = "{{ route('inisiateDefaultAddress', ':id') }}";
        url = url.replace(":id", id);
        // ajax
        $.ajax({
          type:"POST",
          url: url,
          data: "",
          dataType: 'json',
          success: function(res){
            if (res.code == '01') {
              alert(res.message);
            } else {
              window.location.reload();
            }
          }
        });
      });

      // Delete
      $('body').on('click', '.delete', function () {
        if (confirm("Delete Address?") == true) {
          var id = $(this).data('id');
          let url = "{{ route('addresses.destroy', ':id') }}";
          let urlIndex = "{{ route('addresses.index') }}";
          url = url.replace(":id", id);
          // ajax
          $.ajax({
            type:"delete",
            url: url,
            data: "",
            dataType: 'json',
            success: function(res){
              window.location.href = urlIndex;
            }
          });
        }
      });

      // Send delete request
      $('body').on('click', '.sendMailBeforeDelete', function () {
        if (confirm("Send delete request?") == true) {
          var id = $(this).data('id');
          var number = $(this).data('number');
          var xyz = $(this).data('xyz');
          let url = "{{ route('sendMailBeforeDelete', ':id') }}";
          url = url.replace(":id", id);
          $("#sendMailBeforeDelete" + number).html('Please Wait...');
          $("#sendMailBeforeDelete" + number). attr("disabled", true);

          // ajax
          $.ajax({
            type:"get",
            url: url,
            data: xyz,
            dataType: 'json',
            success: function(res){
              window.location.reload();
            }
          });
        }
      });
    });
  </script>
@stop
