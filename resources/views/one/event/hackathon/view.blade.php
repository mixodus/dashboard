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
                        <label class="col-md-3 col-form-label" for="date-input">Event Date</label>
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
                    <!-- Reward Section -->
                    @if($prize != null)
                    @foreach($prize as $key)
                    <div class="card-header"><strong>Rewards</strong></div><br><br>
                    <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="textarea-input">Reward Name</label>
                        <div class="col-md-9">
                            <input class="form-control" id="text-input" type="text" name="reward_name[]" value="{{$key['name']}}">
                        </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="textarea-input">Reward Value</label>
                        <div class="col-md-9">
                            <input class="form-control" id="text-input" type="text" name="reward_value[]" value="{{$key['reward_value']}}">
                        </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="textarea-input">Reward Icon</label>
                        <div class="col-md-9">
                        <input type="file" name="reward_icon[]" id="files{{$key['reward_icon']}}"class="file" accept="image/*">
                        <label class="col-md-3 col-form-label" for="files{{$key['reward_icon']}}" style="cursor:pointer">{{$key['reward_icon']}}</label>
                        </div>
                    </div>
                    @endforeach
                    @endif
                    <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="textarea-input"></label>
                        <div class="col-md-9">
                            <button type="button" id="addRow" class="btn btn-sm btn-info" row="2">Add Rewards</button>
                            <button type="button"  class="btn mnc btn-sm btn-danger" id="cancel" style=" display: none;">&nbsp;Cancel</button>
                        </div>
                    </div>
                    <?php 
                    $count = 4-count($prize);
                        for($i=2; $i<$count; $i++){ ?>
                    <div class="row<?php echo $i ?>" style="display:none">
                        <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="textarea-input">Reward Name</label>
                            <div class="col-md-9">
                                <input class="form-control" id="text-input" type="text" name="reward_name[]">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="textarea-input">Reward Value</label>
                            <div class="col-md-9">
                                <input class="form-control" id="text-input" type="text" name="reward_value[]">
                            </div>
                        </div>
                        <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="textarea-input">Reward Icon</label>
                            <div class="col-md-9">
                            <input type="file" name="reward_icon[]" class="file" accept="image/*" id="image{{$i}}">
                            </div>
                        </div>
                    </div>
                    <?php }?>
                     <!-- Timeline Section -->
                    <div class="card-header"><strong>TimeLine</strong></div><br><br>
                    @foreach($data->event_schedules as $raw)
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
                    <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="textarea-input">Additional Link</label>
                        <div class="col-md-9">
                            <input class="form-control" id="text-input" type="text" name="schedule_link[]" value="{{$raw->link}}">                 
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="date-input">Schedule Start Date</label>
                        <div class="col-md-9">
                            <input class="form-control" id="date-input" type="date" name="schedule_start[]" value="{{$raw->schedule_start}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="date-input">Schedule End Date</label>
                        <div class="col-md-9">
                            <input class="form-control" id="date-input" type="date" name="schedule_end[]"  value="{{$raw->schedule_end}}">
                        </div>
                    </div>
                    @endforeach
                    <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="textarea-input"></label>
                        <div class="col-md-9">
                            <button type="button" id="addRow2" class="btn btn-sm btn-info" raw="2">Add More Schedule</button>
                            <button type="button"  class="btn mnc btn-sm btn-danger" id="cancel2" style=" display: none;">&nbsp;Cancel</button>
                        </div>
                    </div>
                    <?php for($i=0; $i<10; $i++){ ?>
                    <div class="raw<?php echo $i ?>" style="display:none">
                    
                    <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="textarea-input">Title</label>
                        <div class="col-md-9">
                            <input class="form-control" id="text-input" type="text" name="schedule_name[]">
                        </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="textarea-input">Descriptions</label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="schedule_desc[]" rows="3" ></textarea>                    
                        </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="textarea-input">Additional Information</label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="schedule_additional[]" rows="3" ></textarea>                    
                        </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="textarea-input">Additional Link</label>
                        <div class="col-md-9">
                            <input class="form-control" id="text-input" type="text" name="schedule_link[]">                 
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="date-input">Schedule Start Date</label>
                        <div class="col-md-9">
                            <input class="form-control" id="date-input" type="date" name="schedule_start[]">  
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="date-input">Schedule End Date</label>
                        <div class="col-md-9">
                            <input class="form-control" id="date-input" type="date" name="schedule_end[]">  
                        </div>
                    </div>
                    </div>
                    <?php }?>
                    
                    <div class="card-footer">
                    <button class="btn btn-sm btn-primary" type="submit"> Submit</button>
                    <button class="btn btn-sm btn-danger" type="reset"> Reset</button>
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
                            <img src="{{$data->event_banner_url}}" class="img-fluid images" alt="Responsive image" 
                            style="width:150;height:100;">
                          </div>
                        </div>
                      </div>
                        <dl class="row">
                            <dt class="col-sm-3">Event Name</dt>
                            <dd class="col-sm-9">{{$data->event_title}}</dd>

                            <dt class="col-sm-3">Event Date</dt>
                            <dd class="col-sm-9">{{$data->event_date}}</dd>

                            <dt class="col-sm-3">Description</dt>
                            <dd class="col-sm-9">{{$data->event_note}}</dd>

                            <dt class="col-sm-3">Requirement</dt>
                            <dd class="col-sm-9">{{$data->event_requirement}}</dd>

                            <dt class="col-sm-3">Additional Information</dt>
                            <dd class="col-sm-9">{{$data->event_additional_information}}</dd>

                            <dt class="col-sm-3">Additional Information</dt>
                            <dd class="col-sm-9">{{$data->event_additional_information}}</dd>

                            
                        </dl>
                    </div>             
                <div class="card-footer">
                    <button onclick="showHiddenForm()" class="btn btn-sm btn-warning" >Edit Data</button>
                    <a class="btn btn-sm btn-info" href="{{ env('APP_URL', '').'/dashboard/hackathon/participant/'.$data->event_id }}"> Participants</a>
                </div>
            </div>
        </div>


@endsection
@section('javascript')
<script>
    function showHiddenForm() {
    var x = document.getElementById("formEdit");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
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
	    if(row==3)
		{
            alert("You can only add 3 rewards");
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
    </script>
@endsection
