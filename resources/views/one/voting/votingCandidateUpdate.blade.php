@extends('one.layout.base')

@section('content')

				<div class="container-fluid">
						<div class="fade-in">
						@if ($errors->any())
								<div class="alert alert-danger">
										<ul>
												@foreach ($errors->all() as $error)
														<button type="button" class="close" data-dismiss="alert">×</button>
														<li>{{ $error }}</li>
												@endforeach
										</ul>
								</div>
						@endif
							<div class="card">
								<div class="card-header">
											<i class="fa fa-align-justify"></i>Update Candidate
								</div>
								<div class="card-body">
								<div class="row">
										<div class="col-12">
										<form method="POST" action="{{ env('APP_URL', '').'/dashboard/topic/update/candidate/'.$topic->topic_id.'/'.$choice->choice_id.'/store'}}" enctype="multipart/form-data">
												@csrf
												@method('POST')
											<label><b>Name:</b></label>
											<input class="form-control" name="name" type="text" value="{{$choice->name}}" placeholder="Candidate's Name"required>
											<br>
											<label><b>Icon:</b></label>
											<input class="form-control-file" name="icon" value="{{$choice->icon}}" type="file" placeholder="Candidate's Icon">
											<b>Pervious Icon: <a href ="{{ $choice->icon_url }}" target="_blank">Click Here!</a></b>
											<p>Skip the file upload if you don't want to change!</p>
											<br>
											<div class="card-footer">
												<button class="btn btn-sm btn-primary" type="submit"> Submit</button>
												<a href="{{ env('APP_URL', '').'/dashboard/topic/details/'.$topic->topic_id }}" class="btn btn-sm btn-danger" type="button"> Cancel</a>
											</div>
											</form>
										</div>
								</div>
								</div>
							</div>
						</div>
					</div>

@endsection


@section('javascript')
		<script src="{{ asset('js/Chart.min.js') }}"></script>
		<script src="{{ asset('js/coreui-chartjs.bundle.js') }}"></script>
		<script src="{{ asset('js/main.js') }}" defer></script>
@endsection
