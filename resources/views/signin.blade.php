<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
  {{-- <meta name="csrf-token" content="{{ csrf_token() }}">--}} 
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="{{asset('assets/vendor/css/core.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/demo.css')}}" />

</head>
<body>


    <div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner d-flex justify-content-center">
      <!-- Register -->
      <div class="card px-sm-6 px-0" style="max-width: 400px; width: 100%;">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="index.html" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">
                <img src="{{ asset('favicon.png') }}" width="200" height="150" alt="Logo">
              </span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-1 text-center">Welcome to Amazing Fitness Gym</h4>
          <p class="mb-6 text-center">Please sign-in to your account and start the adventure</p>

          <form action="/signin" method="post" class="mb-6">
            <div class="mb-6">
              <label for="email" class="form-label">Email or Username</label>
              <input
                type="text"
                class="form-control"
                id="email"
                name="email"
                placeholder="Enter your email or username"
                autofocus />
            </div>
            <div class="mb-6 form-password-toggle">
              <label class="form-label" for="password">Password</label>
              <div class="input-group input-group-merge">
                <input
                  type="password"
                  id="password"
                  class="form-control"
                  name="password"
                  placeholder="••••••••••••"
                  aria-describedby="password" />
                <span class="input-group-text cursor-pointer">
                  <i class="icon-base bx bx-hide"></i>
                </span>
              </div>
            </div>
            <div class="mb-6">
              <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
            </div>
          </form>
          <p>
                @if ($errors->any())
                        <div>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <p style="color:red">{{ $error }}</p>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </p>
        </div>
      </div>
      <!-- /Register -->
    </div>
  </div>
</div>






</body>
</html>
