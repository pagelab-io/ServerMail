@if(session()->has('status'))
                    <div class="alert alert-{{ session('level') }}">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                        {{ session('status') }}
                    </div>
@endif
