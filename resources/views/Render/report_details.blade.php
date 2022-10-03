      <div class="row">
               <div class="col-sm-7">
                    <h4>Report ID:</h4>
               </div>
               <div class="col-sm-5">
                   <p>{{$report['id']}}</p>
               </div>
      </div>  
      <div class="row">
               <div class="col-sm-7">
                    <h4>Grade:</h4>
               </div>
               <div class="col-sm-5">
                   <p>{{$report['grade']['name']}}</p>
               </div>
      </div>
      <div class="row">
               <div class="col-sm-7">
                    <h4>Student Name:</h4>
               </div>
               <div class="col-sm-5">
                    <p>@if(!empty($report['student']['name'])){{$report['student']['name']}} @else {{$report['student_namee']}} @endif</p>
               </div>
      </div>
      <div class="row">
               <div class="col-sm-7">
                 <h4>Gender:</h4>
               </div>
               <div class="col-sm-5">
                @if($report['gender'] == "M")
                  <p>Male</p>
                @else
                  <p>Female</p>
                @endif
               </div>
      </div>
      <div class="row">
               <div class="col-sm-7">
                    <h4>Date:</h4>
               </div>
               <div class="col-sm-5">
                   <p>{{date("m/d/Y",strtotime($report['date']))}}</p>
               </div>
      </div>
      <div class="row">
               <div class="col-sm-7">
                    <h4>Time:</h4>
               </div>
               <div class="col-sm-5">
                   <p>{{date("h:i A",strtotime($report['time']))}}</p>
               </div>
      </div>
      <div class="row">
               <div class="col-sm-7">
                    <h4>Behavior:</h4>
               </div>
               <div class="col-sm-5">
                   <p>{{$report['behaviour']['name']}}</p>
               </div>
      </div>
      <div class="row">
               <div class="col-sm-7">
                    <h4>Location:</h4>
               </div>
               <div class="col-sm-5">
                   <p>{{$report['location']['name']}}</p>
               </div>
      </div>
      <div class="row">
               <div class="col-sm-7">
                    <h4>Intervention:</h4>
               </div>
               <div class="col-sm-5">
                   <p>{{$report['intervention']['name']}}</p>
               </div>
      </div>

      <div class="row">
               <div class="col-sm-12 Practice">
                    <h3>Restorative Practice</h3>
               </div>
      </div>
      
      <div class="row">
               <div class="col-sm-7">
                    <h4>Self Awareness:</h4>
               </div>
               <div class="col-sm-5">
                  @if($report['intervention'] == 1)
                   <p>Poor</p>
                    @elseif($report['intervention'] == 2)
                   <p>Average</p>
                     @else
                   <p>Optimal</p>
                   @endif
               </div>
      </div>

      <div class="row">
               <div class="col-sm-7">
                    <h4>Self Management:</h4>
               </div>
               <div class="col-sm-5">
                   @if($report['self_management'] == 1)
                   <p>Poor</p>
                    @elseif($report['self_management'] == 2)
                   <p>Average</p>
                     @else
                   <p>Optimal</p>
                   @endif
               </div>
      </div>

      <div class="row">
               <div class="col-sm-7">
                    <h4>Responsible Decision Making:</h4>
               </div>
               <div class="col-sm-5">
                    @if($report['responsible_decision_making'] == 1)
                   <p>Poor</p>
                    @elseif($report['responsible_decision_making'] == 2)
                   <p>Average</p>
                     @else
                   <p>Optimal</p>
                   @endif
               </div>
      </div>

      <div class="row">
               <div class="col-sm-7">
                    <h4>Relationship Skills:</h4>
               </div>
               <div class="col-sm-5">
                     @if($report['relationship_skills'] == 1)
                   <p>Poor</p>
                    @elseif($report['relationship_skills'] == 2)
                   <p>Average</p>
                     @else
                   <p>Optimal</p>
                   @endif
               </div>
      </div>

      <div class="row">
               <div class="col-sm-7">
                    <h4>Social Awareness:</h4>
               </div>
               <div class="col-sm-5">
                  @if($report['social_awareness'] == 1)
                   <p>Poor</p>
                    @elseif($report['social_awareness'] == 2)
                   <p>Average</p>
                     @else
                   <p>Optimal</p>
                  @endif
               </div>
      </div>

      <div class="row ">
               <div class="col-sm-12">
                    <h4>Notes</h4>
                    @if(!empty($report['other_notes']))
                      <p>{{$report['other_notes']}}</p>
                    @else
                      <p>Not added</p>
                    @endif
               </div>
      </div>