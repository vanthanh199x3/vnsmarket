@php
@endphp

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin')}}">
      <!-- <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
      </div>
      <div class="sidebar-brand-text mx-3">Admin</div> -->
      <img src="{{asset('backend/img/sidebar_logo.png')}}" style="width:80%">
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
      <a class="nav-link" href="{{route('admin')}}">
        <i class="fas fa-chart-pie"></i>
        <span>{{ __('adm.dashboard') }}</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      {{ __('adm.banner') }}
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <!-- Nav Item - Charts -->
    <li class="nav-item d-none">
        <a class="nav-link" href="{{route('file-manager')}}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>{{ __('adm.media_manager') }}</span></a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-image"></i>
        <span>{{ __('adm.banner') }}</span>
      </a>
      <div id="collapseTwo" class="collapse {{ (request()->is('admin/banner*')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          {{-- <h6 class="collapse-header">Banner Options:</h6> --}}
          <a class="collapse-item" href="{{route('banner.index')}}">{{ __('adm.banner') }}</a>
          <a class="collapse-item" href="{{route('banner.create')}}">{{ __('adm.add').' '.__('adm.banner') }}</a>
        </div>
      </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
        <!-- Heading -->
        <div class="sidebar-heading">
          {{ __('adm.shop') }}
        </div>

    <!-- Categories -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#categoryCollapse" aria-expanded="true" aria-controls="categoryCollapse">
          <i class="fas fa-sitemap"></i>
          <span>{{ __('adm.category') }}</span>
        </a>
        <div id="categoryCollapse" class="collapse {{ (request()->is('admin/category*')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            {{-- <h6 class="collapse-header">Category Options:</h6> --}}
            <a class="collapse-item" href="{{route('category.index')}}">{{ __('adm.product_category') }}</a>
            <a class="collapse-item" href="{{route('category.create')}}">{{ __('adm.add').' '.__('adm.category') }}</a>
          </div>
        </div>
    </li>

    {{-- Products --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#productCollapse" aria-expanded="true" aria-controls="productCollapse">
          <i class="fab fa-product-hunt"></i>
          <span>{{ __('adm.product') }}</span>
        </a>
        <div id="productCollapse" class="collapse {{ (request()->is('admin/product*')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            {{-- <h6 class="collapse-header">Product Options:</h6> --}}
            <a class="collapse-item" href="{{route('product.index')}}">{{ __('adm.product') }}</a>
            <a class="collapse-item" href="{{route('product.create')}}">{{ __('adm.add').' '.__('adm.product') }}</a>
          </div>
        </div>
    </li>

    {{-- Brands --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#brandCollapse" aria-expanded="true" aria-controls="brandCollapse">
          <i class="fa fa-bookmark"></i>
          <span>{{ __('adm.brand') }}</span>
        </a>
        <div id="brandCollapse" class="collapse {{ (request()->is('admin/brand*')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            {{-- <h6 class="collapse-header">Brand Options:</h6> --}}
            <a class="collapse-item" href="{{route('brand.index')}}">{{ __('adm.brand') }}</a>
            <a class="collapse-item" href="{{route('brand.create')}}">{{ __('adm.add').' '.__('adm.brand') }}</a>
          </div>
        </div>
    </li>

    {{-- Shipping --}}
    <li class="nav-item d-none">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#shippingCollapse" aria-expanded="true" aria-controls="shippingCollapse">
          <i class="fas fa-truck"></i>
          <span>{{ __('adm.shipping') }}</span>
        </a>
        <div id="shippingCollapse" class="collapse {{ (request()->is('shipping/*')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            {{-- <h6 class="collapse-header">Shipping Options:</h6> --}}
            <a class="collapse-item" href="{{route('shipping.index')}}">{{ __('adm.shipping') }}</a>
            <a class="collapse-item" href="{{route('shipping.create')}}">{{ __('adm.add').' '.__('adm.shipping') }}</a>
          </div>
        </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{route('coupon.index')}}">
          <i class="fa fa-gift"></i>
          <span>{{ __('adm.coupon') }}</span></a>
    </li>

    <!--Orders -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('order.index')}}">
            <i class="fas fa-cubes"></i>
            <span>{{ __('adm.order') }}</span>
            @if ($countOrder > 0)
              <span class="badge rounded-pill badge-danger">{{ $countOrder }}</span>
            @endif
        </a>
    </li>

    <!-- Reviews -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('review.index')}}">
            <i class="fa fa-star"></i>
            <span>{{ __('adm.review') }}</span>
        </a>
    </li>

    <!-- Contact Message -->
    <li class="nav-item">
        <a class="nav-link" href="{{asset('admin/message')}}">
            <i class="fa fa-phone"></i>
            <span>{{ __('adm.contact_message') }}</span>
            @if ($countContactMessage > 0)
              <span class="badge rounded-pill badge-danger">{{ $countContactMessage }}</span>
            @endif
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      {{ __('adm.post') }}
    </div>

    <!-- Posts -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#postCollapse" aria-expanded="true" aria-controls="postCollapse">
        <i class="fas fa-fw fa-folder"></i>
        <span>{{ __('adm.post') }}</span>
      </a>
      <div id="postCollapse" class="collapse {{ (request()->is('admin/post*')) ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          {{-- <h6 class="collapse-header">Post Options:</h6> --}}
          <a class="collapse-item" href="{{route('post.index')}}">{{ __('adm.post') }}</a>
          <a class="collapse-item" href="{{route('post.create')}}">{{ __('adm.add').' '.__('adm.post') }}</a>
        </div>
      </div>
    </li>

     <!-- Category -->
     <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#postCategoryCollapse" aria-expanded="true" aria-controls="postCategoryCollapse">
          <i class="fas fa-sitemap fa-folder"></i>
          <span>{{ __('adm.category') }}</span>
        </a>
        <div id="postCategoryCollapse" class="collapse {{ (request()->is('admin/post-category*')) ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            {{-- <h6 class="collapse-header">Category Options:</h6> --}}
            <a class="collapse-item" href="{{route('post-category.index')}}">{{ __('adm.post_category') }}</a>
            <a class="collapse-item" href="{{route('post-category.create')}}">{{ __('adm.add').' '.__('adm.category') }}</a>
          </div>
        </div>
      </li>

      <!-- Tags -->
    <li class="nav-item d-none">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#tagCollapse" aria-expanded="true" aria-controls="tagCollapse">
            <i class="fas fa-tags fa-folder"></i>
            <span>{{ __('adm.tag') }}</span>
        </a>
        <div id="tagCollapse" class="collapse {{ (request()->is('post-tag/*')) ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
            {{-- <h6 class="collapse-header">Tag Options:</h6> --}}
            <a class="collapse-item" href="{{route('post-tag.index')}}">{{ __('adm.tag') }}</a>
            <a class="collapse-item" href="{{route('post-tag.create')}}">{{ __('adm.add').' '.__('adm.tag') }}</a>
            </div>
        </div>
    </li>

    <!-- Comments -->
    <li class="nav-item">
      <a class="nav-link" href="{{route('comment.index')}}">
          <i class="fas fa-comments fa-chart-area"></i>
          <span>{{ __('adm.comment') }}</span>
      </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
     <!-- Heading -->
    <div class="sidebar-heading">
      {{ __('adm.account') }}
    </div>

    <!-- Wallet -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#walletCollapse" aria-expanded="true" aria-controls="walletCollapse">
          <i class="fas fa-wallet"></i>
          <span>{{ __('adm.wallet') }}</span>
      </a>
      <div id="walletCollapse" class="collapse {{ (request()->is('admin/wallet/1') || request()->is('admin/wallet/2')) ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item nocss" href="{{route('wallet', 1)}}">{{ __('adm.wallet_money') }}</a>
          <a class="collapse-item nocss" href="{{route('wallet', 2)}}">{{ __('adm.wallet_token') }}</a>
        </div>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{route('wallet.request', 1)}}">
        <i class="fas fa-question-circle"></i>
        <span>{{ __('adm.withdraw_request') }}</span>
        @if ($countWithdraᴡ > 0)
          <span class="badge rounded-pill badge-danger">{{ $countWithdraᴡ }}</span>
        @endif
      </a>
    </li>

    <!-- Account -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#accountCollapse" aria-expanded="true" aria-controls="walletCollapse">
          <i class="fas fa-user-circle"></i>
          <span>{{ __('adm.account') }}</span>
      </a>
      <div id="accountCollapse" class="collapse {{ (request()->is('admin/affiliate*') || request()->is('admin/bank*')) ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item" href="{{route('affiliate')}}">{{ __('adm.affiliate') }}</a>
          <a class="collapse-item" href="{{route('bank.index')}}">{{ __('adm.bank_account') }}</a>
        </div>
      </div>
    </li>

    <!-- Users -->
    @if(auth()->user()->role == 'admin')
    <li class="nav-item">
        <a class="nav-link" href="{{route('users.index')}}">
          <i class="fas fa-users"></i>
          <span>{{ __('adm.user') }}</span>
          @if ($countShop > 0)
            <span class="badge rounded-pill badge-danger">{{ $countShop }}</span>
          @endif
        </a>
    </li>
    @endif


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
     <!-- Heading -->
    <div class="sidebar-heading">
      {{ __('adm.general_setting') }}
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{route('page.index')}}">
          <i class="fa fa-sticky-note"></i>
          <span>{{ __('adm.page') }}</span>
        </a>
    </li>

     <!-- General settings -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#settingCollapse" aria-expanded="true" aria-controls="settingCollapse">
          <i class="fas fa-user-cog"></i>
          <span>{{ __('adm.setting') }}</span>
      </a>
      <div id="settingCollapse" class="collapse {{ request()->is('admin/setting*') ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#settingCollapse">
        <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item" href="{{route('setting.layout')}}">{{ __('adm.setting_layout') }}</a>
          <a class="collapse-item" href="{{route('setting.introduce')}}">{{ __('adm.setting_introduce') }}</a>
          <a class="collapse-item" href="{{route('setting.social')}}">{{ __('adm.setting_social') }}</a>
          <a class="collapse-item" href="{{route('setting.payment')}}">{{ __('adm.setting_payment') }}</a>
        </div>
      </div>
    </li>

    {{-- <li class="nav-item">
      <a class="nav-link" href="">
        <i class="fas fa-question-circle"></i>
        <span>{{ __('adm.withdraw_create') }}</span>
      </a>
    </li> --}}

    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>