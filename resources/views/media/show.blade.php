
    <style>
        .card-img {
            position: relative;
        }

        .card-img .video-content {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style> 
     
<div class="card-img-actions m-1">
    @if ($item->is_image)
        <div class="card-img embed-responsive">
            <img src="{{ URL::asset('public/storage/media/' . $item->name) }}" alt="{{ $item->name }}" title="{{ $item->name }}" />
        </div>
    @else
        <div class="card-img embed-responsive embed-responsive-16by9">
            <video src="{{ URL::asset('public/storage/media/' . $item->name) }}" muted
                controls></video> 
        </div>
    @endif
</div>
