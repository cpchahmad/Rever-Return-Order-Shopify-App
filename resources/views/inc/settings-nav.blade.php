<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main" style="margin-top: 67px;">
    <div class="scrollbar-inner">
        <div class="navbar-inner">
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('request/settings'))|| (request()->is('product/exclusions')) || (request()->is('product/return')) || (request()->is('request/policy')) || (request()->is('requests/import')) ? 'active' : '' }} " href="#navbar-dashboards" data-toggle="collapse" role="button"
                           aria-expanded="true" aria-controls="navbar-dashboards">
                            <i class="ni ni-shop text-primary"></i>
                            <span class="nav-link-text text-uppercase">General</span>
                        </a>
                        <div class="collapse {{ (request()->is('request/settings'))|| (request()->is('product/exclusions')) || (request()->is('product/return')) || (request()->is('request/policy')) || (request()->is('requests/import')) ? 'show' : '' }} " id="navbar-dashboards">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item {{ (request()->is('request/settings'))  ? 'active' : '' }}">
                                    <a href="{{route('request.decline.setting')}}" class="nav-link">Request Settings</a>
                                </li>

                                <li class="nav-item {{ (request()->is('product/exclusions'))  ? 'active' : '' }}">
                                    <a href="{{route('block.tags')}}" class="nav-link">Product Exclusions</a>
                                </li>
                                <li class="nav-item {{ (request()->is('product/return'))  ? 'active' : '' }}">
                                    <a href="{{route('product.return')}}" class="nav-link">Product Return Methods</a>
                                </li>
                                <li class="nav-item {{ (request()->is('request/policy'))  ? 'active' : '' }}">
                                    <a href="{{route('request.policy')}}" class="nav-link">Request Policy</a>
                                </li>
                                <li class="nav-item {{ (request()->is('requests/import'))  ? 'active' : '' }}">
                                    <a href="{{route('request.import')}}" class="nav-link">Import CSV</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('settings/logo')) || (request()->is('settings/portal-text'))   ? 'active' : '' }}" href="#portal" data-toggle="collapse" role="button" aria-expanded="true"
                           aria-controls="navbar-email">
                            <i class="ni ni-palette text-primary"></i>
                            <span class="nav-link-text text-uppercase">Portal</span>
                        </a>
                        <div class="collapse  {{ (request()->is('settings/logo')) || (request()->is('settings/portal-text')) ? 'show' : '' }} " id="portal">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item {{ (request()->is('settings/logo')) ? 'active' : '' }}">
                                    <a href="{{route('settings.logo')}}" class="nav-link">Logo</a>
                                </li>
                                <li class="nav-item {{ (request()->is('settings/portal-text')) ? 'active' : '' }}">
                                    <a href="{{route('settings.portal-text')}}" class="nav-link">Text</a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('settings/reasons'))|| (request()->is('order/return/type')) || (request()->is('orders/custom/text'))  ? 'active' : '' }}" href="#order" data-toggle="collapse" role="button" aria-expanded="true"
                           aria-controls="navbar-email">
                            <i class="fa fa-inbox text-primary" aria-hidden="true"></i>
                            <span class="nav-link-text text-uppercase">Orders Detail</span>
                        </a>
                        <div class="collapse {{ (request()->is('settings/reasons'))|| (request()->is('order/return/type')) || (request()->is('orders/custom/text'))  ? 'show' : '' }} " id="order">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item {{ (request()->is('settings/reasons')) ? 'active' : '' }}">
                                    <a href="{{route('settings.reasons')}}" class="nav-link">Return Reason</a>
                                </li>
                                <li class="nav-item {{ (request()->is('order/return/type')) ? 'active' : '' }}">
                                    <a href="{{route('orders.return.type')}}" class="nav-link">Return Type</a>
                                </li>
                                <li class="nav-item {{ (request()->is('orders/custom/text')) ? 'active' : '' }}">
                                    <a href="{{route('order.custom.text')}}" class="nav-link">Custom Exchange Text</a>
                                </li>

                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('order/confirmation/settings')) || (request()->is('email/reminder')) || (request()->is('email/expired')) ? 'active' : '' }}" href="#confirmation" data-toggle="collapse" role="button"
                           aria-expanded="true" aria-controls="navbar-email">
                            <i class="fa fa-cube text-primary" aria-hidden="true"></i>
                            <span class="nav-link-text text-uppercase">Return Label</span>
                        </a>
                        <div class="collapse {{ (request()->is('order/confirmation/settings')) || (request()->is('email/reminder')) || (request()->is('email/expired')) ? 'show' : '' }} " id="confirmation">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item {{ (request()->is('order/confirmation/settings')) ? 'active' : '' }}">
                                    <a href="{{route('return.confirmation')}}" class="nav-link">Mail</a>
                                </li>
                                <li class="nav-item {{ (request()->is('email/reminder')) ? 'active' : '' }}">
                                    <a href="{{route('email.reminder')}}" class="nav-link">Reminder</a>
                                </li>
                                <li class="nav-item {{ (request()->is('email/expired')) ? 'active' : '' }}">
                                    <a href="{{route('email.expired')}}" class="nav-link">Expired</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('email/general')) || (request()->is('email/workflow')) || (request()->is('email/export')) ? 'active' : '' }}" href="#navbar-email" data-toggle="collapse" role="button"
                           aria-expanded="true" aria-controls="navbar-email">
                            <i class="ni ni-email-83 text-primary"></i>
                            <span class="nav-link-text text-uppercase">Email</span>
                        </a>
                        <div class="collapse {{ (request()->is('email/general')) || (request()->is('email/workflow')) || (request()->is('email/export')) ? 'show' : '' }} " id="navbar-email">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item {{ (request()->is('email/general')) ? 'active' : '' }}">
                                    <a href="{{route('email.general')}}" class="nav-link">General</a>
                                </li>
                                <li class="nav-item {{ (request()->is('email/workflow')) ? 'active' : '' }}">
                                    <a href="{{route('email.workflow')}}" class="nav-link">Workflow</a>
                                </li>
                                <li class="nav-item {{ (request()->is('email/export')) ? 'active' : '' }}">
                                    <a href="{{route('email.export')}}" class="nav-link">Export</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('settings/customer/block')) ? 'active' : '' }} " href="#navbar-customer" data-toggle="collapse" role="button"
                           aria-expanded="true" aria-controls="navbar-customer">
                            <i class="fa fa-users text-primary"></i>
                            <span class="nav-link-text text-uppercase">Customer</span>
                        </a>
                        <div class="collapse {{ (request()->is('settings/customer/block')) ? 'show' : '' }} " id="navbar-customer">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item {{ (request()->is('settings/customer/block')) ? 'active' : '' }}">
                                    <a href="{{route('customer.block.create')}}" class="nav-link">Customer Block</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('settings/easypost/integration')) ? 'active' : '' }}" href="{{route('easypost.index')}}">
                            <i class="fa fa-shipping-fast text-primary"></i>

                            <span class="nav-link-text text-uppercase">Logistics Integration</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>


