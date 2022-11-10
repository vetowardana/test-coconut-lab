<!DOCTYPE html>
<html>
<head>
    <title>Coconut Lab</title>
</head>
<body>
    <div class="card text-center">
      <div class="card-body">
        <h5 class="card-title">New message from Coconut Lab</h5>
        <p class="card-text">Request delete address</p>
        <a href="{{$data['url']}}" target="_blank" class="btn btn-primary">Approve Delete Link</a>
      </div>
      <div class="card-footer text-muted">
        {{$data['date']}}
      </div>
    </div>
</body>
</html>