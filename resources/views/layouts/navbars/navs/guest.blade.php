<nav class="navbar navbar-top navbar-horizontal navbar-expand-md navbar-dark">
    <div class="container px-4">
        <a class="navbar-brand" href="{{ route('home') }}">
            <h1 class="text-secondary" style="font-family: 'Baloo Chettan', cursive;">
                <strong>
                    emp <i class="ni ni-circle-08"></i> me
                </strong>
            </h1>
            {{--<img src="{{ asset('argon') }}/img/brand/white.png" />--}}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse-main" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <h1 class="text-primary" style="font-family: 'Baloo Chettan', cursive;">
                                <strong>
                                    emp <i class="ni ni-circle-08"></i> me
                                </strong>
                            </h1>
{{--                            <img src="{{ asset('argon') }}/img/brand/blue.png">--}}
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
