<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <section>
            <div class="container py-5">
    
                <div class="row">
                    <div class="col-md-12">
    
                        <div class="card" id="chat3" style="border-radius: 15px;">
                            <div class="card-body">
    
                                <div class="row">
                                    <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">
    
                                        <div class="p-3">
    
                                            <div class="input-group rounded mb-3">
                                                <input type="search" class="form-control rounded" placeholder="Search"
                                                    aria-label="Search" aria-describedby="search-addon" />
                                                <span class="input-group-text border-0" id="search-addon">
                                                    <i class="fas fa-search"></i>
                                                </span>
                                            </div>
                                            @foreach ( $users as $user)
                                               <div data-mdb-perfect-scrollbar-init style="position: relative;">
                                                <ul class="list-unstyled mb-0">
                                                    <li class="p-2 border-bottom">
                                                        <a href="{{ route('chat', $user->id) }}" class="d-flex justify-content-between">
                                                            <div class="d-flex flex-row">
                                                                <div>
                                                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                                                        alt="avatar" class="d-flex align-self-center me-3"
                                                                        width="60">
                                                                    <span class="badge bg-success badge-dot"></span>
                                                                </div>
                                                                <div class="pt-1">
                                                                    <p class="fw-bold mb-0">{{ $user->name }}</p>
                                                                    <p class="small text-muted">
                                                                    Xin chào</p>
                                                                </div>
                                                            </div>
                                                            <div class="pt-1">
                                                                <p class="small text-muted mb-1">Just now</p>
                                                                <span class="badge bg-danger rounded-pill float-end">3</span>
                                                            </div>
                                                        </a>
                                                    </li>
                                                  
                                                </ul>
                                            </div> 
                                            @endforeach
                                            
    
                                        </div>
    
                                    </div>
    
                                    {{-- <div class="col-md-6 col-lg-7 col-xl-8">
    
                                        <div class="pt-3 pe-3" data-mdb-perfect-scrollbar-init
                                            style="position: relative; height: 400px">
    
                                            <div class="d-flex flex-row justify-content-start">
                                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava6-bg.webp"
                                                    alt="avatar 1" style="width: 45px; height: 100%;">
                                                <div>
                                                    <p class="small p-2 ms-3 mb-1 rounded-3 bg-body-tertiary">Lorem ipsum
                                                        dolor
                                                        sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                                        ut labore et
                                                        dolore
                                                        magna aliqua.</p>
                                                    <p class="small ms-3 mb-3 rounded-3 text-muted float-end">12:00 PM | Aug 13
                                                    </p>
                                                </div>
                                            </div>
    
                                            <div class="d-flex flex-row justify-content-end">
                                                <div>
                                                    <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">Ut enim ad
                                                        minim veniam,
                                                        quis
                                                        nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                                        consequat.</p>
                                                    <p class="small me-3 mb-3 rounded-3 text-muted">12:00 PM | Aug 13</p>
                                                </div>
                                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                                    alt="avatar 1" style="width: 45px; height: 100%;">
                                            </div>
    
                                            
    
                                        </div>
    
                                        <div class="text-muted d-flex justify-content-start align-items-center pe-3 pt-3 mt-2">
                                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava6-bg.webp"
                                                alt="avatar 3" style="width: 40px; height: 100%;">
                                            <input type="text" class="form-control form-control-lg"
                                                id="exampleFormControlInput2" placeholder="Type message">
                                            <a class="ms-1 text-muted" href="#!"><i class="fas fa-paperclip"></i></a>
                                            <a class="ms-3 text-muted" href="#!"><i class="fas fa-smile"></i></a>
                                            <a class="ms-3" href="#!"><i class="fas fa-paper-plane"></i></a>
                                        </div>
    
                                    </div> --}}
                                    
                                </div>
    
                            </div>
                        </div>
    
                    </div>
                </div>
    
            </div>
        </section>
    </body>
</html>
