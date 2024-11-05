@extends('layouts.main') 

@section('title', 'Index Sahifa') 

@section('content')
    <div class="cat-news">
        <div class="container">            
            <div style="display: grid; 	grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 24px;" class="grid grid-cols-4 gap-4 mt-3 p-3">
                {{-- @if ()
                    @foreach ( as )
                        
                    @endforeach
                @endif --}}
                <div class="">
                    <div class="cn-img">
                        <img src="{{asset('img/download.png')}}" />
                        <div class="cn-title">
                            <a href="">Lorem ipsum dolor sit</a>
                        </div>
                    </div>
                </div>        
                          
            </div>
        </div>
    </div>
@endsection
