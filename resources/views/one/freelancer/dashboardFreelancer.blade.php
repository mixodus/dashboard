@extends('one.layout.base')

@section('content')

@if(in_array("view-asAdmin", $action))
<!-- freelancer-start -->
	<div class="container-fluid">
        <div class="fade-in">
            <div class="row">
        	    <div class="col-sm-6 col-lg-3">
                  <div class="card text-white bg-primary">
                    <div class="card-body pb-0">
                      <div class="text-value-lg">Passed</div>
                      <div class="text-value-md">
                      @if($result['passed']==null)
                        No Talents are passed!
                      @else
                        {{count($result['passed'])}} Talents are passed!
                      @endif
                      </div>
                      <div>Don't forget to pay the TalentHunter's fee!
                        <br><a class="btn btn-light" href="{{env('APP_URL').'/dashboard/freelancer?SortByStatus=Passed'}}">Click Here To See!</a><br><br>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-lg-3">
                  <div class="card text-white bg-info">
                    <div class="card-body pb-0">
                      <div class="text-value-lg">Complete</div>
                      <div class="text-value-md">
                      @if($result['complete']==null)
                        No Talents are complete!
                      @else
                        {{count($result['complete'])}} Talents are complete!
                      @endif
                      </div>
                      <div>Don't forget to pay the TalentHunter's fee!
                      <br><a class="btn btn-light" href="{{env('APP_URL').'/dashboard/freelancer?SortByStatus=Complete'}}">Click Here To See!</a><br><br></div>
                    </div>
                  </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-lg-3">
                  <div class="card text-white bg-warning">
                    <div class="card-body pb-0">
                      <div class="text-value-lg">Pending</div>
                      <div class="text-value-md">
                      @if($result['pending']==null)
                        No Talents are in pending!
                      @else
                        {{count($result['pending'])}} Talents are pending!
                      @endif
                      </div>
                      <br>
                      <div><a class="btn btn-light" href="{{env('APP_URL').'/dashboard/freelancer?SortByStatus=Pending'}}">Click Here To See!</a><br><br></div>
                    </div>
                  </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-lg-3">
                  <div class="card text-white bg-danger">
                    <div class="card-body pb-0">
                      <div class="text-value-lg">InReview</div>
                      <div class="text-value-md">
                      @if($result['inreview']==null)
                        No Talents are InReview!
                      @else
                        {{count($result['inreview'])}} Talents are InReview!
                      @endif
                      </div>
                      <br>
                      <div><a class="btn btn-light" href="{{env('APP_URL').'/dashboard/freelancer?SortByStatus=InReview'}}">Click Here To See!</a><br><br></div>
                    </div>
                  </div>
                </div>
                <!-- /.col-->
              </div>
            </div>
          <!-- freelancer-end -->
        </div>
		<div class="container-fluid">
						<div class="fade-in">
							<div class="card">
								<div class="card-header">
											<i class="fa fa-align-justify"></i>Dashboard Candidate
											<br>
											<br>
											@if(in_array("add", $action))
											<a class="btn btn-sm btn-primary" href="{{ env('APP_URL', '').'/dashboard/freelancer/create' }}"><i class="cil-plus"></i> Create Freelancer</a>
											@elseif(in_array("add-asAdmin", $action))
											<a class="btn btn-sm btn-primary" href="{{ env('APP_URL', '').'/dashboard/freelancer/admincreate' }}"><i class="cil-plus"></i> Create Freelancer</a>
											@endif
								</div>
								<div class="card-body">
										<form method="get" action="{{ env('APP_URL').'/dashboard/freelancer' }}">Status: 
											@csrf
												<select name="SortByStatus">
													<option value="All">All</option>
													<option value="Pending">Pending</option>
													<option value="InReview">InReview</option>
													<option value="Passed">Passed</option>
													<option value="NotPassed">Not Passed</option>
													<option value="Complete">Complete</option>
												</select>
												<button type="submit">Search</button>
										</form>
									<br>
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
												@if(!$freelancer==null)
												@foreach($freelancer as $index => $freelancers)
														<tr>
															<td>{{ $index+1 }}</td>
															<!-- <td>{{ $freelancers->referral_name }}</td> -->
															<td>{{ $freelancers->referral_email }}</td>
															<td>{{ $freelancers->referral_contact_no }}</td>
															@if($freelancers->fee == null)
															<td>N/A</td>
															@else
															<td>{{ $freelancers->fee }}</td>
															@endif
															<td>{{ $freelancers->job_position }}</td>
															@if($freelancers->admin_model == null )
															<td>-</td>
															@else
															<td>{{$freelancers->admin_model->first_name}}</td>
															@endif
															<td><a href ="{{ $freelancers->file_url }}" target="_blank">CV</a></td>
															<td>{{ $freelancers->referral_status }}</td>
															<td>
																@if(in_array("edit", $action))
																<a class="btn btn-sm btn-primary" href="{{ env('APP_URL', '').'/dashboard/freelancer/update/'.$freelancers->referral_id}}"><i class="cil-plus"></i>Update</a>
																<br><br>
																@elseif(in_array("edit-asAdmin", $action))
																<a class="btn btn-sm btn-primary" href="{{ env('APP_URL', '').'/dashboard/freelancer/adminupdate/'.$freelancers->referral_id}}"><i class="cil-plus"></i>Update</a>
																@endif
																@if(in_array("edit-status", $action))
																	<a class="btn btn-sm btn-primary" href="{{ env('APP_URL', '').'/dashboard/freelancer/update/'.$freelancers->referral_id.'/status'}}"><i class="cil-plus"></i>Status</a>
																@endif
															</td>
														</tr>
												@endforeach
												@endif
												</tbody>
											</table>
											
								</div>
							</div>
						</div>
					</div>
