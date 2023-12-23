 <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
     <div class="app-brand demo">
         <a href="index.html" class="app-brand-link">
             <span class="app-brand-logo demo">
                 <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd" clip-rule="evenodd"
                         d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                         fill="#7367F0" />
                     <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                         d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616" />
                     <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                         d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616" />
                     <path fill-rule="evenodd" clip-rule="evenodd"
                         d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                         fill="#7367F0" />
                 </svg>
             </span>
             <span class="app-brand-text demo menu-text fw-bold">Vuexy</span>
         </a>

         <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
             <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
             <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
         </a>
     </div>

     <div class="menu-inner-shadow"></div>

     <ul class="menu-inner py-1">
         <!-- Dashboards -->
         <li class="menu-item  {{ request()->routeIs('home') ? 'active open' : '' }}">
             <a href="javascript:void(0);" class="menu-link menu-toggle">
                 <i class="menu-icon tf-icons ti ti-smart-home"></i>
                 <div data-i18n="Dashboards">Dashboards</div>
             </a>
             <ul class="menu-sub">
                 <li class="menu-item {{ request()->routeIs('home') ? 'active' : '' }}">
                     <a href="{{ url('/') }}" class="menu-link">
                         <div data-i18n="Home">Home</div>
                     </a>
                 </li>
             </ul>
         </li>

         <!-- Layouts -->
         <li class="menu-item {{ request()->routeIs('viewer-management.*') ? 'active open' : '' }}">
             <a href="javascript:void(0);" class="menu-link menu-toggle">
                 <i class="menu-icon tf-icons ti ti-layout-sidebar"></i>
                 <div data-i18n="Người xem">Người xem</div>
             </a>
             <ul class="menu-sub">
                 <li class="menu-item {{ request()->routeIs('viewer-management.viewers*') ? 'active' : '' }}">
                     <a  href="{{ url('/viewer-management/viewers') }}" class="menu-link " >
                         <div data-i18n="Danh sách">Danh sách</div>
                     </a>
                 </li>
                 <li class="menu-item">
                     <a href="javascript:void(0);" class="menu-link menu-toggle">
                         <div data-i18n="Lịch sử">Lịch sử</div>
                     </a>
                     <ul class="menu-sub">
                         <li class="menu-item">
                             <a href="app-user-view-account.html" class="menu-link">
                                 <div data-i18n="Lịch sử xem quảng cáo">Lịch sử xem quảng cáo</div>
                             </a>
                         </li>
                         <li class="menu-item">
                             <a href="app-user-view-security.html" class="menu-link">
                                 <div data-i18n="Lịch sử đăng nhập">Lịch sử đăng nhập</div>
                             </a>
                         </li>
                         <li class="menu-item">
                             <a href="app-user-view-billing.html" class="menu-link">
                                 <div data-i18n="Lịch sử nap/rút tiền">Lịch sử nap/rút tiền</div>
                             </a>
                         </li>
                     </ul>
                 </li>
                 <li class="menu-item">
                     <a href="javascript:void(0);" class="menu-link menu-toggle">
                         <div data-i18n="Cài đặt">Cài đặt</div>
                     </a>
                     <ul class="menu-sub">
                         <li class="menu-item">
                             <a href="app-user-view-security.html" class="menu-link">
                                 <div data-i18n="Thứ tự xem quảng cáo">Thứ tự xem quảng cáo</div>
                             </a>
                         </li>
                         <li class="menu-item">
                             <a href="app-user-view-billing.html" class="menu-link">
                                 <div data-i18n="Giá mua quảng cáo">Giá mua quảng cáo</div>
                             </a>
                         </li>
                     </ul>
                 </li>
             </ul>
         </li>
         <li class="menu-item {{ request()->routeIs('user-management.*') ? 'active open' : '' }}">
             <a href="javascript:void(0);" class="menu-link menu-toggle">
                 <i class="menu-icon tf-icons ti ti-users"></i>
                 <div data-i18n="Người dùng">Người dùng</div>
             </a>
             <ul class="menu-sub">
                 <li class="menu-item {{ request()->routeIs('user-management.users.*') ? 'active' : '' }}">
                     <a href="{{ url('/user-management/users') }}" class="menu-link" >
                         <div data-i18n="Danh sách">Danh sách</div>
                     </a>
                 </li>
                 <li class="menu-item {{ request()->routeIs('user-management.roles*') ? 'active' : '' }}">
                     <a href="{{ url('user-management/roles') }}" class="menu-link">
                         <div data-i18n="Vai trò">Vai trò</div>
                     </a>
                 </li>
                 <li class="menu-item">
                     <a href="app-access-permission.html" class="menu-link">
                         <div data-i18n="Quyền">Quyền</div>
                     </a>
                 </li>

             </ul>
         </li>
         <li class="menu-item {{ request()->routeIs('') ? 'active open' : '' }}">
             <a href="javascript:void(0);" class="menu-link menu-toggle">
                 <i class="menu-icon ti ti-repeat"></i>
                 <div data-i18n="Quản lý cấp độ">Quản lý cấp độ</div>
             </a>
             <ul class="menu-sub">
                 <li class="menu-item {{ request()->routeIs('') ? 'active' : '' }}">
                     <a href="" class="menu-link">
                         <div data-i18n="Danh sách">Danh sách</div>
                     </a>
                 </li>
             </ul>
         </li>
         <li class="menu-item {{ request()->routeIs('') ? 'active open' : '' }}">
             <a href="javascript:void(0);" class="menu-link menu-toggle">
                 <i class="menu-icon ti ti-video"></i>
                 <div data-i18n="Quản lý quảng cáo">Quản lý quảng cáo</div>
             </a>
             <ul class="menu-sub">
                 <li class="menu-item {{ request()->routeIs('') ? 'active' : '' }}">
                     <a href="" class="menu-link">
                         <div data-i18n="Danh sách">Danh sách</div>
                     </a>
                 </li>
             </ul>
         </li>
         <li class="menu-item {{ request()->routeIs('') ? 'active open' : '' }}">
             <a href="javascript:void(0);" class="menu-link menu-toggle">
                 <i class="menu-icon ti ti-bell"></i>
                 <div data-i18n="Quản lý thông báo">Quản lý thông báo</div>
             </a>
             <ul class="menu-sub">
                 <li class="menu-item {{ request()->routeIs('') ? 'active' : '' }}">
                     <a href="" class="menu-link">
                         <div data-i18n="Danh sách">Danh sách</div>
                     </a>
                 </li>
             </ul>
         </li>
         <li class="menu-item {{ request()->routeIs('') ? 'active open' : '' }}">
             <a href="javascript:void(0);" class="menu-link menu-toggle">
                 <i class="menu-icon ti ti-language"></i>
                 <div data-i18n="Đa ngôn ngữ">Đa ngôn ngữ</div>

             </a>
             <ul class="menu-sub">
                 <li class="menu-item {{ request()->routeIs('') ? 'active' : '' }}">
                     <a href="" class="menu-link">
                         <div data-i18n="Tiếng Anh">Tiếng Anh</div>
                     </a>
                 </li>
                 <li class="menu-item {{ request()->routeIs('') ? 'active' : '' }}">
                     <a href="" class="menu-link">
                         <div data-i18n="Tiếng Việt">Tiếng Việt</div>
                     </a>
                 </li>
             </ul>
         </li>
         <li class="menu-item {{ request()->routeIs('') ? 'active open' : '' }}">
             <a href="javascript:void(0);" class="menu-link menu-toggle">
                 <i class="menu-icon ti ti-settings"></i>
                 <div data-i18n="Cài đặt chung">Cài đặt chung</div>

             </a>
             <ul class="menu-sub">
                 <li class="menu-item {{ request()->routeIs('') ? 'active' : '' }}">
                     <a href="" class="menu-link">
                         <div data-i18n="Hồ sơ cty">Hồ sơ cty</div>
                     </a>
                 </li>
                 <li class="menu-item {{ request()->routeIs('') ? 'active' : '' }}">
                     <a href="" class="menu-link">
                         <div data-i18n="Quy tắc">Quy tắc</div>
                     </a>
                 </li>
             </ul>
         </li>

     </ul>
 </aside>
