@extends('one.layout.base')

@section('content')
<div class="container-fluid">
    <div class="fade-in">
    <div class="col-md-12" id="formEdit" style="display:none">
        <div class="card">
            <div class="card-header"><strong>Edit Data</strong></div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ env('APP_URL', '').'/dashboard/event/update-hackathon/'.$data->event_id }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    
                    
                    <div class="form-group row">
                      <div class="col-sm-6">
                        <img src="{{$data->event_banner_url}}" class="img-thumbnail" width="150" height="150" id="preview" />
                      </div>
                        <div class="col-sm-6">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="text-input">Logo</label>
                          <input type="file" name="event_banner" class="file" accept="image/*">
                          <div class="col-md-9">
                            <input type="text" class="form-control" disabled placeholder="Upload File" id="file">
                            <div class="input-group-append">
                              <button type="button" class="browse btn btn-primary">Browse...</button>
                            </div>
                          <small>size max upload image 5Mb.</small>
                          </div>
                        </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="text-input">Company</label>
                        <div class="col-md-9">
                            <select class="form-control" name="company_id" required>
                                <option value="0">-- Select Company --</option>
                                @foreach($company as $companys)
                                <option value="{{$companys->company_id}}" {{ ( $companys->company_id == $data->company_id ) ? 'selected' : '' }}>{{$companys->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- hidden input -->
                    <input type="text" name="event_type_id" value="{{$data->event_type_id}}" style="display:none">
                    <input type="text" name="event_time" value="{{$data->event_time}}" style="display:none">
                    <!-- end hidden input -->
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="text-input">Event Name</label>
                        <div class="col-md-9">
                            <input class="form-control" id="text-input" type="text" name="event_title" value="{{$data->event_title}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="date-input">Event End Date</label>
                        <div class="col-md-9">
                            <input class="form-control" id="date-input" type="date" name="event_date" value="{{$data->event_date}}">
                        </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="textarea-input">Description</label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="event_note" rows="5" placeholder="Typing event description.." id="summary-ckeditor">{{$data->event_note}}</textarea>                    
                        </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="textarea-input">Requirement</label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="event_requirement" rows="5" placeholder="Typing event description.." id="summary-ckeditor2">{{$data->event_requirement}}</textarea>                    
                        </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="textarea-input">Additional Information</label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="event_additional_information" rows="5" placeholder="Typing event description.." id="summary-ckeditor3">{{$data->event_additional_information}}</textarea>                    
                        </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="textarea-input">Terms and Condition</label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="event_terms_coditions" rows="5" placeholder="Typing .." id="summary-ckeditor4">{{$data->event_terms_conditions}}</textarea>                    
                        </div>
                    </div>
                    <!-- Reward Section -->
                    @if($data->event_prize  != null)
                    @foreach($data->event_prize as $key)
                    <div class="card-header"><strong>Rewards</strong></div><br><br>
                    <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="textarea-input">Reward Name</label>
                        <div class="col-md-9">
                            <input class="form-control" id="text-input" type="text" name="reward_name[]" value="{{$key->name}}">
                        </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="textarea-input">Reward Value</label>
                        <div class="col-md-9">
                            <input class="form-control" id="text-input" type="text" name="reward_value[]" value="{{$key->reward_value}}">
                        </div>
                    </div>
                    <div class="form-group row" style="display:none">
                    <label class="col-md-3 col-form-label" for="textarea-input">Reward Icon</label>
                        <div class="col-md-9"><br>
                        
                        <img src="{{$key->reward_icon_url}}" width="50px" height="50px"><br><br>
                        <input type="text" class="form-control" placeholder="Browse.." id="text_image{{$key->reward_icon}}" value="{{$key->reward_icon}}">
                        <input type="file" class="inputFile" name="reward_icon[]" >
                        <input type="hidden" name="reward_icon[]" value="{{$key->reward_icon}}">
                        </div>
                    </div>
                    @endforeach
                    @endif
                     <!-- Timeline Section -->
                    <div class="card-header"><strong>TimeLine</strong></div><br><br>
                    @foreach($data->event_schedules as $raw)
                    <input  type="text" name="schedule_id[]" value="{{$raw->schedule_id}}" style="display:none">
                        
                    <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="textarea-input">Title</label>
                        <div class="col-md-9">
                            <input class="form-control" id="text-input" type="text" name="schedule_name[]" value="{{$raw->name}}">
                        </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="textarea-input">Descriptions</label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="schedule_desc[]" rows="3" >{{$raw->desc}}</textarea>                    
                        </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="textarea-input">Additional Information</label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="schedule_additional[]" rows="3" >{{$raw->additional_information}}</textarea>                    
                        </div>
                    </div>
                    <div class="form-group row" style="display:none">
                    <label class="col-md-3 col-form-label" for="textarea-input">Additional Link</label>
                        <div class="col-md-9">
                            <input class="form-control" id="text-input" type="text" name="schedule_link[]" value="{{$raw->link}}">                 
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="date-input">Schedule Start Date</label>
                        <div class="col-md-9">
                            <input class="form-control" id="date-input" type="date" name="schedule_start[]" value="<?php echo date('Y-m-d', strtotime($raw->schedule_start)); ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="date-input">Schedule End Date</label>
                        <div class="col-md-9">
                            <input class="form-control" id="date-input" type="date" name="schedule_end[]"  value="<?php echo date('Y-m-d', strtotime($raw->schedule_end)); ?>">
                        </div>
                    </div>
                    
                    <div class="form-group row" style="display:none">
                    <label class="col-md-3 col-form-label" for="textarea-input">Shedule Icon Success</label>
                        <div class="col-md-9"><br>
                        <img src="{{$raw->icon_schedule_default}}" width="70px" height="70px"><br><br>
                        <input type="text" class="form-control" placeholder="Browse.." id="text_image{{$raw->icon}}" value="{{$raw->icon}}">
                        <input type="file" class="inputFile2" name="icon_schedule_default[]" >
                        <input type="hidden" name="icon_schedule_default[]" value="{{$raw->icon}}">
                        </div>
                    </div>

                    <div class="form-group row" style="display:none">
                    <label class="col-md-3 col-form-label" for="textarea-input">Shedule Icon Failed</label>
                        <div class="col-md-9"><br> 
                        <img src="{{$raw->icon_schedule_failed}}" width="70px" height="70px"><br><br>
                        <input type="text" class="form-control" placeholder="Browse.." id="text_image{{$raw->icon}}" value="{{$raw->icon}}">
                        <input type="file" class="inputFile2" name="icon_schedule_failed[]" >
                        <input type="hidden" name="icon_schedule_failed[]" value="{{$raw->icon}}">
                        </div>
                    </div>
                    <div class="form-group row" style="display:none">
                    <label class="col-md-3 col-form-label" for="textarea-input">Shedule Icon Pending</label>
                        <div class="col-md-9"><br>
                        <img src="{{$raw->icon_schedule_pending}}" width="70px" height="70px"><br><br>
                        <input type="text" class="form-control" placeholder="Browse.." id="text_image{{$raw->icon}}" value="{{$raw->icon}}">
                        <input type="file" class="inputFile2" name="icon_schedule_pending[]" >
                        <input type="hidden" name="icon_schedule_pending[]" value="{{$raw->icon}}">
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="card-footer">
                    <button class="btn btn-sm btn-primary" type="submit"> Submit</button>
                    <button class="btn btn-sm btn-danger" type="reset"> Reset</button>
                    <a onclick="cancelForm()" class="btn btn-sm btn-warning" >Cancel</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
        <div class="card">
            <div class="card-header">Hackathon Event</div>
            <div class="card-body"><div class="bd-example">
            
                    <div class="row">
                        <div class="col-sm-12">
                          <div class="text-center">
                            <img src="{{$data->event_banner_url}}" class="img-fluid images" alt="Responsive image" style="width:200px;height:200px;">
                          </div>
                        </div>
                      </div>
                        <dl class="row">
                            <dt class="col-sm-3">Event Name</dt>
                            <dd class="col-sm-9">{{$data->event_title}}</dd>

                            <dt class="col-sm-3">Event End Date</dt>
                            <dd class="col-sm-9">{{$data->event_date}}</dd>

                            <dt class="col-sm-3">Description</dt>
                            <dd class="col-sm-9">{!!$data->event_note!!}</dd>

                            <dt class="col-sm-3">Requirement</dt>
                            <dd class="col-sm-9">{!!$data->event_requirement!!}</dd>

                            <dt class="col-sm-3">Additional Information</dt>
                            <dd class="col-sm-9">{!!$data->event_additional_information!!}</dd>

                            <dt class="col-sm-3">Terms and Conditions</dt>
                            <dd class="col-sm-9">{!!$data->event_terms_conditions!!}</dd>

                            
                        </dl>
                    </div>             
                    <div class="card-footer">
                        <button onclick="showHiddenForm()" class="btn btn-sm btn-warning" >Edit Data</button>
                    </div>
                    
                <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header"><i class="fa fa-align-justify"></i>Participant</div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Participant Data</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Participant Timeline Status</a>
                        </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <!-- Participant Data -->
                                <br><br>
                                <h4> Participant Data </h4>
                                <br>
                                <table class="table table-responsive-sm stripe" id="style_data">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Email</th>
                                        <th>Name</th>
                                        <th>University</th>
                                        <th>Major</th>
                                        <th>Semester</th>
                                        <th>Files</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($participant as $index => $participant)
                                        <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $participant->email }}</td>
                                        <td>{{ $participant->fullname }}</td>
                                        <td>{{ $participant->university }}</td>
                                        <td>{{ $participant->major }}</td>
                                        <td>{{ $participant->semester }}</td>
                                        <td>
                                        <a href="{{ $participant->idcard_file }}" target="_blank">ID Card </a>|
                                        <a href="{{ $participant->studentcard_file }}" target="_blank">Student Card </a>|
                                        <a href="{{ $participant->transcripts_file }}" target="_blank">Transcripts Card </a>
                                        <a href="{{ $participant->cv_file }}" target="_blank">CV </a>
                                        </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <br><br>
                                <h4> Participant Timeline Status</h4>
                                <br>
                                <table class="table table-responsive-sm stripe" id="style_data">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Email</th>
                                        @foreach($data->eventSchedules as $key)
                                        <th>{{$key->name}}</th>
                                        @endforeach
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($participant_status as $index => $participant)
                                        <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $participant->email }}</td>
                                        @foreach($participant->schedule_status as $key)
                                        <th>
					@if($key->status_timeline == 1)
                                        @if($key->status =="Failed")
                                        <p style="color:red">{{ $key->status }}</p>
                                        @elseif($key->status =="Passed")
                                        <p style="color:green">{{ $key->status }}</p>
                                        @else
                                        <p>{{ $key->status }}</p>
                                        @endif
				
                                        <div class="dropdown">
                                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-expanded="false">
                                                Update Status
                                            </a>

                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item" href="{{ env('APP_URL', '').'/dashboard/hackathon/update-status/Passed/'.$data->event_id.'/'.$key->schedule_id.'/'.$key->employee_id }}">Success</a>
                                                <a class="dropdown-item" href="{{ env('APP_URL', '').'/dashboard/hackathon/update-status/Failed/'.$data->event_id.'/'.$key->schedule_id.'/'.$key->employee_id }}">Failed</a>
                                            </div>
                                            </div>
					@else
					<b>Upcoming</b>
					@endif
                                        </th>
                                        @endforeach
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>


