@if(!$errors->isEmpty())
    @foreach($errors->all() as $error)

        <div class="alert alert-danger" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Error!</strong> {{ $error }}
        </div>
    @endforeach

@endif