@extends('dashboard.layouts.app')
  
@section('contents')

    @include('dashboard.layouts.sidebar')
    
    <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-11 mx-auto">
                <div class="card">
                  <div class="padding-20">
                    <ul class="nav nav-tabs" id="myTab2" role="tablist">
                      <li class="nav-item">
                        
                        <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#sitesetting" role="tab"
                          aria-selected="true">Site Settings</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link " id="home-tab2" data-toggle="tab" href="#seosetting" role="tab"
                          aria-selected="false">Homepage cards</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#youtubefeedback" role="tab"
                          aria-selected="false">Youtube feedback</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#travelersetting" role="tab"
                          aria-selected="false">Traveler settings</a>
                      </li>
                      
                      <li class="nav-item">
                        <a class="nav-link " id="home-tab2" data-toggle="tab" href="#profilesetting" role="tab"
                          aria-selected="false">Profile Settings</a>
                      </li>
                      
                    </ul>
                    <div class="tab-content tab-bordered" id="myTab3Content">

                      <div class="tab-pane fade show active" id="sitesetting" role="tabpanel" aria-labelledby="home-tab2">
                        
                        <form id="SiteSettingForm" enctype="multipart/form-data">
                          <div class="card-header">
                            <h4>Update Site Settings</h4>
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="form-group col-md-6 col-12">
                                <label>Site title</label>
                                <input type="text" name="title" class="form-control" value="{{ $siteSetting->title }}">
                              </div>
                              <div class="form-group  col-md-6 col-12">
                                <img src="/uploads/settings/{{ $siteSetting->logo }}" alt="" style="width: 200px; height: auto">
                              </div>
                              <div class="form-group  col-md-6 col-12">
                                
                                <label>Site logo</label>
                                <input type="file" name="logo" class="form-control">
                              </div>
                            </div>

                            
                            <div class="row">
                              <div class="form-group col-12">
                                <label>Meta keyword</label>
                                <input type="text" name="meta_keyword" class="form-control" value="{{ $siteSetting->meta_keyword }}">
                              </div>
                              <div class="form-group col-12">
                                <label>Meta Description</label>
                                 <textarea class="form-control" name="meta_description" style="height: 110px !important">{{$siteSetting->meta_description}}</textarea>
                              </div>
                              <div class="form-group col-md-6 col-12">
                                <label>Delivery charge for dhaka</label>
                                <input type="number" name="delivery_dhaka" class="form-control" value="{{ $siteSetting->delivery_dhaka }}">
                              </div>
                              <div class="form-group col-md-6 col-12">
                                <label>Delivery charge for outside dhaka</label>
                                <input type="number" name="delivery_outside" class="form-control" value="{{ $siteSetting->delivery_outside }}">
                              </div>
                            </div>
                            

                            <div class="row">
                              <h2 class="col-12 mt-2" style="font-size: 16px">Homepage banner</h2>

                              <div class="form-group col-12">
                                <label>Banner title</label>
                                <input type="text" name="banner_title" class="form-control" value="{{ $siteSetting->banner_title }}">
                              </div>
                              <div class="form-group col-12">
                                <label>Banner description</label>
                                <textarea class="form-control" name="banner_paragraph" style="height: 110px !important">{{$siteSetting->banner_paragraph}}</textarea>
                              </div>
                              <div class="form-group col-md-6 col-12">
                                <label>Banner link</label>
                                <input type="url" name="banner_url" class="form-control" value="{{ $siteSetting->banner_link }}">
                              </div>
                              <div class="form-group col-md-6 col-12">
                                <label>Banner button text</label>
                                <input type="text" name="banner_btn" class="form-control" value="{{ $siteSetting->banner_btn }}">
                              </div>
                              <img src="/uploads/settings/{{ $siteSetting->banner_image }}" alt="" style="width: 100%; height: 220px">
                              <div class="form-group col-12">
                                <label>Banner image</label>
                                <input type="file" name="banner_image" class="form-control">
                              </div>
                            </div>

                            <div class="row">
                              <h2 class="col-12 mt-2" style="font-size: 18px">Footer Deatils</h2>
                            </div>

                            <div class="row">
                              <div class="form-group col-md-6 col-12">
                                <label>Service phone</label>
                                <input type="number" name="service_phone" class="form-control" value="{{ $siteSetting->service_phone }}">
                              </div>
                              <div class="form-group  col-md-6 col-12">
                                <label>Service email</label>
                                <input type="email" name="service_email" class="form-control" value="{{ $siteSetting->service_email }}">
                              </div>
                              <div class="form-group  col-12">
                                <label>Office time</label>
                                <input type="text" name="office_time" class="form-control" value="{{ $siteSetting->office_time }}">
                              </div>
                            </div>

                            <div class="row">
                              <div class="form-group col-12">
                                <label>small paragraph about this site</label>
                                <textarea class="form-control" name="footer_paragraph" style="height: 110px !important">{{$siteSetting->footer_desc}}</textarea>
                              </div>
                            </div>

                            <div class="row">
                              <h2 class="col-12 mt-2" style="font-size: 16px">Social links</h2>
                              <div class="form-group col-sm-12 col-md-4">
                                <label>Facebook link</label>
                                <input type="url" class="form-control" name="facebook_url" value="{{ $siteSetting->facebook_url }}">
                              </div>

                              <div class="form-group col-sm-12 col-md-4">
                                <label>Youtube link</label>
                                <input type="url" class="form-control" name="youtube_url" value="{{ $siteSetting->youtube_url }}">
                              </div>

                              <div class="form-group col-sm-12 col-md-4">
                                <label>Whatsapp link</label>
                                <input type="url" class="form-control" name="whatsapp_url" value="{{ $siteSetting->whatsapp_url }}">
                              </div>
                            </div>

                          </div>
                          <div class="card-footer text-right">
                            <button class="btn btn-primary">Save Changes</button>
                          </div>
                        </form>
                      </div>
                      
                      <div class="tab-pane fade" id="youtubefeedback" role="tabpanel" aria-labelledby="profile-tab2">
                        <form id="updateFeedback" >
                          <div class="card-header">
                            <h4>Youtube feedbacks</h4>
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="form-group col-md-6 col-12">
                                <label>Feedback 1 (embed url)</label>
                                <input type="text" name="feedback1" class="form-control" value="{{ $youtubeFeedback->feedback1 }}">
                              </div>
                              <div class="form-group col-md-6 col-12">
                                <label>Feedback 1 Shopper name</label>
                                <input type="text" name="shopper1" class="form-control" value="{{ $youtubeFeedback->shopper1 }}">
                              </div>
                              <div class="form-group col-md-6 col-12">
                                <label>Feedback 2 (embed url)</label>
                                <input type="text" name="feedback2" class="form-control" value="{{ $youtubeFeedback->feedback2 }}">
                              </div>
                              <div class="form-group col-md-6 col-12">
                                <label>Feedback 2 Shopper name</label>
                                <input type="text" name="shopper2" class="form-control" value="{{ $youtubeFeedback->shopper2 }}">
                              </div>
                              <div class="form-group col-md-6 col-12">
                                <label>Feedback 3 (embed url)</label>
                                <input type="text" name="feedback3" class="form-control" value="{{ $youtubeFeedback->feedback3 }}">
                              </div>
                              <div class="form-group col-md-6 col-12">
                                <label>Feedback 3 Shopper name</label>
                                <input type="text" name="shopper3" class="form-control" value="{{ $youtubeFeedback->shopper3 }}">
                              </div>
                            </div>

                          </div>
                          <div class="card-footer text-right">
                            <button class="btn btn-primary">Save Changes</button>
                          </div>
                        </form>
                      </div>

                      <div class="tab-pane fade" id="travelersetting" role="tabpanel" aria-labelledby="profile-tab2">
                        <form id="updateTravelerSetting">
                          <div class="card-header">
                            <h4>Traveler settings</h4>
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="form-group col-md-6 col-12">
                                <label>Traveler title</label>
                                <input type="text" name="traveler_heading" class="form-control" value="{{ $travelerSetting->traveler_heading }}">
                              </div>
                              <div class="form-group col-md-6 col-12">
                                <label>Traveler short description</label>
                                <input type="text" name="traveler_desc" class="form-control" value="{{ $travelerSetting->traveler_desc }}">
                              </div>

                              <div class="form-group col-12">
                              @if ($travelerSetting->traveler_banner != null)
                                  <img src="/uploads/settings/{{ $travelerSetting->traveler_banner }}" alt="" style="width:100%; height: auto">
                              @else
                                  <p class="text-danger">Banner not selected!</p>
                              @endif
                              </div>
                              <div class="form-group col-12">
                                <label>Traveler banner image</label>
                                <input type="file" name="traveler_banner" class="form-control" value="{{ $travelerSetting->traveler_banner }}">
                              </div>

                              <div class="form-group col-12">
                                <label>Youtube introduction title</label>
                                <input type="text" name="youtube_title" class="form-control" value="{{ $travelerSetting->youtube_title }}">
                              </div>

                              <div class="form-group col-12">
                                <label>Youtube video embed link</label>
                                <input type="url" name="youtube_video" class="form-control" value="{{ $travelerSetting->youtube_video }}">
                              </div>
                              <div class="form-group col-12">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control" value="{{ $travelerSetting->title }}">
                              </div>
                              <div class="form-group col-12">
                                <label>Meta keyword</label>
                                <input type="text" name="meta_keyword" class="form-control" value="{{ $travelerSetting->meta_keyword }}">
                              </div>
                              <div class="form-group col-12">
                                <label>Meta Description</label>
                                <textarea  name="meta_description" class="form-control" >{{ $travelerSetting->meta_description }}</textarea>
                              </div>


                            </div>
                          </div>
                          <div class="card-footer text-right">
                            <button class="btn btn-primary">Save Changes</button>
                          </div>
                        </form>
                      </div>

                      <div class="tab-pane fade" id="seosetting" role="tabpanel" aria-labelledby="profile-tab2">
                        <form id="updateCards" >
                          <div class="card-header d-flex justify-contents-between align-items-center">
                              <h4>Home page card setting</h4>
                              <div class="card-header-action">
                                <div class="dropdown d-inline">
                                  <button class="btn btn-{{ $homeCard->status == 'published' ? 'success' : 'danger' }} dropdown-toggle" type="button" id="dropdownMenuButton2"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Update status
                                  </button>
                                  <div class="dropdown-menu">
                                    @if ($homeCard->status == 'pending')
                                      <a class="dropdown-item has-icon" href="javascript:void(0)" type="button" onclick="disableCard()"><i class="far fa-check-circle"></i>Enable</a>
                                    @else
                                      <a class="dropdown-item has-icon" href="javascript:void(0)" type="button" onclick="disableCard()"><i class="far fa-times-circle"></i>Disable</a>
                                    @endif
                                  </div>
                                </div>
                              </div>
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="form-group col-md-6 col-12">
                                <label>Card 1 title</label>
                                <input type="text" name="title1" class="form-control" value="{{ $homeCard->title1 }}">
                              </div>
                              <div class="form-group col-md-6 col-12">
                                <label>Card 1 description</label>
                                <input type="text" name="desc1" class="form-control" value="{{ $homeCard->desc1 }}">
                              </div>
                            </div>
                            <div class="row">
                              <div class="form-group col-md-6 col-12">
                                <label>Card 2 title</label>
                                <input type="text" name="title2" class="form-control" value="{{ $homeCard->title2 }}">
                              </div>
                              <div class="form-group col-md-6 col-12">
                                <label>Card 2 description</label>
                                <input type="text" name="desc2" class="form-control" value="{{ $homeCard->desc2 }}">
                              </div>
                            </div>
                            <div class="row">
                              <div class="form-group col-md-6 col-12">
                                <label>Card 3 title</label>
                                <input type="text" name="title3" class="form-control" value="{{ $homeCard->title3 }}">
                              </div>
                              <div class="form-group col-md-6 col-12">
                                <label>Card 3 description</label>
                                <input type="text" name="desc3" class="form-control" value="{{ $homeCard->desc3 }}">
                              </div>
                            </div>
                            <div class="row">
                              <div class="form-group col-md-6 col-12">
                                <label>Card 4 title</label>
                                <input type="text" name="title4" class="form-control" value="{{ $homeCard->title4 }}">
                              </div>
                              <div class="form-group col-md-6 col-12">
                                <label>Card 4 description</label>
                                <input type="text" name="desc4" class="form-control" value="{{ $homeCard->desc4 }}">
                              </div>
                            </div>
                          </div>
                          <div class="card-footer text-right">
                            <button class="btn btn-primary" type="submit">Save Changes</button>
                          </div>
                        </form>
                      </div>
                      
                      <div class="tab-pane fade" id="profilesetting" role="tabpanel" aria-labelledby="profile-tab2">

                        <form id="ProfileUpdate" >
                          @php
                            $admin = Auth::guard('admin')->user();
                          @endphp
                          <div class="card-header">
                                <h4>Profile settings</h4>
                              </div>
                            <div class="form-group col-12">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $admin->name }}">
                            </div>
                        
                            <div class="form-group  col-12">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $admin->email }}">
                            </div>
                            <div class="form-group  col-12">
                            <label>Security question answer</label>
                            <input type="text" name="security_question" class="form-control" value="{{ $admin->security_question }}">
                            </div>
                            <div class="form-group  col-12">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">
                            </div>
                            <div class="form-group  col-12">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control" value="{{ $admin->address }}">
                            </div>
                            <div class="form-group col-12">
                            <label>Phone</label>
                            <input type="number" name="phone" class="form-control" value="{{ $admin->phone }}">
                            </div>
                        
                            <div class="form-group mb-0 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="remember" class="custom-control-input" id="newsletter">
                                <label class="custom-control-label" for="newsletter">Confirm changes</label>
                                <div class="text-muted form-text">
                                Changing password can be cause of harm
                                </div>
                            </div>
                            </div>
                            <div class="text-right mb-4 mr-4">
                            <button class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

      </div>
  
