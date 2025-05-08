<div class="container-fluid">
    <div class="swip">
        <div class="swiper-container ">
            <div class="swiper-wrapper">
                @foreach($banners as $banner)
                <div class="swiper-slide">
                    <div class="title" id="title_#">{{$banner->title}}</div>
                    <div class="content" id="content_#">{{$banner->content}}</div>
                    <img style="width:auto;height: 100%;" class="border border-dark border-2" src="{{url('storage/'.$banner->path)}}"/>
                </div>
                @endforeach
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>
