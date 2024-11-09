<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Bootstrap News Template - Free HTML Templates</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="Bootstrap News Template - Free HTML Templates" name="keywords">
        <meta content="Bootstrap News Template - Free HTML Templates" name="description">

        <!-- Favicon -->
        <link href="{{asset('img/favicon.ico')}}" rel="icon">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600&display=swap" rel="stylesheet"> 

        <!-- CSS Libraries -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="{{asset('lib/slick/slick.css')}}" rel="stylesheet">
        <link href="{{asset('lib/slick/slick-theme.css')}}" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="{{asset('css/style.css')}}" rel="stylesheet">
    </head>

    <body>
        <!-- Top Bar Start -->
        {{-- <div class="top-bar">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="tb-contact">
                            <p><i class="fas fa-envelope"></i>info@mail.com</p>
                            <p><i class="fas fa-phone-alt"></i>+012 345 6789</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="tb-menu">
                            <a href="">About</a>
                            <a href="">Privacy</a>
                            <a href="">Terms</a>
                            <a href="">Contact</a>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- Top Bar Start -->
        
        <!-- Brand Start -->
        <div class="brand">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4">
                        <div class="b-logo">
                            <a href="index.html">
                                <img src="{{asset('img/logo.png')}}" alt="Logo">
                            </a>
                        </div>
                    </div>
                     {{-- <div class="col-lg-4 col-md-4">
                        <div class="b-ads">
                            <a href="https://htmlcodex.com">
                                <img src="{{asset('img/ads-1.jpg')}}" alt="Ads">
                            </a>
                        </div>
                    </div> --}}
                    <div class="relative inline-block text-left" style="margin-top: 10px;">
                        <div class="absolute right-0 mt-2 w-32 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10 hidden">
                            <a href="{{ route('prefix.set', ['lang' => 'en']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <span class="inline-flex items-center">
                                    🇺🇸 English
                                </span>
                            </a>
                            <a href="{{ route('prefix.set', ['lang' => 'uz']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <span class="inline-flex items-center">
                                    🇺🇿 Uzbek
                                </span>
                            </a>
                        </div>
                    </div>


                    <div class="col-lg-3 col-md-4" style="position: relative">
                        <div class="b-search">
                            <input type="text" placeholder="@lang('message.search')">
                            <button id="search__btn"><i class="fa fa-search"></i></button>
                        </div>
                        <div id="box" style=" display: none;">
    
                        </div>                        
                    </div>
                    
                    
                    
                </div>
            </div>
        </div>
        <!-- Brand End -->

        <!-- Nav Bar Start -->
        <div class="nav-bar">
            <div class="container">
                <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                    <a href="#" class="navbar-brand">MENU</a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto">
                            <a href="{{route('front.index')}}" class="nav-item nav-link">@lang('message.home')</a>
                            {{-- <a href="#" class="nav-item nav-link">Home</a> --}}                        
                            @foreach ($categories as $category)
                            <a href="{{env('APP_URL') . "/" . app()->getLocale() . "/posts/show/" .$category->id}}" class="nav-item nav-link">{{$category->name}}</a>
                            @endforeach
                        </div>   
                        <div class="social ml-auto">
                            <a href=""><i class="fab fa-twitter"></i></a>
                            <a href=""><i class="fab fa-facebook-f"></i></a>
                            <a href=""><i class="fab fa-linkedin-in"></i></a>
                            <a href=""><i class="fab fa-instagram"></i></a>
                            <a href=""><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Nav Bar End -->
        <main>
            @yield('content')
        </main>
        <div class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h3 class="title">@lang('message.getInTouch')</h3>
                            <div class="contact-info">
                                <p><i class="fa fa-map-marker"></i>123 News Street, NY, USA</p>
                                <p><i class="fa fa-envelope"></i>info@example.com</p>
                                <p><i class="fa fa-phone"></i>+123-456-7890</p>
                                <div class="social">
                                    <a href=""><i class="fab fa-twitter"></i></a>
                                    <a href=""><i class="fab fa-facebook-f"></i></a>
                                    <a href=""><i class="fab fa-linkedin-in"></i></a>
                                    <a href=""><i class="fab fa-instagram"></i></a>
                                    <a href=""><i class="fab fa-youtube"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h3 class="title">@lang('message.usefulLinks')</h3>
                            <ul>
                                <li><a href="#">Lorem ipsum</a></li>
                                <li><a href="#">Pellentesque</a></li>
                                <li><a href="#">Aenean vulputate</a></li>
                                <li><a href="#">Vestibulum sit amet</a></li>
                                <li><a href="#">Nam dignissim</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h3 class="title">@lang('message.quickLinks')</h3>
                            <ul>
                                <li><a href="#">Lorem ipsum</a></li>
                                <li><a href="#">Pellentesque</a></li>
                                <li><a href="#">Aenean vulputate</a></li>
                                <li><a href="#">Vestibulum sit amet</a></li>
                                <li><a href="#">Nam dignissim</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h3 class="title">@lang('message.newsletter')</h3>
                            <div class="newsletter">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sed porta dui. Class aptent taciti sociosqu
                                </p>
                                <form>
                                    <input class="form-control" type="email" placeholder="@lang('message.yourEmail')">
                                    <button class="btn border">@lang('message.submit')</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->
       
        <!-- Back to Top -->
        <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="{{asset('lib/easing/easing.min.js')}}"></script>
        <script src="{{asset('lib/slick/slick.min.js')}}"></script>

        <!-- Template Javascript -->
        <script src="{{asset('js/main.js')}}"></script>
        <script>

            const currentPath = window.location.pathname;
            const activePath = (currentPath.split('/')[1] ?? "") + (currentPath.split('/')[2]??"");
            const navLinks = document.querySelectorAll('.nav-item.nav-link');
            navLinks.forEach(link => {
                const linkPath = (link.getAttribute('href').split('/')[3] ?? "") + (link.getAttribute('href').split('/')[4] ?? "");
                if (linkPath === activePath) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active'); 
                }
            });
            const fake = [
                {
                    name: "title"
                },
                {
                    name: "titl2"
                },
                {
                    name: "title3"
                },
            ]
            const searchBtn = document.getElementById("search__btn");
            
            window.addEventListener('click', function(e){   
                if (document.getElementById('box').contains(e.target)){
                // Clicked in box
                
                console.log("inside box")
                closeBox()
            } else{
                
                // Clicked outside the box
                if(searchBtn.contains(e.target)) {
                    isClicked = true
                    console.log("tar box") 
                    const box = document.getElementById("box")
                    box.innerHTML = ""
                    box.style = "display: block; border: 1px solid red; position: absolute; z-index: 10; background: white; width: calc(100% - 30px); padding-left: 10px;"
                    fake.forEach((item) => {
                        const a = document.createElement("a")
                        a.style = "display: block; margin: 5px 0"
                        // a.href = item.name
                        a.innerText = item.name
                        box.appendChild(a)
                    })

                } else {
                    console.log("sdfsd")
                    closeBox()
                }
                
            }
            });

            function closeBox() {
                document.getElementById('box').style="display: none"
            }
            </script>
    </body>
    </html>
