@if(Session::has('Mensaje'))
<div class="alert alert-success"><b>{{Session::get('Mensaje')}}<b></div>
@endif
@if(Session::has('Error'))
<div class="alert alert-danger"><b>{{Session::get('Error')}}<b></div>
@endif