@endsection


@section('customJs')
    <script>
      //update card status
      function disableCard(e){
        $.ajax({
          url: '{{ route('update.cards') }}',
          type: 'post',
          data: {job: 'disableCard',},
          success: function(response){
            if(response.status == false){
                  Swal.fire({
                      icon: 'warning',
                      title: 'warning',
                      text: response.errors,
                      showCancelButton: false,
                  });

              }else if(response.status == true){
                  Swal.fire({
                    icon: 'success',
                    title: 'success',
                    text: response.message,
                    showCancelButton: false,
                    confirmButtonText: 'Confirm'
                  });
              }
          },
          error: function(error){
            Swal.fire({
                icon: 'error',
                title: 'An error occurred',
                text: 'Something went wrong, try later',
                showCancelButton: true,
                confirmButtonText: 'Try again',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.reload();
                }
            });
          }
        })
      }
      // updateCards
      $('#updateCards').on('submit', function(e){
        e.preventDefault();
        var formdata = $(this).serializeArray();
        $('#SaveBtn').prop('disabled', true);
        $.ajax({
            url: '{{ route('update.cards') }}',
            type: 'post',
            data: formdata,
            success: function(response){
                $('#SaveBtn').prop('disabled', false);

                if(response.status == false){
                    Swal.fire({
                        icon: 'warning',
                        title: 'warning',
                        text: response.errors,
                        showCancelButton: false,
                    });

                }else if(response.status == true){
                    Swal.fire({
                      icon: 'success',
                      title: 'success',
                      text: response.message,
                      showCancelButton: false,
                      confirmButtonText: 'Confirm',
                      preConfirm: () => {
                        window.location.reload();
                      }
                    });
                }
            },
            error: function(error){
              Swal.fire({
                  icon: 'error',
                  title: 'An error occurred',
                  text: 'Something went wrong, try later',
                  showCancelButton: true,
                  confirmButtonText: 'Try again',
              }).then((result) => {
                  if (result.isConfirmed) {
                      window.location.reload();
                  }
              });
            }
        });
      });
    </script>
    <script>
      // update profile
      $('#ProfileUpdate').on('submit', function(e){
            e.preventDefault();
            var formdata = new $(this).serializeArray();
            $('#SaveBtn').prop('disabled', true);
            $.ajax({
                url: "{{ route('update.profile', Auth::guard('admin')->id()) }}",
                type: 'put',
                data: formdata,
                success: function(response){
                    $('#SaveBtn').prop('disabled', false);

                    if(response.status == false){
                        Swal.fire({
                            icon: 'warning',
                            title: 'warning',
                            text: response.errors,
                            showCancelButton: false,
                        });

                    }else if(response.status == true){
                        Swal.fire({
                          icon: 'success',
                          title: 'success',
                          text: response.message,
                          showCancelButton: false,
                          confirmButtonText: 'Confirm'
                        });
                    }
                },
                error: function(error){
                  Swal.fire({
                      icon: 'error',
                      title: 'An error occurred',
                      text: 'Something went wrong, try later',
                      showCancelButton: true,
                      confirmButtonText: 'Try again',
                  }).then((result) => {
                      if (result.isConfirmed) {
                          window.location.reload();
                      }
                  });
                }
            })
      });

      // update site setting
      $('#SiteSettingForm').on('submit', function(e){
          e.preventDefault();
          var formdata = new FormData(this);
        
          $('#SaveBtn').prop('disabled', true);

          $.ajax({
              url: "{{ route('update.siteSettings') }}",
              type: 'post',
              data: formdata,
              contentType: false,
              processData: false,
              success: function(response){
                  console.log("Success Response:", response);
                  $('#SaveBtn').prop('disabled', false);

                  if(response.status == false){
                      Swal.fire({
                          icon: 'warning',
                          title: 'Warning',
                          text: response.errors,
                          showCancelButton: false,
                      });
                  } else if(response.status == true){
                      Swal.fire({
                          icon: 'success',
                          title: 'Success',
                          text: response.message,
                          showCancelButton: false,
                          confirmButtonText: 'Confirm',
                      }).then((result) => {
                      if (result.isConfirmed) {
                          window.location.reload();
                      }
                      });
                  }
              },
              error: function(error){
                  console.log("Error Response:", error);
                  Swal.fire({
                      icon: 'error',
                      title: 'An error occurred',
                      text: 'Something went wrong, try later',
                      showCancelButton: true,
                      confirmButtonText: 'Try again',
                  }).then((result) => {
                      if (result.isConfirmed) {
                          window.location.reload();
                      }
                  });
              }
          });
      });

      // update youtube feedbacks
      $('#updateFeedback').on('submit', function(e){
            e.preventDefault();
            var formdata = new $(this).serializeArray();
            $('#SaveBtn').prop('disabled', true);
            $.ajax({
                url: "{{ route('update.feedback') }}",
                type: 'post',
                data: formdata,
                success: function(response){
                    $('#SaveBtn').prop('disabled', false);

                    if(response.status == false){
                        Swal.fire({
                            icon: 'warning',
                            title: 'warning',
                            text: response.errors,
                            showCancelButton: false,
                        });

                    }else if(response.status == true){
                        Swal.fire({
                          icon: 'success',
                          title: 'success',
                          text: response.message,
                          showCancelButton: false,
                          confirmButtonText: 'Confirm',
                          preConfirm: () => {
                            window.location.reload();
                          }
                        });
                    }
                },
                error: function(error){
                  Swal.fire({
                      icon: 'error',
                      title: 'An error occurred',
                      text: 'Something went wrong, try later',
                      showCancelButton: true,
                      confirmButtonText: 'Try again',
                  }).then((result) => {
                      if (result.isConfirmed) {
                          window.location.reload();
                      }
                  });
                }
            })
      });

      // update traveler settings      
      $('#updateTravelerSetting').on('submit', function(e){
          e.preventDefault();
          var formdata = new FormData(this);

          $('#SaveBtn').prop('disabled', true);

          $.ajax({
              url: "{{ route('update.traveler') }}",
              type: 'post',
              data: formdata,
              contentType: false,
              processData: false,
              success: function(response){
                  console.log("Success Response:", response);
                  $('#SaveBtn').prop('disabled', false);

                  if(response.status == false){
                      Swal.fire({
                          icon: 'warning',
                          title: 'Warning',
                          text: response.errors,
                          showCancelButton: false,
                      });
                  } else if(response.status == true){
                      Swal.fire({
                          icon: 'success',
                          title: 'Success',
                          text: response.message,
                          showCancelButton: false,
                          confirmButtonText: 'Confirm',
                      }).then((result) => {
                      if (result.isConfirmed) {
                          window.location.reload();
                      }
                      });
                  }
              },
              error: function(error){
                  console.log("Error Response:", error);
                  Swal.fire({
                      icon: 'error',
                      title: 'An error occurred',
                      text: 'Something went wrong, try later',
                      showCancelButton: true,
                      confirmButtonText: 'Try again',
                  }).then((result) => {
                      if (result.isConfirmed) {
                          window.location.reload();
                      }
                  });
              }
          });
      });

      

    </script>
@endsection