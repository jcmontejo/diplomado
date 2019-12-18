<br>
@foreach($todos as $todo)
  <li id="{{$todo->id}}"><a href="#" onClick="task_done('{{$todo->id}}');" class="toggle"><i class="fa fa-check"></i></a> <span id="span_{{$todo->id}}">{{$todo->title}}</span> 
@endforeach