 @extends('layouts/contentLayoutMaster')

 @section('title', 'Account Settings')

 @section('vendor-style')
 <!-- vendor css files -->
 <link rel='stylesheet' href="{{ asset('vendors/css/forms/select/select2.min.css') }}">
 <link rel='stylesheet' href="{{ asset('vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
 @endsection
 @section('page-style')
 <!-- Page css files -->
 <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/pickers/form-pickadate.css') }}">
 <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
 <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-validation.css') }}">
 @endsection
 
 <script src="{{ mix('js/app.js') }}" defer></script>
  @livewireScripts

 @section('content')
 <!-- account setting page -->
 <section id="page-account-settings">
     <div class="row">
         <!-- left menu section -->
         <div class="col-md-3 mb-2 mb-md-0">
             <ul class="nav nav-pills flex-column nav-left">
                 <!-- general -->
                 <li class="nav-item">
                     <a class="nav-link active" id="account-pill-general" data-toggle="pill"
                         href="#account-vertical-general" aria-expanded="true">
                         <i data-feather="user" class="font-medium-3 mr-1"></i>
                         <span class="font-weight-bold">Informacion General</span>
                     </a>
                 </li>
                 <!-- change password -->
                 <li class="nav-item">
                     <a class="nav-link" id="account-pill-password" data-toggle="pill" href="#account-vertical-password"
                         aria-expanded="false">
                         <i data-feather="lock" class="font-medium-3 mr-1"></i>
                         <span class="font-weight-bold">Cambiar Constraseña</span>
                     </a>
                 </li>

             </ul>
         </div>
         <!--/ left menu section -->

         <!-- right content section -->
         <div class="col-md-9">
             <div class="card">
                 <div class="card-body">
                     <div class="tab-content">
                         <!-- general tab -->
                         <div role="tabpanel" class="tab-pane active" id="account-vertical-general"
                             aria-labelledby="account-pill-general" aria-expanded="true">
                             @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                             @livewire('profile.update-profile-information-form')
                             @endif
                         </div>
                         <!--/ general tab -->

                         <!-- change password -->
                         <div class="tab-pane fade" id="account-vertical-password" role="tabpanel"
                             aria-labelledby="account-pill-password" aria-expanded="false">
                             @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                             <div class="mt-10 sm:mt-0">
                                 @livewire('profile.update-password-form')
                             </div>
                             @endif
                         </div>
                         <!--/ change password -->

                     </div>
                 </div>
             </div>
         </div>
         <!--/ right content section -->
     </div>
 </section>
 <!-- / account setting page -->
 @endsection