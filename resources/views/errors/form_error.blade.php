@if($errors->any())
    <div class="alert alert-danger">
        <strong><span class="fa fa-exclamation-triangle"></span> Oops!</strong> 
        @foreach($errors->all() as $error)
        <br> {{ $error }}
        @endforeach
    </div>
@endif

@if(Session::has('kesalahan'))
    <div class="alert alert-danger">
        <strong><span class="fa fa-exclamation-triangle"></span> Oops!</strong> 
        <br> {{ Session::get('kesalahan') }}
    </div>
@endif

@if(Session::has('peringatan'))
    <div class="alert alert-danger">
        <strong><span class="fa fa-exclamation-triangle"></span> Oops!</strong> 
        <br> {{ Session::get('peringatan') }}
    </div>
@endif