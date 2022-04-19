@extends('layouts.main-theme')
@section('content')
<div id="wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <nav class="navbar navbar-default navbar-static-top m-b-0">
        <div class="navbar-header anaylatics">
            <div class="top-left-part">
                <!-- Logo -->
                <a class="logo" href="index.html">
                    <!-- Logo icon image, you can use font-icon also --><b>
                        <!--This is dark logo icon--><img src="../plugins/images/admin-logo.png" alt="home" class="dark-logo" /><!--This is light logo icon--><img src="../plugins/images/admin-logo-dark.png" alt="home" class="light-logo" />
                    </b>
                    <!-- Logo text image you can use text also --><span class="hidden-xs">
            <!--This is dark logo text--><!--This is light logo text--><img src="../plugins/images/admin-text-dark.png" alt="home" class="light-logo" />
         </span> </a>
            </div>

            <!-- /Logo -->
            <div class="main-menu-overall">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Dashboard</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                        <ol class="breadcrumb">
                            <li><a href="#">Dashboard</a></li>
                        </ol>
                    </div>

                </div>

            </div>
        </div>
        <!-- /.navbar-header -->
        <!-- /.navbar-top-links -->
        <!-- /.navbar-static-side -->
    </nav>
    <!-- End Top Navigation -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav slimscrollsidebar">
            <div class="sidebar-head">
                <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span class="hide-menu">Navigation</span></h3>
            </div>
            <ul class="nav" id="side-menu">
                <li style="padding: 70px 0 0;">
                    <a href="/index" class="waves-effect">Dashboard</a>
                </li>
                <li>
                    <a href="/anaylatics" class="waves-effect">Analytics</a>
                </li>
                <li>
                    <a href="/settings" class="waves-effect">Settings<i class="fa fa-chevron-down"></i></a>
                    <ul class="submemu-settings">
                        <li><a href="#" >General<i class="fa fa-chevron-down center-chev"></i></a>
                            <ul class="submemu-settings">
                                <li><i class="fa fa-chevron-right"></i><a href="/logo" >Logo</a>   </li>
                                <li><i class="fa fa-chevron-right "></i><a href="/settings-submenu" >Return Reasons</a>   </li>
                                <li><i class="fa fa-chevron-right "></i><a href="#" >Control Reasons</a>   </li>
                            </ul>
                        </li>
                        <li><a href="#" >Locations <i class="fa fa-chevron-down center-chev"></i></a>
                            <ul class="submemu-settings">
                                <li><i class="fa fa-chevron-right"></i><a href="#" >Shipping Location</a>   </li>
                                <li><i class="fa fa-chevron-right "></i><a href="#" >Inventory Location</a>   </li>

                            </ul>
                        </li>
                        <li><a href="#" >Policies <i class="fa fa-chevron-down center-chev"></i></a>
                            <ul class="submemu-settings">
                                <li><i class="fa fa-chevron-right"></i><a href="#" >Rules</a>   </li>
                                <li><i class="fa fa-chevron-right "></i><a href="#" >Product Exclusions</a>   </li>

                            </ul>
                        </li>
                        <li><a href="#" >Email <i class="fa fa-chevron-down center-chev"></i></a>
                            <ul class="submemu-settings">
                                <li><i class="fa fa-chevron-right"></i><a href="#" >General</a>   </li>
                                <li><i class="fa fa-chevron-right "></i><a href="#" >Work Flow</a>   </li>

                            </ul>
                        </li>



                    </ul>
                </li>
                <li>
                    <a href="#" class="waves-effect">Return Portal</a>
                </li>


            </ul>

        </div>

    </div>
    <div id="page-wrapper">
        <div class="container-fluid">


            <div class="conatiner">
                <div class="row">

                    <div class="col-md-2">

                    </div>
                    <div class="col-md-8 some-top-margin">
                        <h5>Return reasons will give you impactful insights into your business. Select the return reasons relevant to your store from our pre-defined list to benchmark your products against industry standards or create your own.</h5>
                        <div class="col-md-6 ">

                            <form>
                                <div class="form-check">
                                    <label>
                                        <input type="checkbox" name="check" checked> <span class="label-text">Size - Too Small</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label>
                                        <input type="checkbox" name="check"> <span class="label-text"> Style</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label>
                                        <input type="checkbox" name="check"> <span class="label-text">Too Expensive</span>
                                    </label>
                                </div>

                            </form>

                        </div>
                        <div class="col-md-6">

                            <form>
                                <div class="form-check">
                                    <label>
                                        <input type="checkbox" name="check" checked> <span class="label-text">Size - Too Small</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label>
                                        <input type="checkbox" name="check"> <span class="label-text"> Style</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label>
                                        <input type="checkbox" name="check"> <span class="label-text">Too Expensive</span>
                                    </label>
                                </div>

                            </form>

                        </div>

                    </div>

                </div>
            </div>
            <div class="conatiner">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="adjust-at-bottom">
                            <h4 class="">Your custom reasons</h4>
                            <p>You have no custom reasons.</p>
                        </div>
                        <input type="button" class="btn btn-primary" value="Save">
                        <a href="#" data-toggle="modal" data-target="#exampleModal">Add a custom reason</a>
                    </div>
                </div>
            </div>


        </div>
        <!-- /.container-fluid -->
        <footer class="footer text-center">  </footer>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Custom Reasons</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="reasonleft">Reason added to left</label>
                        <input type="text" name="reasonleft" id="reasonleft" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="reasonright">Reason added to Right</label>
                        <input type="text" name="reasonright" id="reasonright" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Save Changes" name="submit form-control" class="btn btn-info">
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>



@endsection
