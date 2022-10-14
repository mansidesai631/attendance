
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>@yield('title') | SRKS</title>

    @include('layouts.includes.head') 
</head>

<body>
  <!--Main Navigation-->
  <header>
    @include('layouts.includes.sidebar')
    @include('layouts.includes.header')
  </header>
  <!--Main Navigation-->

  <!--Main layout-->
  <main class="content-body">
    @yield('content')
  </main>
  <!--Main layout-->
    @include('layouts.includes.footer')
</body>

</html>