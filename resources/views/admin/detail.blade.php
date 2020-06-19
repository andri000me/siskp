@extends('template')
@section('main')
                @include('errors.form_error')

                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Detail Admin</strong>
                        <a class="text-white" href="{{ url('admin/'.Session::get('id').'/edit') }}"><span class="fa fa-edit"></span> <span class="">Edit</span></a>
                    </div>

                    <!-- jika data ada -->
                    <div class="card-body border-bottom mb-0 pb-0">
                        <dl>
                            <dt>Nama</dt>
                            <dd>{{ $admin->nama }}</dd>

                            <dt>Username</dt>
                            <dd>{{ $admin->username }}</dd>

                        </dl>
                    </div>

                </div>
            
@stop