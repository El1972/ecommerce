

                                {{--CDN--}}

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

                                {{--CDN--}}



                                {{--NAVBAR--}}
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>
                                {{--NAVBAR--}}



<body>
<h1 class="my-5 text-center">Todos List</h1>
<ul class="list-group">
    @foreach($todos as $todo)
        <div class="container">
            <li class="list-group-item">
                {{$todo->description}}
                <a href="todos/{{$todo->id}} " class="btn btn-primary btn-sm float-end">View</a>
            </li>
        </div>
    @endforeach
</ul>
</body>


<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-default">
            <div class="card-body">
                <form action="/store-todos" method="POST">
                    @csrf
                    <input type="text" class="form-control" name="name">
                    <textarea name="description" id="" cols="30" rows="10" class="form-control"></textarea>
                    <div class="text-center my-3">  {{-- centers the button --}}
                        <button type="submit" class="btn btn-success btn-sm">Create Todo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>