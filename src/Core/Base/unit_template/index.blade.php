@extends($global['base']['namespace'] . 'layouts.master')

@section('content')
    <div class="section-header">
        <h1>
            All Units
            <a class="btn btn-success" href="{{ route($global['module']['routes']['create']) }}">
                Create New Unit
            </a>
        </h1>
    </div>

    <div class="section-body">
        <h2 class="section-title">All Units</h2>
        <p class="section-lead">the list of the units</p>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>The List</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                                <caption class="d-none">units list</caption>
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>100</td>
                                        <td>Hello World!</td>
                                        <td>
                                            <a class="btn btn-info" href="#">
                                                <i class="fas fa-search" aria-hidden="true"></i>
                                            </a>
                                            <a class="btn btn-primary" href="#">
                                                <i class="fas fa-pencil-alt" aria-hidden="true"></i>
                                            </a>
                                            <a class="btn btn-danger" href="#">
                                                <i class="fas fa-trash-alt" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection