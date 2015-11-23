          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
              
              	  <p class="centered"><a href="javascript:void(0);"><img src="<?=base_url()?>assets/img/logo.png" class="" width="120px"></a></p>
              	  <h5 class="centered"></h5>
                  <li class="mt">
                      <a href="<?=base_url()?>index.php/admin" class="active" id="menu_home">
                          <i class="fa fa-dashboard"></i>
                          <span>Dashboard</span>
                      </a>
                  </li>
<!--                     <li>
                        <a href="<?=base_url()?>index.php/admin/cards" id="menu_orders" >
                            <i class="fa fa-book"></i>
                            <span>Cards</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/admin/establishment" id="menu_orders" >
                            <i class="fa fa-book"></i>
                            <span>Establishment</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/admin/offers" id="menu_orders" >
                            <i class="fa fa-book"></i>
                            <span>offers</span>
                        </a>
                    </li> -->
              	  <?php
                    if($this->ion_auth->in_group('admin')){
                  ?>
                    <li>
                        <a href="<?=base_url()?>index.php/admin/cards" id="menu_orders" >
                            <i class="fa fa-book"></i>
                            <span>Cards</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/admin/establishment" id="menu_orders" >
                            <i class="fa fa-book"></i>
                            <span>Establishment</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/admin/offers" id="menu_orders" >
                            <i class="fa fa-book"></i>
                            <span>offers</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/admin/expired_offers" id="menu_orders" >
                            <i class="fa fa-book"></i>
                            <span>Expired offers</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/admin/category" id="menu_orders" >
                            <i class="fa fa-book"></i>
                            <span>Category</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/admin/sub_Category" id="menu_orders" >
                            <i class="fa fa-book"></i>
                            <span>Sub Category</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/admin/issuing_organization" id="menu_orders" >
                            <i class="fa fa-book"></i>
                            <span>Issuing Organization</span>
                        </a>
                    </li>
                    <li class="sub-menu">
                      <a href="javascript:void(0);" id="sub" >
                          <i class="fa fa-book"></i>
                          <span>Cedilla File</span>
                      </a>
                        <ul class="sub">
                          <li><a href="<?=base_url()?>index.php/admin/cadilla_offers">Offers</a></li>
                          <li><a href="<?=base_url()?>index.php/admin/cadilla_cards">Cards</a></li>
                          <li><a href="<?=base_url()?>index.php/admin/cadilla_establishment">Establishment</a></li>
                      </ul>
                    </li>
                  <?php
                    } else {
                  ?>
                    <li>
                        <a href="<?=base_url()?>index.php/admin/cards" id="menu_orders" >
                            <i class="fa fa-book"></i>
                            <span>Cards</span>
                        </a>
                    </li>
                  <?php
                    }
                  ?>
 <!--                   <li class="sub-menu">
                      <a href="javascript:void(0);" id="menu_orders" >
                          <i class="fa fa-book"></i>
                          <span>Users</span>
                      </a>

                        <ul class="sub">
                          <li><a href="<?=base_url()?>index.php/admin/users">All users</a></li>
                          <li><a href="<?=base_url()?>index.php/admin/users/verified">Verified Users</a></li>
                          <li><a href="<?=base_url()?>index.php/admin/users/unverified">Unverified Users</a></li>
                      </ul>
                  </li>
<!--                   <li>
                      <a href="<?=base_url()?>index.php/admin/card" id="menu_categories">
                          <i class="fa fa-desktop"></i>
                          <span>Card</span>
                      </a>
                  </li>
                  <li>
                      <a href="<?=base_url()?>index.php/admin/wallet" id="menu_orders" >
                          <i class="fa fa-book"></i>
                          <span>Wallet</span>
                      </a>
                  </li> -->
<!--                   <li class="sub-menu">
                      <a href="javascript:void(0);" id="menu_orders" >
                          <i class="fa fa-book"></i>
                          <span>Auctions</span>
                      </a>
                        <ul class="sub">
                          <li><a href="<?=base_url()?>index.php/admin/auction">All Auctions</a></li>
                          <li><a href="<?=base_url()?>index.php/admin/auction/archived">Archived Auctions</a></li>
                          <li><a href="<?=base_url()?>index.php/admin/auction/online">Online Auctions</a></li>
                          <li><a href="<?=base_url()?>index.php/admin/auction/ended">Ended Auctions</a></li>
                          <li><a href="<?=base_url()?>index.php/admin/auction/upcoming">Upcoming Auctions</a></li>
                      </ul>
                  </li> -->
              </ul>
              <!-- sidebar menu end-->
          </div>
          
          <script>
            $('.sidebar-menu li a').removeClass('active');
            $('#menu_<?=strtolower($this->uri->segment(2, 0))?>').addClass('active');
          </script>