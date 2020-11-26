<section style="background:#efefe9;">
 <div class="container">
   <div class="row">
     <div class="board">

       <div class="board-inner">
       <ul class="nav nav-a nav-tabs" id="myTab">
       <div class="liner"></div>

        
          <li class="{{!$sol->enviado ? 'active' : ''}}">
            <a class="linka si" href="#solicitud{{$sol->id}}" data-toggle="tab" title="Solicitud">
              <span class="round-tabs"><i class="fa fa-address-book prefix grey-text"></i></span> 
            </a>
          </li>
          <li class="{{($sol->enviado && !$sol->recomendacion) ? 'active' : ''}}">
            <a class="linka {{$sol->enviado ? 'si' : 'no'}}" href="#enviado{{$sol->id}}" data-toggle="tab" title="Enviado">
              <span class="round-tabs"><i class="fa fa-share-square prefix grey-text"></i></span> 
            </a>
          </li>
          <li class="{{($sol->recomendacion && !$sol->recomendacion_enviada()) ? 'active' : ''}}">
            <a class="linka {{$sol->recomendacion ? 'si' : 'no'}}" href="#reunion{{$sol->id}}" data-toggle="tab" title="Reunión">
              <span class="round-tabs"><i class="fa fa-users prefix grey-text"></i></span>
            </a>
          </li>
          <li class="{{($sol->recomendacion_enviada() && !$sol->dictamen_enviado()) ? 'active' : ''}}">
            <a class="linka {{$sol->recomendacion_enviada() ? 'si' : 'no'}}" href="#recomendacion{{$sol->id}}"  data-toggle="tab" title="Recomendación">
              <span class="round-tabs"><i class="fa fa-file prefix grey-text"></i></span> 
            </a>
          </li>
          <li class="{{$sol->dictamen_enviado() ? 'active' : ''}}">
            <a class="linka {{$sol->dictamen_enviado() ? 'si' : 'no'}}" href="#dictamen{{$sol->id}}" data-toggle="tab" title="Dictamen">
              <span class="round-tabs"><i class="fa fa-check prefix grey-text"></i></span>
            </a>
          </li>
       </ul>
       </div>


       <div class="tab-content">

         <div class="tab-pane fade {{!$sol->enviado ? 'in active' : ''}}" id="solicitud{{$sol->id}}">
            <h3 class="head text-center">Ya has realizado tu solicitud</span></h3>
            <p class="narrow text-center">
            {{$sol->solicitud_firmada ? 'Ya has subido tu solicitud firmada' : 'No has subido tu solicitud firmada'}}<br>
            {{$sol->enviado ? 'Ya has enviado tu solicitud' : 'Aún no has enviado tu solicitud'}}<br>
            {{$sol->evidencias ? 'Tu solicitud tiene evidencias' : 'Tu solicitud no tiene evidencias'}}<br>
            </p>
         </div>
         

         @if($sol->enviado)
         <div class="tab-pane fade {{($sol->enviado && !$sol->recomendacion) ? 'in active' : ''}}" id="enviado{{$sol->id}}">
            <h3 class="head text-center">Se ha enviado tu solicitud</h3>
            <p class="narrow text-center">
            @if(!$sol->enviadocoor && usuario()->esEstudiante())
            Tu solicitud se ha enviado al coordinador de carrera para su validación.
            @else
            {{usuario()->esEstudiante() ? 'Tu solicitud ha sido recibida por el coordinador de carrera y se ha enviado a:' : 'Tu solicitud se ha enviado a:'}}<br>
            Jefe de Departamento<br>
            Subdirección Académica<br>
            Servicios Escolares<br>
            @endif
            </p>
         </div>
         @endif

         @if($sol->recomendacion)
         <div class="tab-pane fade {{($sol->recomendacion && !$sol->recomendacion_enviada()) ? 'in active' : ''}}" id="reunion{{$sol->id}}">
            <h3 class="head text-center">Tu solicitud ya ha sido revisada en la reunión</h3>
            <p class="narrow text-center">
            Tu solicitud ha sido revisada en la reunión con fecha de {{fecha($sol->calendario->start)}}<br>
            El comité académico ha dado una respuesta a tu solicitud<br>
            </p>
         </div>
         @endif
         

         @if($sol->recomendacion_enviada())
         <div class="tab-pane fade {{($sol->recomendacion_enviada() && !$sol->dictamen_enviado()) ? 'in active' : ''}}" id="recomendacion{{$sol->id}}">
            <h3 class="head text-center">Tu solicitud ya ha pasado a recomendación</h3>
            <p class="narrow text-center">
            Se ha generado la recomendación que será evaluada para dar el resultado final para tu dictamen<br>
            </p>
         </div>
         @endif


         @if($sol->dictamen_enviado())
         <div class="tab-pane fade in active" id="dictamen{{$sol->id}}">
             <h3 class="head text-center"> Tu Dictamen esta listo</h3>
             <p class="narrow text-center">
             Tu dictamen ya tiene una respuesta<br>
             @if($sol->dictamen())
             @if($sol->dictamen()->entregado)
             Tu dictamen se ha realizado, Para obtener una copia lo puedes hacer en la opcion de Dictamen. O si deseas una copia física pasa con tu coordinador de carrera
             @elseif($sol->dictamen()->entregadodepto)
             Tu dictamen se ha realizado, Para obtener una copia lo puedes hacer en la opcion de Dictamen. O si deseas una copia física pasa con tu coordinador de carrera
             @else
             Mantente pendiente en esta página, te notificaremos cuando puedas recoger tu dictamen en el departamento de tu carrera<br>
             @endif
             @endif
             </p>
         </div>
         @endif

         <div class="clearfix"></div>         

       </div>

      </div>
    </div>
  </div>
</section>