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
											<i class="fa fa-align-justify"></i>Create Candidate
								</div>
								<div class="card-body">
								<div class="row">
										<div class="col-12">
										<form method="POST" action="{{ env('APP_URL', '').'/dashboard/freelancer/adminstore' }}" enctype="multipart/form-data">
												@csrf
												@method('POST')
											<label><b>Name :</b></label>
											<input class="form-control" name="referral_name" type="text" placeholder=" Candidate's Name"required>
											<br>
											<label><b>Email :</b></label>
											<input class="form-control" name="referral_email" type="text" placeholder="Candidate's Email" required>
											<br>
											<label><b>Contact Number:</b></label>
											<input class="form-control" name="referral_contact_no" type="number" placeholder="Candidate's Phone Number" required>
											<br>
											<div class="form-group">
												<!--<label for="referral_status"><b>Status :</b></label>
												<select class="form-control" name="referral_status" required>
													<option name="status" value="-">Select Freelancer Status</option>
													<option name="status" value="Success">Success</option>
													<option name="status" value="Failed">Failed</option>
													<option name="status" value="InReview">InReview</option>
													<option name="status" value="Pending">Pending</option>
												</select>-->
											</div>
											<label><b>Upload CV:</b></label>
											<input class="form-control-file" name="file" type="file" placeholder="Uplaod CV" required>
											<br>
											<label><b>Fee:</b></label>
											<input class="form-control" name="fee" type="number" placeholder="Candidate's Fees">
											<br>
											<label><b>Job-Position:</b></label>
											<input class="form-control" name="job_position" type="text" placeholder="Candidate's Job Position" required>
											<br>
											<div class="card-footer">
												<button class="btn btn-sm btn-primary" type="submit"> Submit</button>
												<a href="{{ env('APP_URL', '').'/dashboard/user-management/admin' }}" class="btn btn-sm btn-danger" type="button"> Cancel</a>
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
