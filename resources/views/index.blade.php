@extends("layouts.app")
@section("content")
<form id="services_form" onsubmit="event.preventDefault()" style="background:#f2f2f2;padding:1.5rem;border-radius:1rem">
    {{csrf_field()}}
      <div class="form-group">
        <label><b>Username</b></label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
      </div>
      <div class="form-group">
        <label><b>Phone Number</b></label>
        <input type="number" class="form-control " id="number" name="number" placeholder="Number" required>
      </div>
      <div class="form-group">
        <label><b>User Email</b></label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
      </div>
      <input type="hidden"  id="service" name="service">
      <input type="hidden" id="interest" name="interest">

      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter" style="width:100%">
      Book Service
    </button>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="background:#d9d9d9;border-radius:1rem">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><b>Services</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @foreach($services as $service)
        <button class="btn" name="services" style="background:navy;color:white;width:31%" onclick="setServices('{{$service->name}}',event)" >
          {{$service->name}}
        </button>
        @endforeach
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter2" id="firstModalButton" onclick="nextButton()">continue</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
  <div class="modal-dialog modal-dialog-centenavy" role="document">
    <div class="modal-content" style="background:#d9d9d9;border-radius:1rem">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><b>Subscription</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          @foreach($interests as $interest)
            <button class="btn" name="interests" style="background:navy;color:white;width:31%" onclick="setInterests('{{$interest->name}}',event)" >
              {{$interest->name}}
            </button>
          @endforeach
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
</form>
@endsection
@section("scripts")
    <script>
    $("#firstModalButton").click(e => {
        e.preventDefault();
        $('#exampleModalCenter').modal('hide')
    });

    var services=[];
    function setServices(name,event){
      if(event.target.style.background=="navy"){
        event.target.style.background="#1889E4";
        services.push(name);
      }
      else{
        event.target.style.background="navy";
        services.splice(services.indexOf(name),1);
      }
    }
    function setInterests(name,event){
      $("#interest").val(name);
      $.ajax({
            url: '{{ url("/addToSession") }}',
            method: "POST",
            contentType:false,
            cache:false,
            processData:false,
            data: new FormData($("#services_form").get(0)),
            success: function(response) {
              console.log(response);
            }
        });
    }


    function nextButton(){
      $("#service").val(services);
    }
  </script>
@endsection