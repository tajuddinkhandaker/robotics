@extends('layouts.app')

@push('topbar-menu-item')

<a class="dropdown-item" href="{{ route('goodbots::clients') }}">Clients</a>

@endpush

@push('footer-scripts')
<script type="text/javascript">
    $(document).ready(function() {

        $.get( "/api/v1/iot/test")
          .done(function( response ) {
            console.log( "Data Loaded: " + response.lights.length );

           jQuery.each(response.lights, function(index, item) {
                
                var light = $('#light' + (index + 1));
                light.text('LIGHT ' + (index + 1) + ' - ' + (item === 0 ? 'OFF' : 'ON'));
                light.css('background-color', item === 1 ? 'green' : 'red');
            });

          });
        
        $('#light2').click(function() {
        
            $.ajax({
              method: "GET",
              url: '/api/v1/components/2/edit?_method=PUT',
              dataType: "json",
              contentType: 'json'
            }).done(function(response) {
                console.log(response.data.message);
                console.log(response.data.switch_state);
                $('#light2').text('LIGHT 2 - ' + response.data.switch_state);
                $('#light2').css('background-color', response.data.switch_state === 'ON' ? 'green' : 'red');
            });
            console.log('light 2');
        
        });
        $('#light1').click(function() {
            
            console.log('light 1');
            
            $.ajax({
              method: "GET",
              url: '/api/v1/components/1/edit?_method=PUT',
              dataType: "json",
              contentType: 'json'
            }).done(function(response) {
                console.log(response.data.message);
                console.log(response.data.switch_state);
                $('#light1').text('LIGHT 1 - ' + response.data.switch_state);
                $('#light1').css('background-color', response.data.switch_state === 'ON' ? 'green' : 'red');
            });
        });
        $('#add').click(function() {
        
            $.post( "/api/v1/components/", { name: "Light" })
              .done(function( data ) {
                alert( "Data Loaded: " + data );
              });
        });
        
    });
</script>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                    @if(env('QUICK_DEMO', false) === true)
                    <button id="add">Add</button>

                    <button id="light1" class="edit">Light 1</button>
                    <button id="light2" class="edit">Light 2</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