@else
				<div class="container-fluid">
						<div class="fade-in">
							<div class="card">
								<div class="card-header">
											<i class="fa fa-align-justify"></i>Dashboard Candidate
											<br>
											<br>
											@if(in_array("add", $action))
											<a class="btn btn-sm btn-primary" href="{{ env('APP_URL', '').'/dashboard/freelancer/create' }}"><i class="cil-plus"></i> Create Freelancer</a>
											@elseif(in_array("add-asAdmin", $action))
											<a class="btn btn-sm btn-primary" href="{{ env('APP_URL', '').'/dashboard/freelancer/admincreate' }}"><i class="cil-plus"></i> Create Freelancer</a>
											@endif
								</div>
								<div class="card-body">
										<form method="get" action="{{ env('APP_URL').'/dashboard/freelancer' }}">Status: 
											@csrf
												<select name="SortByStatus">
													<option value="All">All</option>
													<option value="Pending">Pending</option>
													<option value="InReview">InReview</option>
													<option value="Passed">Passed</option>
													<option value="NotPassed">Not Passed</option>
													<option value="Complete">Complete</option>
												</select>
												<button type="submit">Search</button>
										</form>
									<br>
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
												@if(!$freelancer==null)
												@foreach($freelancer as $index => $freelancers)
														<tr>
															<td>{{ $index+1 }}</td>
															<!-- <td>{{ $freelancers->referral_name }}</td> -->
															<td>{{ $freelancers->referral_email }}</td>
															<td>{{ $freelancers->referral_contact_no }}</td>
															@if($freelancers->fee == null)
															<td>N/A</td>
															@else
															<td>{{ $freelancers->fee }}</td>
															@endif
															<td>{{ $freelancers->job_position }}</td>
															@if($freelancers->admin_model == null )
															<td>-</td>
															@else
															<td>{{$freelancers->admin_model->first_name}}</td>
															@endif
															<td><a href ="{{ $freelancers->file_url }}" target="_blank">CV</a></td>
															<td>{{ $freelancers->referral_status }}</td>
															<td>
																@if(in_array("edit", $action))
																<a class="btn btn-sm btn-primary" href="{{ env('APP_URL', '').'/dashboard/freelancer/update/'.$freelancers->referral_id}}"><i class="cil-plus"></i>Update</a>
																<br><br>
																@elseif(in_array("edit-asAdmin", $action))
																<a class="btn btn-sm btn-primary" href="{{ env('APP_URL', '').'/dashboard/freelancer/adminupdate/'.$freelancers->referral_id}}"><i class="cil-plus"></i>Update</a>
																@endif
																@if(in_array("edit-status", $action))
																	<a class="btn btn-sm btn-primary" href="{{ env('APP_URL', '').'/dashboard/freelancer/update/'.$freelancers->referral_id.'/status'}}"><i class="cil-plus"></i>Status</a>
																@endif
															</td>
														</tr>
												@endforeach
												@endif
												</tbody>
											</table>
											
								</div>
							</div>
						</div>
					</div>
@endif
										
@endsection


@section('javascript')
		<script src="{{ asset('js/Chart.min.js') }}"></script>
		<script src="{{ asset('js/coreui-chartjs.bundle.js') }}"></script>
		<script src="{{ asset('js/main.js') }}" defer></script>
@endsection
