@extends($global['base']['namespace'] . 'layouts.master')

@section('content')
    <div class="section-header">
        <h1>
            Unit Details
            <a class="btn btn-success" href="{{ route($global['module']['routes']['index']) }}">
                Go To All Units
            </a>
        </h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Unit Info</h4>
                    </div>
                    <div class="card-body">
                        <p class="mb-1">
                            <strong class="text-capitalize">#</strong> <br>
                            100
                        </p>

                        <p class="mb-1">
                            <strong class="text-capitalize">Name</strong> <br>
                            Hello World!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
