<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="background-image: linear-gradient(to right, #056fa6, #1fccd8) !important;">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('user')}}">
      <img src="{{asset('backend/img/sidebar_logo.png')}}" style="width:80%">
    </a>

    @if (empty($shop) || $shop->shop_admin == 0)

      <hr class="sidebar-divider my-0">

      <li class="nav-item active">
        <a class="nav-link" href="{{route('user')}}">
          <i class="fas fa-chart-pie"></i>
          <span>{{ __('adm.dashboard') }}</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{route('user.order.index')}}">
            <i class="fas fa-cubes"></i>
            <span>{{ __('adm.your_order') }}</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{route('user.productreview.index')}}">
          <i class="fa fa-star" aria-hidden="true"></i>
          <span>{{ __('adm.your_review') }}</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{route('user.post-comment.index')}}">
          <i class="fas fa-comments fa-chart-area"></i>
          <span>{{ __('adm.your_comment') }}</span>
        </a>
      </li>

      <hr class="sidebar-divider d-none d-md-block">
      <div class="sidebar-heading">
        {{ __('adm.account').' '.env('APP_NAME') }}
      </div>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#walletCollapse" aria-expanded="true" aria-controls="walletCollapse">
            <i class="fas fa-wallet"></i>
            <span>{{ __('adm.wallet') }}</span>
        </a>
        <div id="walletCollapse" class="collapse {{ (request()->is('user/wallet/*')) ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item nocss" href="{{route('user.wallet', 1)}}">{{ __('adm.wallet_money') }}</a>
            <a class="collapse-item nocss" href="{{route('user.wallet', 2)}}">{{ __('adm.wallet_token') }}</a>
          </div>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#accountCollapse" aria-expanded="true" aria-controls="walletCollapse">
          <i class="fas fa-user-circle" aria-hidden="true"></i>
          <span>{{ __('adm.account') }}</span>
        </a>
        <div id="accountCollapse" class="collapse {{ (request()->is('user/affiliate*') || request()->is('user/bank*')) ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{route('user.affiliate')}}">{{ __('adm.affiliate') }}</a>
            <a class="collapse-item" href="{{route('user.bank.index')}}">{{ __('adm.bank_account') }}</a>
          </div>
        </div>
      </li>

      <hr class="sidebar-divider d-none d-md-block">
      <div class="sidebar-heading">
        <a class="nav-link text-light" href="{{ !empty($shop) && $shop->status == 1 ? $shop->url() : route('user.shop') }}">Bán hàng cùng VNSMARKET</a>
      </div>

    @endif

    @if (!empty($shop) && $shop->shop_admin == 1)

      <hr class="sidebar-divider my-0">

      <li class="nav-item">
        <a class="nav-link" href="{{route('user')}}">
          <i class="fas fa-chart-pie"></i>
          <span>{{ __('adm.dashboard') }}</span></a>
      </li>

      <hr class="sidebar-divider d-none d-md-block">
      <div class="sidebar-heading">
        {{ __('adm.account').' '.env('APP_NAME') }}
      </div>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#walletCollapse" aria-expanded="true" aria-controls="walletCollapse">
          <i class="fas fa-wallet"></i>
          <span>{{ __('adm.wallet') }}</span>
        </a>
        <div id="walletCollapse" class="collapse {{ (request()->is('user/wallet/*')) ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item nocss" href="{{route('user.wallet', 1)}}">{{ __('adm.wallet_money') }}</a>
            <a class="collapse-item nocss" href="{{route('user.wallet', 2)}}">{{ __('adm.wallet_token') }}</a>
          </div>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#accountCollapse" aria-expanded="true" aria-controls="walletCollapse">
          <i class="fas fa-user-circle"></i>
          <span>{{ __('adm.account') }}</span>
        </a>
        <div id="accountCollapse" class="collapse {{ (request()->is('user/affiliate*') || request()->is('user/bank*')) ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{route('user.affiliate')}}">{{ __('adm.affiliate') }}</a>
            <a class="collapse-item" href="{{route('user.bank.index')}}">{{ __('adm.bank_account') }}</a>
          </div>
        </div>
      </li>

      <hr class="sidebar-divider d-none d-md-block">
      <div class="sidebar-heading">
        <a class="nav-link text-light" href="{{ !empty($shop) && $shop->status == 1 ? $shop->url() : route('user.shop') }}/user">Bán hàng cùng {{ env('APP_NAME') }}</a>
      </div>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#productCollapse" aria-expanded="true" aria-controls="productCollapse">
          <i class="fab fa-product-hunt"></i>
          <span>{{ __('adm.product') }}</span>
        </a>
        <div id="productCollapse" class="collapse {{ (request()->is('shop/product*')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{route('shop.product.index')}}">{{ __('adm.product') }}</a>
            <a class="collapse-item" href="{{route('shop.product.import')}}">{{ __('adm.import').' '.__('adm.product') }}</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#orderCollapse" aria-expanded="true" aria-controls="orderCollapse">
          <i class="fas fa-cubes"></i>
          <span>{{ __('adm.order') }}</span>
          @if ($countOrder > 0)
            <span class="badge rounded-pill badge-danger">{{ $countOrder }}</span>
          @endif
        </a>
        <div id="orderCollapse" class="collapse {{ (request()->is('shop/order*')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{route('shop.order.index')}}">{{ __('adm.order') }}</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-image"></i>
          <span>{{ __('adm.banner') }}</span>
        </a>
        <div id="collapseTwo" class="collapse {{ (request()->is('shop/banner/*')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{route('shop.banner.index')}}">{{ __('adm.banner') }}</a>
            <a class="collapse-item" href="{{route('shop.banner.create')}}">{{ __('adm.add').' '.__('adm.banner') }}</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
          <a class="nav-link" href="{{route('shop.page.index')}}">
            <i class="fa fa-sticky-note"></i>
            <span>{{ __('adm.page') }}</span>
          </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#settingCollapse" aria-expanded="true" aria-controls="settingCollapse">
            <i class="fas fa-user-cog"></i>
            <span>{{ __('adm.setting') }}</span>
        </a>
        <div id="settingCollapse" class="collapse {{ request()->is('shop/setting*') ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#settingCollapse">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{route('shop.setting.layout')}}">{{ __('setting_layout') }}</a>
            <a class="collapse-item" href="{{route('shop.setting.introduce')}}">{{ __('setting_introduce') }}</a>
            <a class="collapse-item" href="{{route('shop.setting.social')}}">{{ __('setting_social') }}</a>
            {{-- <a class="collapse-item" href="{{route('shop.setting.payment')}}">{{ __('setting_payment') }}</a> --}}
          </div>
        </div>
      </li>

    @endif

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
