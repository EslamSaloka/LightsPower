@if($errors->any())
    <div class="alert alert-danger alert-dismissible handel-error-message fade show" role="alert">
        <ul>
            @foreach ($errors->all() as $err)
            <li class="font-weight-bold">
                {!!  $err !!}
            </li>
            @endforeach
        </ul>
    </div>
@endif