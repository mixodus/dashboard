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
											<i class="fa fa-align-justify"></i>Update Topic
								</div>
								<div class="card-body">
								<div class="row">
										<div class="col-12">
										<form method="POST" action="{{ env('APP_URL', '').'/dashboard/topic/update/'.$data->topic_id.'/store'}}" enctype="multipart/form-data">
												@csrf
												@method('POST')
											<label><b>Name:</b></label>
											<input class="form-control" name="name" type="text" placeholder="Topic's Name" value="{{$data->name}}"required>
											<br>
											<label><b>Title:</b></label>
											<input class="form-control" name="title" type="text" placeholder="Topic's Title" value="{{$data->title}}" required>
											<br>
											<label><b>Banner:</b></label>
											<input class="form-control-file" name="banner" type="file" placeholder="Topic Banner" value="{{$data->banner}}">
											<b>Pervious Image: <a href ="{{ $data->banner_url }}" target="_blank">Click Here!</a></b>
											<p>Skip the file upload if you don't want to change!</p>
											<br>
											<div class="card-footer">
												<button class="btn btn-sm btn-primary" type="submit"> Submit</button>
												<a href="{{ env('APP_URL', '').'/dashboard/topic' }}" class="btn btn-sm btn-danger" type="button"> Cancel</a>
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
