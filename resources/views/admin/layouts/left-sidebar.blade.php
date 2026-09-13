<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li><a class="waves-effect waves-dark @if (request()->routeIs('admin.dashboard')) active @endif"
                        href="{{ route('admin.dashboard') }}" aria-expanded="false"><i
                            class="ti-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>
                <li class="@if (request()->routeIs('admin.category.*')) active @endif"> <a
                        class="has-arrow waves-effect waves-dark @if (request()->routeIs('admin.category.*')) active @endif"
                        href="javascript:void(0)" aria-expanded="false"><i class="ti-folder"></i><span
                            class="hide-menu">Category</span></a>
                    <ul aria-expanded="false"
                        class="collapse @if (request()->routeIs('admin.category.*')) in @endif">
                        <li><a href="{{ route('admin.category.add') }}"
                                class="@if (request()->routeIs('admin.category.add')) active @endif">Add</a></li>
                        <li><a href="{{ route('admin.category.manage') }}"
                                class="@if (request()->routeIs('admin.category.*') && ! request()->routeIs('admin.category.add')) active @endif">Manage</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i
                            class="ti-layers-alt"></i><span class="hide-menu">Subcategory</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="#">Add</a></li>
                        <li><a href="#">Manage</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i
                            class="ti-medall"></i><span class="hide-menu">Brand</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="#">Add</a></li>
                        <li><a href="#">Manage</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i
                            class="ti-ruler-pencil"></i><span class="hide-menu">Unit</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="#">Add</a></li>
                        <li><a href="#">Manage</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i
                            class="ti-package"></i><span class="hide-menu">Product</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="#">Add</a></li>
                        <li><a href="#">Manage</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i
                            class="ti-shopping-cart"></i><span class="hide-menu">Order</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="#">Add</a></li>
                        <li><a href="#">Manage</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
