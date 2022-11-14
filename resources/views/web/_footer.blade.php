<div class="footer w-100 mt-5 flex-bottom">
    <div class="d-flex pt-5 justify-content-center">
     
      @if(!empty($menu_footer))
      @php $menu_footer=(array)$menu_footer; @endphp
      <a href="{!! $menu_footer[0]->url !!}" class="text-white pt-2 text-decoration-none ms-2">   {!! $menu_footer[0]->name !!}</a>
      @php unset($menu_footer[0]) @endphp
      @foreach ($menu_footer as $item)
      <a href="{!! $item->url !!}" class="text-white pt-2 text-decoration-none ms-2">|   {!! $item->name !!}</a>
      @endforeach
      @endif
    </div>
   
    <div class="fs-11 text-secondary text-center pt-2">
      {{}}
    </div>

    {{-- <div class="d-flex pt-1 justify-content-center">
      <a href="" class="text-secondary pt-2 text-decoration-none">|   Z6 Shop</a>
      <a href="" class="text-secondary pt-2 ms-2 text-decoration-none">|   Z6 Shop</a>
      <a href="" class="text-secondary pt-2 ms-2 text-decoration-none">|   Z6 Shop</a>
      <a href="" class="text-secondary pt-2 ms-2 text-decoration-none">|   Z6 Shop</a>
      <a href="" class="text-secondary pt-2 ms-2 text-decoration-none">|   Z6 Shop</a>
      <a href="" class="text-secondary pt-2 ms-2 text-decoration-none">|   Z6 Shop</a>
 
    </div> --}}
</div>