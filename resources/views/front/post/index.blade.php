@extends('layouts.main') 

@section('title', 'Index Sahifa') 

@section('content')
    <div class="cat-news">
        <div class="container">            
            <div style="display: grid; 	grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 24px;" class="grid grid-cols-4 gap-4 mt-3 p-3">
                @if(!$posts->isEmpty())
                    @foreach ($posts as $post)
                    <div class="">
                        <div class="cn-img">
                            @if(is_null($post->image))
                                <img style="height: 300px" alt="web" src="{{asset('img/download.png')}}" />                                
                            @else
                                <img style="height: 300px" src="{{asset($post->image)}}" alt="boshqa" />
                            @endif
                            <div class="cn-title">
                                <a href="">{{$post->title}}</a>
                            </div>
                        </div>
                    </div>   
                    @endforeach
                @else
                    <div class="">
                        <div class="cn-img">
                            <img src="{{asset('img/download.png')}}" />
                            <div class="cn-title">
                                <a href="">Lorem ipsum dolor sit</a>
                            </div>
                        </div>
                    </div>        
                @endif
                          
            </div>
        </div>
    </div>
@endsection
