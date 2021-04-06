@extends('one.layout.base')

@section('content')
				<div class="container-fluid">
						<div class="fade-in">
							<div class="card">
								<div class="card-header">
											<i class="fa fa-align-justify"></i>Dashboard Freelancer
											<br>
											<br>
											<a class="btn btn-sm btn-primary" href="{{ env('APP_URL', '').'/dashboard/freelancer/create' }}"><i class="cil-plus"></i> Create Freelancer</a>
								</div>

								<div class="card-body">
								
								<table class="table table-responsive-sm stripe" id="style_data">
												<thead>
													<tr>
														<th>No</th>
														<!-- <th>Name</th> -->
														<th>Email</th>
														<th>Contact</th>
														<th>Fee</th>
														<th>Job Position</th>
														<th>Referral Employee Name</th>
														<th>CVs</th>
														<th>Status</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
												@foreach($freelancer as $index => $freelancers)
														<tr>
															<td>{{ $index+1 }}</td>
															<!-- <td>{{ $freelancers->referral_name }}</td> -->
															<td>{{ $freelancers->referral_email }}</td>
															<td>{{ $freelancers->referral_contact_no }}</td>
															<td>{{ $freelancers->fee }}</td>
															<td>{{ $freelancers->job_position }}</td>
															@if($freelancers->admin_model == null )
															<td>-</td>
															@else
															<td>{{$freelancers->admin_model->first_name}}</td>
															@endif
															<td><a href ="{{ $freelancers->file_url }}" target="_blank">CV</a></td>
															<td>{{ $freelancers->referral_status }}</td>
															<td>
																<a class="btn btn-sm btn-primary" href="{{ env('APP_URL', '').'/dashboard/freelancer/update/'.$freelancers->referral_id}}"><i class="cil-plus"></i>Update</a>
																<br><br>
																<a class="btn btn-sm btn-primary" href="{{ env('APP_URL', '').'/dashboard/freelancer/update/'.$freelancers->referral_id.'/status'}}"><i class="cil-plus"></i>Status</a>
															</td>
														</tr>
												@endforeach
												</tbody>
											</table>
											
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