@endsection
@section('javascript')

<style>
      .file {
              visibility: hidden;
              position: absolute;
            }
    </style>
<script>
    function showHiddenForm() {
        var x = document.getElementById("formEdit");
        if (x.style.display === "none") {
            x.style.display = "block";
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } else {
            x.style.display = "none";
        }
    }
    function cancelForm() {
        var x = document.getElementById("formEdit");
        if (x.style.display === "block") {
            x.style.display = "none";
        } else {
            x.style.display = "block";
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }
    $(document).ready(function(){
	xx=1;
	$('#files').val(xx);
    $('#addRow').click(function(){
    	//alert (xx);
	    $(".mnc").fadeIn();
	    $(this).attr('disabled','disabled');
	    $(this).attr('disabled','disabled');
	    row = $(this).attr('row');
	   
                    
	    $('.row'+row).fadeIn();	
	    row++;
	    xx=xx+1;
	    //alert(xx);
	    if(row==10)
		{
            // alert("You can only add 3 rewards");
            $('#addRow').hide();
		}
	    $('#addRow').attr('row',row);
	    $('#addRow').removeAttr('disabled');
	    $('#files').val(xx);	
		    
    });
    $('#cancel').click(function(){
			row=$("#addRow").attr('row');
			//alert (row);
			row=row-1;
			xx=xx-1;
			
			
			$("input#files").val(xx);
			//$("input#admins1").val(x4);
			$('.row'+row).hide();
			if(row==2)
			{
				$(".mnc").hide();
			}
			$('#addRow').fadeIn();
            $('#addRow').removeAttr('disabled');
			$("#addRow").attr('row',row);
			
	});
        
});
    $(document).ready(function(){
	count_data=1;
	$('#files').val(count_data);
    $('#addRow2').click(function(){
    	//alert (xx);
	    $(".mnc").fadeIn();
	    $(this).attr('disabled','disabled');
	    $(this).attr('disabled','disabled');
	    raw = $(this).attr('raw');
	   
                    
	    $('.raw'+raw).fadeIn();	
	    raw++;
	    count_data=count_data+1;
	    //alert(xx);
	    if(raw==10)
		{
            alert("You can only add 10 timeline");
            $('#addRow2').hide();
		}
	    $('#addRow2').attr('raw',raw);
	    $('#addRow2').removeAttr('disabled');
	    $('#files').val(count_data);	
		    
    });
    $('#cancel2').click(function(){
        raw=$("#addRow2").attr('raw');
			//alert (row);
			raw=raw-1;
			count_data=count_data-1;
			
			
			$("input#files").val(count_data);
			//$("input#admins1").val(x4);
			$('.raw'+raw).hide();
			if(raw==2)
			{
				$(".mnc").hide();
			}
			$('#addRow2').fadeIn();
            $('#addRow2').removeAttr('disabled');
			$("#addRow2").attr('raw',raw);
			
	});
        
});




</script>

<script src="{{ asset('js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/coreui-chartjs.bundle.js') }}"></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
    <script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript">
      CKEDITOR.replace( 'summary-ckeditor' );
      CKEDITOR.replace( 'summary-ckeditor2' );
      CKEDITOR.replace( 'summary-ckeditor3' );
      CKEDITOR.replace( 'summary-ckeditor4' );
    </script>
@endsection
