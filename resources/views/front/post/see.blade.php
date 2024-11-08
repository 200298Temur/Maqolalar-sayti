@extends('layouts.main') 

@section('title', 'Index Sahifa') 
@section('content')
<div class="single-news">
    <div class="container">
        <div class="row">
            <div class="col-lg-10">
                <div class="sn-container">
                    <div class="sn-img" style="display: flex; align-items: center; justify-content: center;">
                        {{-- <img src="{{asset($post->image)}}" /> --}}
                        @if(empty($post->image))
                                <img style="height: 300px; margin:0 auto; width: 200px;" alt="web" src="{{asset('img/download.png')}}" />                                
                        @else
                            <img style="height: 300px;margin:0 auto; width: 300px;" src="{{asset($post->image)}}" alt="boshqa" />
                        @endif
                    </div>
                    <div class="sn-content">
                        <h1 class="sn-title">{{$post->title}}</h1>
                        <h4>{{$post->subtitle}}</h4>                        
                        <div> 
                            {!! $post->content !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection