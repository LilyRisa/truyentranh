@php
use App\Models\Rate;
use Illuminate\Support\Facades\DB;

$get_vote = Rate::where('slug', $data->slug)->get();
$vote = DB::select('select COUNT(1) AS count_vote, ROUND( AVG(vote),1) AS avg  from rate where slug = ?', [$data->slug]);
$vote = $vote[0];

if ($get_vote->isEmpty()) {
    $voted = false;
} else {
    $voted = true;
}

if (empty($vote->count_vote)){
    $vote->count_vote = 1;
    $vote->avg = 5;
} else {
    $vote->avg = ($vote->avg*$vote->count_vote + 5) / ($vote->count_vote + 1);
    $vote->count_vote += 1;
}

$avg = round($vote->avg, 1);
$count_vote = $vote->count_vote;

@endphp

@if(!IS_AMP)
<div class="allRate text-right">
    <input type="range" value="<?php echo $avg ?>" step="0.25" id="backing5" class="d-none">
    <div data-url="{{!empty($url) ? $url : '/post/ajax_rate'}}" class="rateit opa-0 <?php echo !empty($voted) ? 'voted' : ''?>" data-rateit-backingfld="#backing5" data-rateit-resetable="false" data-rateit-ispreset="true"
         data-rateit-min="0" data-rateit-max="5" data-rateit-mode="font" data-rateit-icon=""
         style="font-family:fontawesome" data-slug="{{$data->slug}}">
    </div>
    <div class="rate-fake d-none">
        <label class="checked" title="text"></label>
        <label class="checked" title="text"></label>
        <label class="checked" title="text"></label>
        <label class="checked" title="text"></label>
        <label title="text"></label>
      </div>
    <span class="d-block danhgia font-13">
        <span class="avg-rate">{{round($avg, 1)}}</span> /<span>5</span> của
        <span class="count-rate">{{ $count_vote }}</span> đánh giá</span>
    </span>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org/",
            "@type": "AggregateRating",
            "ratingValue": {{ round($avg, 1) }},
            "bestRating": "5",
            "ratingCount": {{ $count_vote }},
            "itemReviewed": {
                "@type": "Creativeworkseries",
                "name": "{{ strip_quotes($oneItem->title) }}"
            }
        }
    </script>
</div>
@endif

@if(IS_AMP)
<div class="d-flex">
  <form id="rating" method="post" action-xhr="{{route('rating')}}" target="_blank" class="">
    <input type="text" name="slug" value="{{$data->slug}}" hidden>
      <fieldset class="rating">
      @for($i = 5; $i >= 1; $i--)
        <input name="star" type="radio" id="rating{{$i}}" value="{{$i}}" on="change:rating.submit" {{round($avg) == $i ? 'checked="checked"' : ''}}>
        <label for="rating{{$i}}" title="{{$i}} stars">☆</label>
      @endfor
      </fieldset>
      <div submit-success>
        <template type="amp-mustache">
          <p>@{{message}}</p>
        </template>
      </div>
      <div submit-error>
        <template type="amp-mustache">
          Looks like something went wrong. Please try to rate again. @{{error}}
        </template>
      </div>
    </form>
    <span class="ms-3 pt-2 font-13">
      <span class="avg-rate">{{round($avg, 1)}}</span> /<span>5</span> của
      <span class="count-rate">{{ $count_vote }}</span> đánh giá
  </span>
</div>
@endif
