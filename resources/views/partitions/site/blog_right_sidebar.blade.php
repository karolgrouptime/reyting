<div class="blog_right_sidebar">
    <aside class="single_sidebar_widget search_widget">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Gözleg">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button"><i class="lnr lnr-magnifier"></i></button>
            </span>
        </div><!-- /input-group -->
        <div class="br"></div>
    </aside>

    <aside class="single_sidebar_widget popular_post_widget">
        <h3 class="widget_title">Meşhur makalalar</h3>
        @foreach($articles as $article)
        <div class="media post_item">
            @if($article->files)
                <img style="height: auto;max-width:130px" src="{{url('storage/'.$article->files->path)}}" alt="post">
            @endif
            <div class="media-body">
                <a href="#"><h3>{{$article->title}}</h3></a>
                <p>{{$article->created_at->toDateString()}}</p>
            </div>
        </div>
        @endforeach
        <div class="br"></div>
    </aside>
    <aside class="single_sidebar_widget ads_widget">
        <a href="#"><img class="img-fluid" src="" alt=""></a>
        <div class="br"></div>
    </aside>
    <aside class="single_sidebar_widget post_category_widget">
        <h4 class="widget_title">Makalalaryň görnüşleri</h4>
        <ul class="list cat-list">
            @foreach($newsTypes as $newsType)
            <li>
                <a href="#" class="d-flex justify-content-between">
                    <p>{{$newsType->name}}</p>
                    <p>27</p>
                </a>
            </li>
                @endforeach
        </ul>
        <div class="br">
        </div>
    </aside>
    <br>
    <br>
    <br>
    <br>
</div>