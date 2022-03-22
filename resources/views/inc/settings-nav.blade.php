<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main" style="margin-top: 67px;">
    <div class="scrollbar-inner">
        <div class="navbar-inner">
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="#navbar-dashboards" data-toggle="collapse" role="button"
                           aria-expanded="true" aria-controls="navbar-dashboards">
                            <i class="ni ni-shop text-primary"></i>
                            <span class="nav-link-text text-uppercase">General</span>
                        </a>
                        <div class="collapse " id="navbar-dashboards">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{route('request.decline.setting')}}" class="nav-link">Request Settings</a>
                                </li>
                                {{--                                <li class="nav-item">--}}
                                {{--                                    <a href="{{route('theme.install')}}" class="nav-link">Theme Installation</a>--}}
                                {{--                                </li>--}}
                                <li class="nav-item">
                                    <a href="{{route('block.tags')}}" class="nav-link">Product Exclusions</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('product.return')}}" class="nav-link">Product Return Methods</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('request.policy')}}" class="nav-link">Request Policy</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('request.import')}}" class="nav-link">Import CSV</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#portal" data-toggle="collapse" role="button" aria-expanded="true"
                           aria-controls="navbar-email">
                            <i class="ni ni-palette text-primary"></i>
                            <span class="nav-link-text text-uppercase">Portal</span>
                        </a>
                        <div class="collapse " id="portal">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{route('settings.logo')}}" class="nav-link">Logo</a>
                                </li>
                                {{--                                <li class="nav-item">--}}
                                {{--                                    <a href="{{route('portal.design')}}" class="nav-link">Design</a>--}}
                                {{--                                </li>--}}
                                {{--                                <li class="nav-item">--}}
                                {{--                                    <a href="{{route('portal.content')}}" class="nav-link">Content</a>--}}
                                {{--                                </li>--}}
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#order" data-toggle="collapse" role="button" aria-expanded="true"
                           aria-controls="navbar-email">
                            <i class="fa fa-inbox text-primary" aria-hidden="true"></i>
                            <span class="nav-link-text text-uppercase">Orders Detail</span>
                        </a>
                        <div class="collapse " id="order">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{route('settings.reasons')}}" class="nav-link">Return Reason</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('orders.return.type')}}" class="nav-link">Return Type</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('order.custom.text')}}" class="nav-link">Custom Exchange Text</a>
                                </li>
                                {{--                                <li class="nav-item">--}}
                                {{--                                    <a href="{{route('order.sku.setting')}}" class="nav-link">Others</a>--}}
                                {{--                                </li>--}}
                            </ul>
                        </div>
                    </li>
                    {{--                    <li class="nav-item">--}}
                    {{--                        <a class="nav-link" href="#customization" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-email">--}}
                    {{--                            <i class="fa fa-file text-primary" aria-hidden="true"></i>--}}
                    {{--                            <span class="nav-link-text text-uppercase">Customizer File Upload</span>--}}
                    {{--                        </a>--}}
                    {{--                        <div class="collapse " id="customization">--}}
                    {{--                            <ul class="nav nav-sm flex-column">--}}
                    {{--                                <li class="nav-item">--}}
                    {{--                                    <a href="{{route('design.file.settings')}}" class="nav-link">Design</a>--}}
                    {{--                                </li>--}}
                    {{--                                <li class="nav-item">--}}
                    {{--                                    <a href="{{route('upload.setting')}}" class="nav-link">Custom Title</a>--}}
                    {{--                                </li>--}}
                    {{--                                <li class="nav-item">--}}
                    {{--                                    <a href="{{route('header.settings')}}" class="nav-link">Header Message</a>--}}
                    {{--                                </li>--}}
                    {{--                            </ul>--}}
                    {{--                        </div>--}}
                    {{--                    </li>--}}
                    {{--                    <li class="nav-item">--}}
                    {{--                        <a class="nav-link" href="#return_method" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-email">--}}
                    {{--                            <i class="fa fa-undo text-primary" aria-hidden="true"></i>--}}
                    {{--                            <span class="nav-link-text text-uppercase">Return Method</span>--}}
                    {{--                        </a>--}}
                    {{--                        <div class="collapse " id="return_method">--}}
                    {{--                            <ul class="nav nav-sm flex-column">--}}
                    {{--                                <li class="nav-item">--}}
                    {{--                                    <a href="{{route('design.return.methods')}}" class="nav-link">Design</a>--}}
                    {{--                                </li>--}}
                    {{--                                <li class="nav-item">--}}
                    {{--                                    <a href="{{route('orders.refund.list')}}" class="nav-link">Custom Methods</a>--}}
                    {{--                                </li>--}}

                    {{--                            </ul>--}}
                    {{--                        </div>--}}
                    {{--                    </li>--}}
                    <li class="nav-item">
                        <a class="nav-link" href="#confirmation" data-toggle="collapse" role="button"
                           aria-expanded="true" aria-controls="navbar-email">
                            <i class="fa fa-cube text-primary" aria-hidden="true"></i>
                            <span class="nav-link-text text-uppercase">Return Label</span>
                        </a>
                        <div class="collapse " id="confirmation">
                            <ul class="nav nav-sm flex-column">
                                {{--                                <li class="nav-item">--}}
                                {{--                                    <a href="{{route('design.confirmation')}}" class="nav-link">Design</a>--}}
                                {{--                                </li>--}}
                                <li class="nav-item">
                                    <a href="{{route('return.confirmation')}}" class="nav-link">Mail</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('email.reminder')}}" class="nav-link">Reminder</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('email.expired')}}" class="nav-link">Expired</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-email" data-toggle="collapse" role="button"
                           aria-expanded="true" aria-controls="navbar-email">
                            <i class="ni ni-email-83 text-primary"></i>
                            <span class="nav-link-text text-uppercase">Email</span>
                        </a>
                        <div class="collapse " id="navbar-email">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{route('email.general')}}" class="nav-link">General</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('email.workflow')}}" class="nav-link">Workflow</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('email.export')}}" class="nav-link">Export</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-customer" data-toggle="collapse" role="button"
                           aria-expanded="true" aria-controls="navbar-customer">
                            <i class="fa fa-users text-primary"></i>
                            <span class="nav-link-text text-uppercase">Customer</span>
                        </a>
                        <div class="collapse " id="navbar-customer">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{route('customer.block.create')}}" class="nav-link">Customer Block</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('easypost.index')}}">
                            <i class="fa fa-shipping-fast text-primary"></i>
                            <span class="nav-link-text text-uppercase">Easy Post</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>


