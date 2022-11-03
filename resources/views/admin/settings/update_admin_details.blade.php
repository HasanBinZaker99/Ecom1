@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Settings</h3>

                        <!-- $data = session()->all();
        echo "<pre>";
          print_r($data);
          die(); -->
                        <!-- @endphp -->



                        <!-- $d = Auth::guard('admin')->user();
                        echo "<pre>";
                        print_r($d);
                        die(); -->
                        <!-- @endphp -->


                        <!-- <h6 class="font-weight-normal mb-0">Update Admin Password</h6> -->
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="justify-content-end d-flex">
                            <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                    <a class="dropdown-item" href="#">January - March</a>
                                    <a class="dropdown-item" href="#">March - June</a>
                                    <a class="dropdown-item" href="#">June - August</a>
                                    <a class="dropdown-item" href="#">August - November</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        @if(Session::has('error_message'))
                        <div class="alert alert-danger alert-dismissible fade show " id="errorMessage" role="alert">
                            <strong>Error:</strong>
                            {{ Session::get('error_message')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        @if(Session::has('Success_message'))
                        <div class="alert alert-success alert-dismissible fade show " id="errorMessage" role="alert">
                            <strong>Success:</strong>
                            {{ Session::get('Success_message')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">

                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        <h4 class="card-title">Update Admin Details</h4>
                        <form class="forms-sample" action=" {{ url('admin/update-admin-details') }} " method="POST" name="updateAdminPasswordForm" id="updateAdminPasswordForm" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputUsername1">Admin Username/Email</label>
                                <input class="form-control" value="{{ Auth::guard('admin')->user()->email  }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Admin Type</label>
                                <input class="form-control" value="{{ Auth::guard('admin')->user()->type  }}">
                            </div>
                            <div class="form-group">
                                <label for="Name">Name</label>
                                <input type="text" class="form-control" value="{{ Auth::guard('admin')->user()->name  }}" name="admin_name" id="Name" placeholder="Enter Current Name" required>
                                <span id="check_password"></span>
                            </div>
                            <div class="form-group">
                                <label for="Mobile">Mobile</label>
                                <input type="text" value="{{ Auth::guard('admin')->user()->mobile }}" class="form-control" id="Mobile" placeholder="Enter 11 digit mobile number" name="admin_mobile" required minlength="9" maxlength="11">
                            </div>
                            <div class="form-group">
                                <label for="Mobile">Admin Photo</label>
                                <input type="file" value="{{ Auth::guard('admin')->user()->image }}" class="form-control" id="Mobile" name="admin_image" required>
                                @if(!empty(Auth::guard('admin')->user()->image))
                                <img src="{{ url('admin/images/photos/'.Auth::guard('admin')->user()->image)  }}" width="300px" height="200px"></img> <br>
                                <a target="_blank" href="{{ url('admin/images/photos/'.Auth::guard('admin')->user()->image)  }}">View Image with new tab</a>
                                <input type="hidden" name="current_admin_image" value="{{ Auth::guard('admin')->user()->image }}">
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <button class="btn btn-light">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>
@endsection