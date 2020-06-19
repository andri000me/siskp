@if(isset($admin))
    {!! Form::hidden('id', $admin->id) !!}
@endif
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nama</label>
                                    {!! Form::text('nama', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Username</label>
                                    {!! Form::text('username', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Password</label>
                                    {!! Form::password('password', ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-paper-plane"></span> Submit</button>
                                </div>
                            </div>