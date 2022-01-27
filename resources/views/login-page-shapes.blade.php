@extends('layouts.app')
@push('css')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"--}}
    {{--          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">--}}
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet">
    <link rel="stylesheet" href="{{mix('dist/css/login-page-shapes.css')}}">
@endpush
@section('content')

<html lang="en">

    <body>
        <main>
            <div class="form-page">
                <form class="content">
                    <h2 class="text-center mb-5">{{__('messages.sign-in')}}</h2>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input type="email" class="form-control" placeholder="Πληκτρολογήστε το mail σας"
                            id="exampleInputEmail1" aria-describedby="emailHelp">

                    </div>
                    <div class="mb-5">
                        <label for="exampleInputPassword1" class="form-label">{{__('messages.password')}}</label>
                        <input type="password" class="form-control" placeholder="Πληκτρολογήστε τον κωδικό πρόσβασής σας"
                            id="exampleInputPassword1">
                    </div>
                    <button type="submit" class="btn btn-primary mb-5 mt-3">{{__('messages.sign-in')}}</button>
                    <hr class="mt-5">
                    <p class="text-center"> Δεν έχετε λογαριασμό; <a href="#">Κάντε εγγραφή εδώ.</a></p>
                </form>
            </div>
        </main>
    </body>

</html>

@endsection
@push('scripts')
    <script src="{{ mix('dist/js/create-edit-resource.js') }}"></script>
@endpush
