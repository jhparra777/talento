<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Sitio;

class CssController extends Controller
{
    public function cssHome()
    {
        $sitio = Sitio::first();
        if(isset($sitio->color)){
            if($sitio->color != ""){
                $color = $sitio->color;
            }else{
                $color = "#235F9E";
            }
        }else{
            $color = "#235F9E";
        }
        $contents = "
            a:hover,a:focus{
              color: $color;
            }
            .li-detalle{
              color:white;
            }

            .btn-common {
              background: $color;
            }
            .btn-common:hover, .btn-common:focus{
              background: #f96b73;
            }
            .btn-border{
              color: $color;
            }
            /* Back to Top */
            .back-to-top i {
              background-color: $color;
            }
            #color-style-switcher .bottom a i{
              color: $color;
            }
            /* Navbar */
            .slicknav_btn{
              border-color: $color;
              border-radius: 2px;
            }
            .slicknav_menu .slicknav_btn .slicknav_icon-bar{
              background: $color;
            }
            .slicknav_menu .slicknav_btn:hover{
              background: $color;
            }
            .slicknav_nav .active a{
              background: $color;
            }
            .slicknav_nav a:hover, .slicknav_nav .active{
              color: $color;
            }
            .slicknav_nav .dropdown li a.active{
              background: $color;
            }
            .tbtn{
              background: $color;
            }
            /* Navbar */
            .navbar-default.affix .float-right li a{
              color: < ?php echo $color; ?>!important;
              border-color: $color;
            }
            .navbar-default.affix .float-right li a:hover{
              background: $color;
            }
            .navbar-default .float-right li a:hover{
              border-color: $color;
            }
            .main-navigation .float-right li a{
              border-color: $color;
              color: < ?php echo $color; ?>!important;
            }
            .navbar-default .navbar-nav > li:hover > a, .navbar-default .navbar-nav > li > a.active{
              background: $color;
            }
            .navbar-default .navbar-nav .dropdown{
              border-color: $color;
            }
            .dropdown > li:hover > a{
              background-color: $color;
            }
            .dropdown > li:hover > a{
              background-color: $color;
              color: #fff;
            }
            .dropdown li a.active, .sup-dropdown li a.active{
              background-color: $color;
              color: #fff;
            }
            .dropdown-menu li a:hover, .dropdown-menu li a:focus, .dropdown-menu li a:active{
              background: $color;
            }
            .btn-search-icon{
              background: $color;
            }
            .popular-jobs a:hover{
              background:  $color;
              border-color:  $color; 
            }
            .full-time{
              background: $color;
            }
            .job-list .job-tag .icon{
              color: $color;
            }
            .find-job .showing a span{
              color: $color;
            }
            .job-list .job-tag .meta-tag span a:hover{
              color: $color;
            }
            .pagination .active > a, .pagination .active > a:focus, .pagination > .active > a:hover, .pagination > .active > span, .pagination > .active > span:focus, .pagination > .active > span:hover{
              background: < ?php echo $color; ?>!important;
            }
            .pagination .active > a, .pagination .active > a:focus, .pagination > .active > a:hover, .pagination > .active > span, .pagination > .active > span:focus, .pagination > .active > span:hover{
              background-color: < ?php echo $color; ?>!important;
              border-color: < ?php echo $color; ?>!important;
            }
            .pagination > li > a:focus, .pagination > li > a:hover, .pagination > li > span:focus, .pagination > li > span:hover{
              background-color: < ?php echo $color; ?>!important;
              border-color: < ?php echo $color; ?>!important;
            }
            .category{
              background: $color;
            }
            .f-category .icon i{
              color: $color;
            }
            .featured-jobs .item-foot .view-iocn a{
              background: $color;
            }
            .owl-theme .owl-controls .owl-buttons div{
              background: < ?php echo $color; ?>!important;
            }
            .counting .icon i{
              color: #fff;
            }
            .counting .desc h2::after{
              background: $color;
            }
            .infobox{
              background: $color;
            }
            .bottom-social-icons a{
              background: $color;
              color: #fff;
            }
            .subscribe-box input[type='submit']{
              background: $color;
            }
            footer .menu li a:hover{
              color: $color;
            }
            #copyright p a:hover{
              color: $color;
            }

            /* ==========================================================================
             Pages Color Start
             ========================================================================== */
             .find-job .nav-tabs > li.active > a, .find-job .nav-tabs > li.active > a:focus, .find-job .nav-tabs > li.active > a:hover{
              background: $color;
             }
             .find-job .nav-tabs > li > a{
              color: $color;
              border-color: < ?php echo $color; ?>!important;
             }
             .find-job .nav > li > a:focus, .find-job .nav > li > a:hover{
              background-color: $color;
             }
             .breadcrumb{
              color: $color;
             }
             .medium-title::before{
              border-bottom: 2px solid $color;
             }
             .service-item .icon-wrapper i{
              color: $color;
             }
             .job-detail .text-left .meta span i{
              color: $color;
             }
             .job-detail .text-left .price i{
              color: $color;
             }
             .job-detail .clearfix ul li i{
              color: $color;
             }
            .job-detail .sidebar .text-box h4 a{
              color: $color;
            }
            .job-detail .sidebar .text-box a.text i{
              color: $color;
            }
            .job-detail .sidebar .text-box strong.price i{
              color: $color;
            }
            .job-detail .sidebar .sidebar-jobs ul li span i{
              color: $color;
            }
            .right-sideabr .lest li a.active{
              color: $color;
            }
            .right-sideabr .lest li a:hover{
              color: $color; 
            }
            .right-sideabr .lest .notinumber{
              background: $color;
            }
            .panel-default .panel-heading{
              background: < ?php echo $color; ?>!important;
              border: $color;
            }
            #pricing-table .table .pricing-header .price-value{
              color: $color;
            }
            #pricing-table #active-tb .pricing-header{
              background: $color;
            }
            #pricing-table .table:hover .pricing-header{
              background: $color;
            }
            .form-control:focus, textarea:focus{
              border-color: $color;
            }
            .all-categories ul li a:hover{
              color: $color;
            }
            .post-header a{
              color: $color;
            }
            .close i{
              background: $color;
            }
            .blog-post .post-content .meta .meta-part a:hover,
            .blog-post .post-content .meta .meta-part a:focus{
              color: $color;
            }
            .widget-title{
              border-bottom-color: $color;
            }
            .widget-title::before{
              border-bottom-color: $color;
            }
            #sidebar .cat-list li a:hover{
              color: $color;
            }
            #sidebar .tag a{
              background: $color;
            }
            blockquote{
              background: $color;
            }
            .reply-link{
              color: $color;
            }
            .tp-bullets.preview3 .bullet:hover, .tp-bullets.preview3 .bullet.selected{
              border-color: < ?php echo $color; ?>!important;
            }
            .tparrows.preview3:hover:after{
              background: < ?php echo $color; ?>!important;
            }
            .tparrows.preview3:hover:after{color:#fff}

            @import url('https://fonts.googleapis.com/css?family=Nunito+Sans:400,700,900');
/* ==========================================================================
   Gobal Styles
   ========================================================================== */
/* ==========================================================================
   Google Font Loader
   ========================================================================== */
/* ==========================================================================
   Common Styles
   ========================================================================== */
body {
  font-family: 'Nunito Sans', sans-serif;
  font-weight: 400;
  font-size: 13px;
  line-height: 24px;
  overflow-x: hidden;
  /* fixing the overflow duting animation */
  color: #38160A
  ;
}
h1,
h2,
h3,
h4,
h5,
h6 {
  font-weight: 700;
  margin-top: 0;
  margin-bottom: 0;
}
h1 {
  font-size: 3em;
}
h3 {
  font-size: 1.6em;
  line-height: 1.4em;
}
p {
  font-size: 14px;
  font-family: 'Nunito Sans', sans-serif;
  margin: 0;
  line-height: 24px;
  font-weight: 400;
}
a {
  color: #444;
  -webkit-transition: all .3s linear;
  -moz-transition: all .3s linear;
  -ms-transition: all .3s linear;
  -o-transition: all .3s linear;
  transition: all .3s linear;
}
a:hover,
a:focus {
  color: $color;
}
img {
  max-width: 100%;
}
ul {
  margin: 0px;
  padding: 0px;
}
ul li {
  list-style: none;
  margin: 0;
}
ol {
  list-style: none;
}
a:hover,
a:focus {
  text-decoration: none;
  outline: none;
}
.center {
  text-align: center;
}
.autocomplete-suggestions{
  color: #fff;
}
::selection {
  background: $color;
  color: #fff;
}
::-moz-selection {
  background: $color;
  color: #fff;
}
.btn {
  padding: 12px 30px;
  color: #fff;
  position: relative;
  -webkit-transition: all .3s linear;
  -moz-transition: all .3s linear;
  -ms-transition: all .3s linear;
  -o-transition: all .3s linear;
  transition: all .3s linear;
  border: none;
}
.btn-common:hover,
.btn-common:focus {
  color: #fff;
  background: #4caf50;
  box-shadow: 0 1px 6px 0 rgba(0, 0, 0, 0.12), 0 1px 6px 0 rgba(0, 0, 0, 0.12);
}
.btn-secundario{
  color:$color;
  border:1px solid $color;
  background:white !important;
}
btn-primario{
  background:$color;
  color:white !important;
}

.btn-search-icon:hover {
  opacity: 0.8;
}
.btn-common {
  background-color: $color;
  border: none;
  border-radius: 50px;
  text-transform: uppercase;
  overflow: hidden;
  position: relative;
}
.btn-border {
  background: #fff;
  color: $color;
  text-transform: uppercase;
  border-radius: 50px;
  overflow: hidden;
  position: relative;
}
.btn-border:hover {
  color: $color;
  box-shadow: 0 1px 6px 0 rgba(0, 0, 0, 0.12), 0 1px 6px 0 rgba(0, 0, 0, 0.12);
}
.btn-search {
  padding: 11px;
}
.btn-lg {
  padding: 15px 30px;
  font-weight: 700;
  letter-spacing: 0.3px;
  border-radius: 4px;
}
.btn-sm {
  font-size: 14px;
  padding: 7px 18px;
  line-height: 1.5;
  margin-bottom: 5px;
  border: none;
  text-transform: capitalize;
}
.btn.btn-sm,
.btn-group-sm .btn,
.navbar .navbar-nav > li > a.btn.btn-sm,
.btn-group-sm .navbar .navbar-nav > li > a.btn {
  padding: 5px 20px;
  font-size: 13px;
}
.btn-xs {
  border-radius: 0px;
  font-size: 12px;
  line-height: 1.5;
  padding: 1px 5px;
}
.btn-rm {
  padding: 10px 21px;
  text-transform: uppercase;
}
.btn-post {
  padding: 10px 16px;
}
.btn-search-icon {
  padding: 14px 22px;
  height: 55px;
  font-size: 22px;
  background: $color;
  color: #fff;
  width: 65px;
  text-align: center;
}
.btn-search-icon:hover {
  color: #fff;
}
.section {
  padding: 60px 0;
}
.section-title {
  font-size: 36px;
  padding: 0px 0px 30px;
  font-weight: 900;
}
.medium-title {
  font-size: 24px;
  padding: 10px 0;
  text-transform: uppercase;
  position: relative;
}
.medium-title:before {
  position: absolute;
  content: ' ';
  width: 56px;
  bottom: 0px;
  margin-left: 0;
  margin-right: 0;
  border-bottom: 2px solid $color;
}
#content {
  padding: 80px 0;
}
.main-container {
  padding: 80px 0;
}
.no-padding {
  padding: 0px !important;
}
.page-header {
  padding: 40px 0;
  margin: 0;
  border-top: 1px solid #999;
  position: relative;
}
.page-header .product-title {
  font-size: 30px;
  line-height: 38px;
  font-weight: 900;
  letter-spacing: 1px;
  color: #fff;
}
.breadcrumb-wrapper {
  text-align: center;
}
.breadcrumb {
  font-size: 14px;
  color: $color;
  border-radius: 0px;
  background: transparent;
  padding: 5px 0px;
  z-index: 1;
}
.breadcrumb a {
  color: #fff;
}
.breadcrumb a:hover {
  color: $color;
}
/*  preloader   */
#loading {
  background-color: #fff;
  height: 100%;
  width: 100%;
  position: fixed;
  z-index: 9999999;
  margin-top: 0px;
  top: 0px;
}
#loading #loading-center {
  width: 100%;
  height: 100%;
  position: relative;
}
#loading #loading-center-absolute {
  position: absolute;
  left: 50%;
  top: 50%;
  height: 150px;
  width: 150px;
  margin-top: -75px;
  margin-left: -75px;
  -ms-transform: rotate(45deg);
  -webkit-transform: rotate(45deg);
  transform: rotate(45deg);
}
#loading .object {
  width: 20px;
  height: 20px;
  background-color: $color;
  position: absolute;
  left: 65px;
  top: 65px;
  border-radius: 500px;
}
#loading .object:nth-child(2n+0) {
  margin-right: 0px;
}
#loading #object_one {
  -webkit-animation: object_one 2s infinite;
  animation: object_one 2s infinite;
  -webkit-animation-delay: 0.2s;
  animation-delay: 0.2s;
}
#loading #object_two {
  -webkit-animation: object_two 2s infinite;
  animation: object_two 2s infinite;
  -webkit-animation-delay: 0.3s;
  animation-delay: 0.3s;
}
#loading #object_three {
  -webkit-animation: object_three 2s infinite;
  animation: object_three 2s infinite;
  -webkit-animation-delay: 0.4s;
  animation-delay: 0.4s;
}
#loading #object_four {
  -webkit-animation: object_four 2s infinite;
  animation: object_four 2s infinite;
  -webkit-animation-delay: 0.5s;
  animation-delay: 0.5s;
}
#loading #object_five {
  -webkit-animation: object_five 2s infinite;
  animation: object_five 2s infinite;
  -webkit-animation-delay: 0.6s;
  animation-delay: 0.6s;
}
#loading #object_six {
  -webkit-animation: object_six 2s infinite;
  animation: object_six 2s infinite;
  -webkit-animation-delay: 0.7s;
  animation-delay: 0.7s;
}
#loading #object_seven {
  -webkit-animation: object_seven 2s infinite;
  animation: object_seven 2s infinite;
  -webkit-animation-delay: 0.8s;
  animation-delay: 0.8s;
}
#loading #object_eight {
  -webkit-animation: object_eight 2s infinite;
  animation: object_eight 2s infinite;
  -webkit-animation-delay: 0.9s;
  animation-delay: 0.9s;
}
@-webkit-keyframes object_one {
  50% {
    -webkit-transform: translate(-65px, -65px);
  }
}
@keyframes object_one {
  50% {
    transform: translate(-65px, -65px);
    -webkit-transform: translate(-65px, -65px);
  }
}
@-webkit-keyframes object_two {
  50% {
    -webkit-transform: translate(0, -65px);
  }
}
@keyframes object_two {
  50% {
    transform: translate(0, -65px);
    -webkit-transform: translate(0, -65px);
  }
}
@-webkit-keyframes object_three {
  50% {
    -webkit-transform: translate(65px, -65px);
  }
}
@keyframes object_three {
  50% {
    transform: translate(65px, -65px);
    -webkit-transform: translate(65px, -65px);
  }
}
@-webkit-keyframes object_four {
  50% {
    -webkit-transform: translate(65px, 0);
  }
}
@keyframes object_four {
  50% {
    transform: translate(65px, 0);
    -webkit-transform: translate(65px, 0);
  }
}
@-webkit-keyframes object_five {
  50% {
    -webkit-transform: translate(65px, 65px);
  }
}
@keyframes object_five {
  50% {
    transform: translate(65px, 65px);
    -webkit-transform: translate(65px, 65px);
  }
}
@-webkit-keyframes object_six {
  50% {
    -webkit-transform: translate(0, 65px);
  }
}
@keyframes object_six {
  50% {
    transform: translate(0, 65px);
    -webkit-transform: translate(0, 65px);
  }
}
@-webkit-keyframes object_seven {
  50% {
    -webkit-transform: translate(-65px, 65px);
  }
}
@keyframes object_seven {
  50% {
    transform: translate(-65px, 65px);
    -webkit-transform: translate(-65px, 65px);
  }
}
@-webkit-keyframes object_eight {
  50% {
    -webkit-transform: translate(-65px, 0);
  }
}
@keyframes object_eight {
  50% {
    transform: translate(-65px, 0);
    -webkit-transform: translate(-65px, 0);
  }
}
/* ==========================================================================
   Navigation Menu Styles
   ========================================================================== */
.navbar-default.affix {
  width: 100%;
  top: 0;
  z-index: 9999;
  box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
  background: #fff;
  -webkit-animation-duration: 1s;
  animation-duration: 1s;
  -webkit-animation-fill-mode: both;
  animation-fill-mode: both;
  -webkit-animation-name: fadeInDown;
  animation-name: fadeInDown;
}
.navbar-default.affix .navbar-brand {
  padding: 7px 0px;
}
.navbar-default.affix .navbar-nav {
  margin: 10px 0px 0px 20px;
}
.navbar-default.affix .navbar-nav > li > a,
.navbar-default.affix .navbar-nav > li > a:focus {
  padding: 10px 14px;
  color: #444;
}
.navbar-default.affix .side {
  padding: 18px 0;
}
.navbar-default.affix .navbar-nav > li > .dropdown-menu {
  margin-top: 0;
}
.navbar-default.affix .float-right li a {
  color: $color !important;
  border: 1px solid $color;
}
.navbar-default.affix .float-right li a:hover {
  background: $color;
  color: #fff!important;
}
.navbar {
  margin-bottom: 0;
  background: #ffffff; 
  border: none;
  border-radius: 0px;
  box-shadow: inset 0px -1px 0px 0px rgba(255, 255, 255, 0.2);
  -webkit-border-radius: 0;
  -moz-border-radius: 0;
  -o-border-radius: 0;
  padding:0;
  
}
@media only screen and (min-width: 768px) {
  .navbar {
    padding: 35px 0;
  }
}

.navbar-brand {
  position: relative;
  margin: 0!important;
  padding: 15px 0;
  transition: all 0.3s ease-in-out;
  -moz-transition: all 0.3s ease-in-out;
  -webkit-transition: all 0.3s ease-in-out;
  -o-transition: all 0.3s ease-in-out;
      width: 160px;
}
.navbar-brand .ripple-container {
  display: none;
}
.navbar-default .navbar-nav {
  position: relative;
  margin: 20px 0px 5px 20px;
  transition: all 0.3s ease-in-out;
  -moz-transition: all 0.3s ease-in-out;
  -webkit-transition: all 0.3s ease-in-out;
  -o-transition: all 0.3s ease-in-out;
}
.navbar-default .navbar-nav > li {
  margin-right: 5px;
  padding-bottom: 10px;
}
.navbar-default .navbar-nav > li > a {
  color: #222;
  display: block;
  font-size: 15px;
  border-radius: 4px;
  padding: 10px 14px;
  font-weight: 400;
  letter-spacing: 0.5px;
  overflow: hidden;
  transition: all 0.3s ease-in-out;
  -moz-transition: all 0.3s ease-in-out;
  -webkit-transition: all 0.3s ease-in-out;
  -o-transition: all 0.3s ease-in-out;
}
.navbar-default .navbar-nav > li:hover > a,
.navbar-default .navbar-nav > li > a.active {
  color: #fff;
  background-color: $color;
}
.navbar-default .navbar-nav .dropdown {
  background: #ffffff;
  box-shadow: 0 0 25px 0 rgba(0, 0, 0, 0.08);
  left: 0;
  border-radius: 3px;
  padding: 10px;
  position: absolute;
  text-align: left;
  top: 100%;
  transition: opacity 0.3s ease-in-out;
  -moz-transition: opacity 0.3s ease-in-out;
  -webkit-transition: opacity 0.3s ease-in-out;
  -o-transition: opacity 0.3s ease-in-out;
  visibility: hidden;
  opacity: 0;
  width: 195px;
  z-index: 999;
}
.navbar-default .navbar-nav .dropdown:before {
  position: absolute;
  top: -6px;
  left: 22px;
  display: block;
  content: '';
  width: 0px;
  height: 0px;
  border-style: solid;
  border-width: 0px 8px 7px;
  border-color: transparent transparent #fff;
  box-sizing: border-box;
}
.navbar-default .navbar-nav > li.drop:hover .dropdown {
  visibility: visible;
  opacity: 1;
}
.dropdown li a.active,
.sup-dropdown li a.active {
  color: $color;
}
.dropdown > li:hover > a,
.sup-dropdown li:hover > a {
  color: $color;
}
.dropdown li,
.sup-dropdown li {
  position: relative;
}
.dropdown li a,
.sup-dropdown li a {
  display: block;
  color: #666;
  margin-bottom: 2px;
  font-size: 13px;
  font-family: 'Nunito Sans', sans-serif;
  padding: 5px 10px;
  line-height: 26px;
  transition: all 0.3s ease-in-out;
  -moz-transition: all 0.3s ease-in-out;
  -webkit-transition: all 0.3s ease-in-out;
  -o-transition: all 0.3s ease-in-out;
}
.dropdown li a i {
  float: right;
  font-size: 17px;
  position: relative;
  top: -1px;
  margin: 4px 5px;
}
.navbar-default .navbar-nav .sup-dropdown {
  position: absolute;
  left: 100%;
  top: 0;
  border-radius: 2px;
  border-bottom: 2px solid $color;
  padding: 12px;
  width: 195px;
  background-color: #fff;
  margin-left: 10px;
  z-index: 3;
  box-shadow: 0 0 25px 0 rgba(0, 0, 0, 0.08);
  -webkit-transform: scaleX(0);
  transform: scaleX(0);
  -webkit-transform-origin: 0 0 0;
  transform-origin: 0 0 0;
  -webkit-transition: all 0.6s ease 0s;
  transition: all 0.6s ease 0s;
}
.navbar-default .navbar-nav li.drop .dropdown li:hover .sup-dropdown {
  opacity: 1;
  -webkit-transform: scaleX(1);
  transform: scaleX(1);
  z-index: 9999;
}
.float-right {
  border-radius: 0px;
  margin-left: 30px;
}
.float-right li a {
  font-size: 13px;
  color: $color!important;
  background-color: rgba(255, 255, 255, 0.1);
  border: 1px solid $color;
  padding: 10px 15px;
  margin-right: 0px;
  text-transform: uppercase;
}
.float-right li a:hover {
  background: $color;
  color: #fff !important;
}
.float-right li a i {
  margin-right: 3px;
}
.main-navigation {
  background: #fff;
}
.main-navigation .navbar-nav > li > a {
  color: #444;
}
.main-navigation .float-right li a {
  color: $color !important;
  border: 1px solid $color;
}
.main-navigation .float-right li a:hover {
  color: #fff!important;
}
.main-navigation .navbar-nav .dropdown {
  background: #282828;
}
.main-navigation .dropdown li a,
.main-navigation .sup-dropdown li a {
  color: #fff;
}
.main-navigation .navbar-nav .dropdown:before {
  border-color: transparent transparent #282828;
}
.wpb-mobile-menu {
  display: none;
}
.wpb-mobile-menu ul li > ul {
  padding: 0;
  border-style: solid;
  border-width: 4px 0 0 0;
  border-radius: 0;
  left: 0;
  right: 0;
  border-color: transparent;
}
.wpb-mobile-menu ul li > ul > li > a {
  color: #666;
  padding: 10px 0 10px 15px;
}
.wpb-mobile-menu ul li > ul > li > a:hover,
.wpb-mobile-menu ul li > ul > li > a .active {
  background: #ecf0f1;
}
.wpb-mobile-menu ul li > ul > li.active > a {
  background: #ecf0f1;
}
.slicknav_menu {
  display: none;
}
@media screen and (max-width: 767px) {
  .navbar-brand {
    position: absolute;
    top: 0;
  }
  .tbtn {
    display: none;
  }
  /* #menu is the original menu */
  .slicknav_menu {
    display: block;
  }
}
@media screen and (max-width: 768px) {
  .navbar-toggle {
    display: none;
  }
  .tbtn {
    display: none;
  }
  .titulo-principal-home{
    font-size:3em!important;
  }
  .subtitulo-home{
    font-size:2.5em!important;
  }
}
.tbtn {
  color: #FFF !important;
  font-size: 30px;
  height: 42px;
  border-top-right-radius: 4px;
  border-bottom-right-radius: 4px;
  width: 105px;
  padding: 10px;
  cursor: pointer;
  position: fixed;
  background: $color;
  z-index: 999;
  top: 124px;
  left: 0px;
}
.tbtn p {
  font-size: 12px;
}
.tbtn p i {
  margin-right: 4px;
  font-size: 14px;
}
.title-menu {
  font-size: 15px;
  color: #666;
  padding: 12px 15px;
  border-bottom: 1px solid #eee;
}
.navmenu,
.navbar-offcanvas {
  width: 180px;
  z-index: 9999999;
}
.navmenu-default,
.navbar-default .navbar-offcanvas {
  background-color: #fff;
}
.navmenu-default .navmenu-nav > li > a:hover,
.navbar-default .navbar-offcanvas .navmenu-nav > li > a:hover,
.navmenu-default .navmenu-nav > li > a:focus,
.navbar-default .navbar-offcanvas .navmenu-nav > li > a:focus {
  color: #fff;
  background-color: $color;
}
.nav > li {
  position: relative;
  display: block;
}
.navmenu-default .navmenu-nav > li > a,
.navbar-default .navbar-offcanvas .navmenu-nav > li > a {
  color: #666;
  padding: 0px 15px;
  font-size: 12px;
  border-bottom: 1px solid #eee;
}
nav#menu span.fa.fa-bars:hover {
  color: $color;
}
.navmenu-default .navmenu-nav > .active > a,
.navbar-default .navbar-offcanvas .navmenu-nav > .active > a,
.navmenu-default .navmenu-nav > .active > a:hover,
.navbar-default .navbar-offcanvas .navmenu-nav > .active > a:hover,
.navmenu-default .navmenu-nav > .active > a:focus,
.navbar-default .navbar-offcanvas .navmenu-nav > .active > a:focus {
  background: $color;
  color: #fff;
}
.close {
  background: transparent;
  padding: 14px 12px;
  opacity: 1;
}
.close i {
  background: $color;
  color: #fff;
  padding: 8px;
  border-radius: 50px;
  font-size: 12px;
}
/* ==========================================================================
   Custom Component
   ========================================================================== */
/* ==========================================================================
   Preset Loader
   ========================================================================== */
/*====================================================
    intro section style
    ====================================================*/
.section-intro {
  background: url('assets/img/bg/bg-intro.jpg') center center no-repeat;
  background-size: cover;
  color: #fff;
  position: relative;
  width: 100%;
}
.section-intro:before {
  content: '';
  left: 0;
  width: 100%;
  height: 100%;
  display: inline-block;
  background-color: rgba(42, 46, 50, 0.3);
  position: absolute;
}
.search-container {
  padding: 25vh 0;
  display: inline-block;
  width: 100%;
  position: relative;
}
.search-container .form-control {
  padding: 0 40px;
  border: 1px solid transparent;
}
.search-container .form-group {
  margin-bottom: 0px!important;
}

@media (max-width: 992px){
  .search-container .form-group{
    margin-bottom: 20px !important;
  }
  .pull {
    width:100%;
    margin-bottom: 2em;
  }
}
@media (max-width: 402px){
  .pull a{
    display:block !important;
    margin: 10px 10px;
  }
}
.search-container h2 {
  font-size: 2.5em;
  color: #fff;
  font-weight: 400;
  margin-bottom: 30px;
  letter-spacing: -1px;
}
.search-container h1 {
  font-weight: 900;
  font-size: 50px;
  letter-spacing: 1px;
  line-height: 1em;
}
.search-container .content {
  background: rgba(255, 255, 255, 0.1);
  padding: 10px;
  margin-bottom: 30px;
}
.popular-jobs a {
  background-color: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.3);
  padding: 5px 10px;
  color: #fff;
  margin: 0 5px;
  border-radius: 4px;
  -webkit-transition: all 0.2s ease-in-out;
  -moz-transition: all 0.2s ease-in-out;
  -o-transition: all 0.2s ease-in-out;
  -ms-transition: all 0.2s ease-in-out;
  transition: all 0.2s ease-in-out;
}
.popular-jobs a:hover {
  background: $color;
  border-color: $color;
  color: #fff;
}
.section-intro .main-text {
  margin: 100px 15px 130px;
  text-transform: uppercase;
}
.section-intro .main-text .intro-title {
  font-size: 48px;
  color: #fff;
  white-space: nowrap;
  line-height: 58px;
}
.section-intro .main-text .sub-title {
  font-size: 14px;
  color: #fff;
  padding: 15px 0;
  line-height: 24px;
  text-transform: capitalize;
  margin-bottom: 15px;
}
#search-row-wrapper {
  background: url('assets/img/bg/counter-bg.jpg') center center no-repeat;
  background-size: cover;
  color: #fff;
  text-align: center;
}
#search-row-wrapper .overlay {
  background: url('assets/img/bg/bg-overlay.png') rgba(0, 0, 0, 0.3) repeat;
  width: 100%;
  height: 100%;
}
#search-row-wrapper .search-inner {
  padding: 40px 0;
}
#intro-bg {
  background: url('assets/img/bg/bg-intro-1.jpg') center center no-repeat;
  background-size: cover;
  color: #fff;
  position: relative;
  width: 100%;
}
#intro-bg:before {
  content: '';
  left: 0;
  width: 100%;
  height: 100%;
  display: inline-block;
  background-color: rgba(42, 46, 50, 0.7);
  position: absolute;
}
/* ==========================================================================
   Advanced search
   ========================================================================== */
.search-bar {
  background: rgba(68, 68, 68, 0.7);
  padding: 20px;
}
.search-bar i {
  font-size: 15px;
  position: absolute;
  top: 0px;
  background-color: transparent;
  color: #444;
  right: 15px;
  padding: 15px;
}
.search-bar label {
  z-index: 0;
  font-weight: 400;
  width: 100%;
  margin: 0px;
}
.search-bar .form-group {
  margin-bottom: 0px!important;
}
.input-group-addon {
  border: none;
}
.search-category .search-category-container {
  border: none;
  padding: 0;
  position: relative;
  border-radius: 0;
  border: none!important;
  background: #fff;
}
.input-group-addon {
  padding: 0!important;
}
.styled-select {
  position: relative;
  width: 100%;
  background: #fff;
}
.styled-select:before {
  float: left;
  position: absolute;
  font-family: themify;
  color: #666;
  left: 2px;
  padding: 13px;
  z-index: 999;
}
.styled-select > select {
  background: transparent;
  font-size: 14px;
  line-height: 18px;
  border: 0;
  border-radius: 0;
  height: 44px;
}
.search-category select {
  padding: 12px;
  border: none;
  background: transparent;
  font-size: 14px;
  font-weight: 400;
  color: #333;
}
select > opation:focus {
  box-shadow: none;
  border: none;
}
.dropdown-product select.balck {
  background-color: #666;
}
.dropdown-product select.option3 {
  border-radius: 10px 0;
}
.bootstrap-select .dropdown-toggle:focus {
  outline: thin dotted transparent!important;
  outline: 0px auto -webkit-focus-ring-color !important;
  outline-offset: 0px!important;
}
.btn-default {
  padding: 17px 14px;
  border-radius: 0px;
  color: #2d2d2d !important;
  background: #fff;
  text-transform: none;
}
.btn-default:hover {
  background-color: #fff;
  border-color: #fff;
}
label {
  margin: 0;
}
.bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
  width: 100%;
}
.bootstrap-select.btn-group .dropdown-toggle .filter-option {
  margin-left: 30px;
}
.page-ads .styled-select {
  width: 100%;
  background-color: #FFF;
  border: 1px solid #ddd;
  border-radius: 0px;
  box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.075);
  color: #444;
  display: block;
}
.page-ads .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
  width: 100%;
}
/* ==========================================================================
   Jobs section Start
   ========================================================================== */
.find-job {
  background: #f5f5f5;
}
.find-job .tabs-container {
  background: #F0F3FA;
  padding: 15px;
  border: 1px solid #ddd;
}
.find-job .nav-tabs {
  padding: 20px 0;
  background: transparent;
}
.find-job .nav-tabs > li > a {
  padding: 10px 15px;
  font-size: 14px;
  color: $color;
  text-transform: uppercase;
  border: 1px solid $color !important;
  border-radius: 0px;
  margin-right: 10px;
  font-weight: 700;
}
.find-job .nav > li > a:focus,
.find-job .nav > li > a:hover {
  background-color: $color;
  color: #fff;
}
.find-job .nav-tabs > li.active > a,
.find-job .nav-tabs > li.active > a:focus,
.find-job .nav-tabs > li.active > a:hover {
  border-radius: 0px;
  background: $color;
  color: #fff;
}
.find-job table td {
  line-height: 78px !important;
  font-size: 14px;
  font-weight: 700;
}
.find-job td img {
  margin-right: 10px;
}
.find-job .table-striped > tbody > tr:nth-of-type(2n+1) {
  background: #fff;
}
.find-job .table > caption + thead > tr:first-child > td,
.find-job .table > caption + thead > tr:first-child > th,
.find-job .table > colgroup + thead > tr:first-child > td,
.find-job .table > colgroup + thead > tr:first-child > th,
.find-job .table > thead:first-child > tr:first-child > td,
.find-job .table > thead:first-child > tr:first-child > th {
  padding: 15px 0;
  color: #627198;
  font-size: 14px;
  font-weight: 700;
}
.find-job .pill {
  display: inline-block;
  padding: 4px 4px;
  height: 18px;
  line-height: 12px;
  text-align: center;
  border-radius: 30px;
  color: white;
}
.find-job .pill.medium {
  padding: 4px 10px;
  height: 22px;
  font-size: 12px;
  line-height: 15px;
}
.find-job .green {
  background: #9DB722;
}
.find-job .red {
  background: #DE4003;
}
.find-job .yellow {
  background: #DDA103;
}
.find-job .showing a {
  margin-left: 10px;
  font-size: 14px;
  line-height: 32px;
}
.find-job .showing a span {
  color: $color;
}
.find-job .pagination > li > a,
.find-job .pagination > li > span {
  margin-right: 5px;
  border-radius: 50px;
  background: transparent;
}
.find-job .pagination .btn i {
  font-size: 10px;
}
.my-account-form{
  width: 70%;
  box-shadow: 3px 3px 9px rgba(0, 0, 0, 0.075);
  background: #fff;
}
.color{
  background: $color;
  color: #fff;
  padding: 20px;
  font-size: 26px;
  text-align: center;

}
.my-account-form form{
  padding: 20px;
  padding-bottom: 80px;
}
.btn-rm {
    width: 100%;
    padding: 12px 22px;
    margin: 0 10px;
    letter-spacing: 1;
    text-transform: capitalize;
    font-size: 20px;
    border-radius: 10px;
}
/**** botones registro social ****/
.bottom-social-icons a{
  display: block;
}
.bottom-social-icons a.linkedin, .bottom-social-icons a.google-plus, .bottom-social-icons a.facebook{
  padding: 10px;
  font-size: 16px;
  background: #006097;
  text-align: center;
}
.bottom-social-icons a.google-plus{
 background: #C93213;
}

.bottom-social-icons a.facebook{
  background: #3C5A98;
  margin-right:0;
}
.bottom-social-icons.social-icon {
    margin-top: 20px;
}
.my-account-login, .job-list {
    background: #fff;
    padding: 20px;
     box-shadow: 3px 3px 9px rgba(0, 0, 0, 0.075);
     padding-bottom: 10px;
}
.cv-login p{
  padding: 50px 0;
}
.cv-login {
padding-bottom: 70px;
}
.pull-right a {
    display: inline;
}

/* ==========================================================================
   Category Section Start
   ========================================================================== */
.category {
  background: $color;
}
.category .section-title {
  color: #fff;
}
.f-category:hover .icon img,
.f-category:hover .icon i {
  transform: scale(1.1);
  -moz-transform: scale(1.1);
  -webkit-transform: scale(1.1);
}
.f-category {
  -webkit-transition: all .3s linear;
  -moz-transition: all .3s linear;
  -ms-transition: all .3s linear;
  -o-transition: all .3s linear;
  transition: all .3s linear;
  border: 1px solid #ddd;
  height: 190px;
  margin-top: -1px;
  background: #ffffff;
  padding: 15px;
  text-align: center;
  overflow: hidden;
  display: block;
  margin-right: -1px;
}
.f-category:hover {
  background: #eee;
}
.f-category .icon {
  margin: 15px;
}
.f-category .icon img {
  border-radius: 50px;
  box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.18), 0 2px 5px 0 rgba(0, 0, 0, 0.15);
  transform: scale(1);
  -moz-transform: scale(1);
  -webkit-transform: scale(1);
  -webkit-transition: all .3s linear;
  -moz-transition: all .3s linear;
  -ms-transition: all .3s linear;
  -o-transition: all .3s linear;
  transition: all .3s linear;
}
.f-category .icon i {
  font-size: 40px;
  padding: 20px;
  color: $color;
  transform: scale(1);
  -moz-transform: scale(1);
  -webkit-transform: scale(1);
  -webkit-transition: all .3s linear;
  -moz-transition: all .3s linear;
  -ms-transition: all .3s linear;
  -o-transition: all .3s linear;
  transition: all .3s linear;
}
.f-category h3 {
  font-size: 16px;
  text-transform: uppercase;
  line-height: 32px;
  -webkit-transition: all .3s linear;
  -moz-transition: all .3s linear;
  -ms-transition: all .3s linear;
  -o-transition: all .3s linear;
  transition: all .3s linear;
}
.f-category h3 a {
  color: #444;
}
.f-category h3 a:hover {
  color: $color;
}
.f-category p {
  color: #999;
}
/* ==========================================================================
   Featured Jobs Section Style
   ========================================================================== */
.featured-jobs .featured-item {
  position: relative;
  margin-bottom: 30px;
  border: 1px solid #f1f1f1;
  border-radius: 0px;
  -webkit-transition: all 0.15s ease;
  -moz-transition: all 0.15s ease;
  -o-transition: all 0.15s ease;
  transition: all 0.15s ease;
  cursor: pointer;
  -webkit-transition: transform 0.2s linear, -webkit-box-shadow 0.2s linear;
  -moz-transition: transform 0.2s linear, -moz-box-shadow 0.2s linear;
  transition: transform 0.2s linear, box-shadow 0.2s linear;
}
.featured-jobs .featured-item:hover {
  box-shadow: 0 13px 21px rgba(0, 0, 0, 0.13);
  -webkit-box-shadow: 0 13px 21px rgba(0, 0, 0, 0.13);
  -moz-box-shadow: 0 13px 21px rgba(0, 0, 0, 0.13);
}
.featured-jobs .featured-wrap {
  background: #fff;
  width: 100%;
  padding: 8px;
}
.featured-jobs .item-thumb {
  position: relative;
  width: 100%;
  height: 100%;
  -webkit-transition: all 0.15s ease;
  -moz-transition: all 0.15s ease;
  -o-transition: all 0.15s ease;
  transition: all 0.15s ease;
}
.featured-jobs .item-thumb a {
  display: block;
}
.featured-jobs .item-thumb:hover {
  opacity: 0.9;
}
.featured-jobs .item-body {
  padding: 20px 12px 10px;
  width: 100%;
}
.featured-jobs .item-body .job-title {
  margin: 0 0 4px 0;
}
.featured-jobs .item-body .job-title a {
  font-size: 16px;
  text-transform: uppercase;
}
.featured-jobs .item-body .job-title a:hover {
  color: $color;
}
.featured-jobs .item-body .adderess {
  color: #999;
  font-size: 14px;
  line-height: 22px;
  margin: 0;
}
.featured-jobs .item-foot {
  background: #fff;
  display: inline-block;
  width: 100%;
  border-top: 1px solid #e5e5e5;
  padding: 14px 20px;
  position: relative;
}
.featured-jobs .item-foot a {
  color: #999;
}
.featured-jobs .item-foot a:hover {
  color: $color;
}
.featured-jobs .item-foot span {
  color: #999;
  font-size: 14px;
  line-height: 22px;
  font-weight: 400;
  margin-right: 10px;
}
.featured-jobs .item-foot span i {
  margin-right: 5px;
}
.featured-jobs .item-foot .view-iocn {
  position: absolute;
  top: -24px;
  right: 24px;
}
.featured-jobs .item-foot .view-iocn a {
  width: 48px;
  display: block;
  background: $color;
  color: #fff;
  font-size: 20px;
  height: 48px;
  text-align: center;
  line-height: 50px;
  border-radius: 50px;
  box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.18), 0 2px 5px 0 rgba(0, 0, 0, 0.15);
}
/* ==========================================================================
   purchase 
   ========================================================================== */
.purchase {
  background-image: url('assets/img/parallax/bg-02.jpg');
  padding: 100px 0;
  background-attachment: absolute;
  background-position: 50% 0;
}
.purchase .title-text {
  font-size: 38px;
  text-transform: uppercase;
  color: #fff;
  margin-bottom: 30px;
}
.purchase p {
  color: #9FA7BA;
  font-size: 23px;
  letter-spacing: 1px;
  margin-bottom: 40px;
}
/* ==========================================================================
   Blog 
   ========================================================================== */
#blog .blog-item-wrapper {
  background: #fff;
  border-radius: 0px;
  margin-bottom: 30px;
  -webkit-transition: transform 0.2s linear, -webkit-box-shadow 0.2s linear;
  -moz-transition: transform 0.2s linear, -moz-box-shadow 0.2s linear;
  transition: transform 0.2s linear, box-shadow 0.2s linear;
}
#blog .blog-item-wrapper:hover {
  box-shadow: 0 13px 21px rgba(0, 0, 0, 0.13);
  -webkit-box-shadow: 0 13px 21px rgba(0, 0, 0, 0.13);
  -moz-box-shadow: 0 13px 21px rgba(0, 0, 0, 0.13);
}
#blog .blog-item-img {
  position: relative;
}
#blog .blog-item-img img {
  width: 100%;
}
#blog .blog-item-text {
  border: 1px solid #f1f1f1;
  padding: 15px;
}
#blog .blog-item-text .meta-tags {
  margin-bottom: 10px;
}
#blog .blog-item-text .meta-tags span {
  margin-right: 10px;
}
#blog .blog-item-text .meta-tags span i {
  margin-right: 5px;
}
#blog .blog-item-text h3 {
  line-height: 26px;
  font-size: 16px;
  font-weight: 700;
  margin-bottom: 10px;
}
#blog .blog-item-text p {
  line-height: 25px;
  margin-bottom: 20px;
}
/* ==========================================================================
   Testimonial Section Start
   ========================================================================== */
#testimonial {
  width: 100%;
  background: url(assets/img/testimonial/testimonial-bg.jpg);
  background-size: cover;
  position: relative;
}
#testimonial:before {
  position: absolute;
  content: ' ';
  top: 0;
  bottom: 0;
  width: 100%;
  height: 100%;
}
#testimonial .img-member {
  height: 90px;
  border-radius: 100%;
  margin-top: 22px;
  overflow: hidden;
  width: 90px;
}
#testimonial .client-info {
  color: #fff;
  line-height: 20px;
  margin: 20px auto;
}
#testimonial .client-info .client-name {
  font-size: 20px;
  line-height: 44px;
  text-transform: uppercase;
}
#testimonial .client-info .client-name span {
  font-size: 13px;
  font-weight: 400;
  color: #fff;
  text-transform: none;
  font-style: italic;
}
#testimonial p {
  margin: 20px;
  text-align: center;
  font-size: 14px;
  letter-spacing: 0.9px;
  color: #fff;
  font-style: italic;
  position: relative;
}
#testimonial p .quote-left {
  font-size: 32px;
  margin-right: 36px;
}
#testimonial p .quote-right {
  font-size: 32px;
  margin-left: 36px;
}
#testimonial .owl-theme .owl-controls .owl-buttons div {
  border-radius: 50%;
  font-size: 30px;
  margin: 20px 10px 0;
  padding: 0 12px;
}
.touch-slider .owl-controls .owl-buttons {
  position: relative;
  top: -190px;
  left: 0;
}
.touch-slider .owl-controls .owl-buttons div.owl-prev {
  float: left;
  margin-left: -45px;
}
.touch-slider .owl-controls .owl-buttons div.owl-next {
  float: right !important;
  margin-right: -45px;
}
.owl-theme .owl-controls .owl-buttons div {
  width: 40px;
  height: 40px;
  line-height: 30px;
  display: block !important;
  background: $color !important;
  text-align: center;
  display: inline-block;
  opacity: 1!important;
  border-radius: 50px!important;
  box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.18), 0 2px 5px 0 rgba(0, 0, 0, 0.15);
  transition: all 0.4s ease-in-out;
  -moz-transition: all 0.4s ease-in-out;
  -webkit-transition: all 0.4s ease-in-out;
  -o-transition: all 0.4s ease-in-out;
}
.owl-theme .owl-controls .owl-buttons div:hover {
  box-shadow: 0 5px 11px 0 rgba(0, 0, 0, 0.18), 0 4px 15px 0 rgba(0, 0, 0, 0.15);
  opacity: 0.8!important;
}
.owl-theme .owl-controls .owl-buttons div i {
  color: #fff;
  font-size: 14px;
  line-height: 40px;
}
/* ==========================================================================
   Clients Section
   ========================================================================== */
.clients {
  background: #f7f7f7;
}
.clients .items {
  margin: 15px;
  text-align: center;
}
/* ==========================================================================
    Counter Style
    ========================================================================== */
#counter {
  /*background: url('assets/img/bg/counter-bg.png') center center no-repeat;
  background-size: cover;*/
  color: $color;
  padding: 8rem;
  text-align: center;
}
.counting {
  margin: 15px 0px;
}
.counting .icon {
  margin-bottom: 25px;
}
.counting .icon i {
  color: $color;
  font-size: 42px;
}
.counting .desc h2 {
  font-size: 30px;
  line-height: 27px;
  position: relative;
  padding-bottom: 20px;
  margin-bottom: 20px;
}
.counting .desc h2:after {
  background: $color;
  bottom: 0;
  content: '';
  height: 2px;
  left: 0;
  margin: auto;
  position: absolute;
  right: 0;
  width: 45px;
}
.counting .desc h1 {
  font-size: 38px;
  line-height: 39px;
}
.counting:hover span {
  background: $color;
  -webkit-transform: scale(1.1, 1.1);
  -moz-transform: scale(1.1, 1.1);
  -ms-transform: scale(1.1, 1.1);
  -o-transform: scale(1.1, 1.1);
  transform: scale(1.1, 1.1);
}
@media(min-width: 768px) and (max-width:1000px) {
  .web-corporativa{
    display:none!important;
  }
}
@media(max-width: 780px) {
  .counting .icon i{
    font-size:27px!important;
  }
  .counting .desc h2 {
  font-size: 18px;
  line-height: 20px;
  position: relative;
  padding-bottom: 20px;
  margin-bottom: 20px;
}
.counting .desc h1 {
  font-size: 23px;
  line-height: 30px;
}
  
}
/* ==========================================================================
   Infobox Style
   ========================================================================== */
.infobox {
  background: $color;
}
.infobox .info-text {
  float: left;
  display: inline-block;
}
.infobox .info-text h2 {
  font-size: 24px;
  letter-spacing: 0.5px;
  color: #fff;
  display: inline-block;
  line-height: 40px;
  text-transform: uppercase;
}
.infobox .info-text p {
  color: #fff;
  line-height: 30px;
}
.infobox .info-text p a {
  color: #ddd;
}
.infobox .info-text p a:hover {
  color: #fff;
}
.infobox .btn {
  margin-top: 15px;
  float: right;
}
/* ==========================================================================
   Footer Style
   ========================================================================== */
/*footer .block-title {
  font-size: 24px;
  letter-spacing: 1px;
  font-weight: 900;
  margin-bottom: 30px;
}
footer .footer-Content {
  background-color: #202020;
  padding: 60px 0;
  color: #fff;
}
.textwidget {
  font-size: 14px;
  font-weight: 300;
  line-height: 24px;
  color: #fff;
}
footer .menu {
  padding-left: 0;
}
footer .menu li {
  padding-bottom: 10px;
}
footer .menu li a {
  color: #fff;
  padding: 0px;
}
footer .menu li a:hover {
  color: $color;
}
.subscribe-box {
  margin-top: 18px;
}
.subscribe-box input[type='text'] {
  color: #444;
  font-size: 12px;
  padding: 6px 12px;
  border: none;
  background: #fff;
  border-radius: 0px;
  -webkit-border-radius: 0px;
  -moz-border-radius: 0px;
  -o-border-radius: 0px;
  outline: none;
}
.subscribe-box input[type='submit'] {
  display: inline-block;
  text-decoration: none;
  color: #fff;
  font-size: 12px;
  background: $color;
  text-transform: uppercase;
  border: none;
  padding: 7px 16px;
  border-radius: 0px;
  -webkit-border-radius: 0px;
  -moz-border-radius: 0px;
  -o-border-radius: 0px;
  transition: all 0.2s ease-in-out;
  -moz-transition: all 0.2s ease-in-out;
  -webkit-transition: all 0.2s ease-in-out;
  -o-transition: all 0.2s ease-in-out;
}
.bottom-social-icons {
  margin-bottom: 10px;
}
.bottom-social-icons a {
  color: #fff;
  text-align: center;
  width: 42px;
  line-height: 44px;
  margin-right: 5px;
  border-radius: 50px;
  background: $color;
  display: inline-block;
  height: 42px;
  position: relative;
  overflow: hidden;
}
#copyright {
  background-color: #202020;
  border-top: 1px solid #393939;
  padding: 20px 0 10px;
  color: #fff;
}
#copyright p {
  line-height: 34px;
}
#copyright p a {
  color: #fff;
}
#copyright p a:hover {
  color: $color;
}
.social-icon .facebook:hover {
  background-color: #3b5998;
}
.social-icon .twitter:hover {
  background-color: #55acee;
}
.social-icon .dribble:hover {
  background-color: #D34836;
}
.social-icon .flickr:hover {
  background-color: #ff0084;
}
.social-icon .youtube:hover {
  background-color: #CC181E;
}
.social-icon .google-plus:hover {
  background-color: #dd4b39;
}
.social-icon .linkedin:hover {
  background-color: #007bb5;
}
footer ul li a {
  padding: 0px;
}
footer {
  padding: 0px;
}
*/
/******************* footer block********************/
#clients {
    background: #ffffff;
    padding: 40px 0px;
    border-bottom: 2px solid #235f9e;
}
#clients .bx-viewport {
    background: none;
    box-shadow: none;
    border: none;
}
.site-footer {
    color: #fff;
    -webkit-background-size: cover;
    background-size: cover;
    background-position: 50% 50%;
    background-repeat: no-repeat
}
.site-footer a {
    font-family:'Raleway', sans-serif;
    color: #cfcfcf;
    font-size: 14px;
    font-weight: 500;
    line-height: 22px;
    display: block;
}
p.about-lt {
    font-family:'Raleway', sans-serif;
    font-size: 14px;
    line-height: 24px;
    font-weight: 500;
    color:#cfcfcf;
    margin-bottom: 10px;
    letter-spacing:0.1px;
}
a.more-detail {
    color: #35385b;
    float: left;
    font-size: 13px;
    font-weight: 500;
    margin-bottom: 20px;
    text-align: right;
    text-transform: uppercase;
    width: 100%;
}
.site-footer a:hover {
    color: #235f9e
}
.site-footer p .fa {
    padding:0 .125rem
}
.site-footer ul {
    list-style: none;
    padding-left: 0;
    margin-bottom: 0
}
.site-footer ul li {
    padding:.09rem 0
}
.social-icons li {
    display: inline-block;
    margin-bottom: 0.125rem;
}
.social-icons a {
    background: transparent linear-gradient(to right, $color 50%, #ffffff 50%) repeat scroll right bottom / 207% 100%;
    border-radius: 30px;
    color: #00283b;
    display: inline-block;
    font-size: 14px;
    width: 30px;
    height: 30px;
    line-height: 30px;
    margin-right: 0.5rem;
    text-align: center;
    transition: background-color 0.2s linear 0s;
    -webkit-transition: all .6s ease 0;
    transition: all .6s ease 0;
    transition: all 0.3s ease 0s;
}
.social-icons a:hover {
    background: transparent linear-gradient(to right, $color 50%, #ffffff 50%) repeat scroll right bottom / 207% 100%;
    color: #00283b;
    background-position: left bottom;
}
.site-footer.footer-map {
    background-image: url(images/bg-map.png);
    background-color: #000;
    -webkit-background-size: contain;
    background-size: contain;
    background-position: 50% -40px
}
ul.widget-news-simple li {
    border-bottom: 1px solid rgba(255, 255, 255, 0.15);
    padding-bottom: 15px;
}
.widget-news-simple li {
    margin-bottom: 15px;
}
.widget-news-simple div {
    color: #35385b;
    font-size: 13px;
    font-weight: 600;
}
.news-thum {
    float: left;
    height: 70px;
    margin-right: 15px;
    width: 70px;
}
.news-text-thum {
    margin-top: -5px;
    padding-left: 82px;
}
.widget-news-simple h6 {
    font-size: 16px;
    font-weight: 600;
    line-height: 22px;
    margin-top: 0;
    margin-bottom: 5px;
}
.widget-news-simple h6 a {
    font-family: 'Open Sans', sans-serif;
    font-size: 15px;
    font-weight: 600;
}
.widget-news-simple p {
    font-family:'Raleway', sans-serif;
    color: #cfcfcf;
    font-size: 13px;
    font-weight: 500;
    line-height: 20px;
    margin-bottom: 5px;
    letter-spacing:0.3px;
}
.widget-news-simple div {
    font-family: 'Open Sans', sans-serif;
    color: #35385b;
    font-size: 13px;
    font-weight: 500;
}
ul.widget-news-simple .news-thum a img {
    border-radius: 4px;
}
ul.use-slt-link li:first-child{
    padding-top:0;
}
ul.use-slt-link li {
    border-bottom: 1px solid rgba(255, 255, 255, 0.15);
    padding: 8px 0;
    transition: all 0.5s ease 0s;
    -webkit-transition: all 0.5s ease 0s;
    -moz-transition: all 0.5s ease 0s;
}
.site-footer .form-alt .form-group .form-control {
    background-color: #fff;
    color: #072d40;
    border: 0 none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    line-height: 22px;
    padding: 10px;
}
.btn-quote {
    background: -webkit-linear-gradient(left, #fffff 50%, #235f9e 50%) repeat scroll right bottom/207% 100% transparent;
    background: linear-gradient(to right, #ffffff 50%, #235f9e 50%) repeat scroll right bottom/207% 100% transparent;
    border: 0 none;
    border-radius: 6px;
    color: #072d40;
    display: block;
    font-size: 15px;
    font-weight: 700;
    letter-spacing: 0;
    line-height: 24px;
    margin: 0 auto;
    padding: 8px 20px;
    text-align: center;
    -webkit-transition: background 350ms ease-in-out;
    transition: background 350ms ease-in-out;
    text-transform: uppercase;
    transition: all 0.2s linear 0s;
}
.btn-quote:hover, .btn-quote:focus, .btn-quote:active, .btn-quote:active:focus {
    background-color: #fff;
    border-color: transparent;
    background-position: left bottom;
    box-shadow: none;
    color: #072d40;
    outline: medium none !important;
}
.site-footer .form-group input {
    height: 40px;
    color: #072d40;
}
.site-footer textarea.form-control {
    box-shadow: 3px 4px 8px rgba(0, 0, 0, 0.14) inset;
}
.site-footer .form-group::-moz-placeholder {
    color: #afafaf;
}
.site-footer .form-group::placeholder {
    color: #999;
    opacity: 1;
}
.site-footer .form-group::-moz-placeholder {
    color: #999;
    opacity: 1;
}
.footer-top {
    background: rgba(30, 30, 30, 0.98);
    padding: 80px 0 70px;
}
.footer-top h2 {
    font-family:'Raleway', sans-serif;
    font-size: 18px;
    line-height: 24px;
    color: #fff;
    margin-bottom: 35px;
    font-weight: 600;
    margin-top: 12px;
    text-transform:uppercase;
    letter-spacing:0.5px;
}
.site-footer .footer-top hr {
    background: $color;
    border: 0 none;
    bottom: 0;
    height: 2px;
    left: 0;
    margin: 10px 0;
    position: relative;
    right: 0;
    text-align: left;
    top: -25px;
    width: 14%
}
.footer-top .social-icons {
    margin-top: -5px
}
.footer-bottom {
    background-color: #191919;
    font-size: 0.875rem;
    border-top: 1px solid #353535;
    padding: 30px 0;
    position: relative;
}
.footer-bottom p {
    font-weight: 200;
    line-height: 38px;
    margin-bottom: 0;
    letter-spacing:0.6px;
    text-align: center;
    font-size: 14px;
}
.scrollup {
    background: rgba(0, 0, 0, 0) url('images/top-move.png') no-repeat scroll 0 0;
    bottom: 28px;
    display: none;
    height: 40px;
    opacity: 0.9;
    outline: medium none !important;
    position: fixed;
    right: 15px;
    text-indent: -9999px;
    width: 40px;
}

/* ==========================================================================
   Categories Page style
   ========================================================================== */
.widget-title {
  position: relative;
  margin-bottom: 20px;
  padding-bottom: 10px;
  border-bottom: 1px solid #eee;
}
.widget-title:before {
  content: '';
  position: absolute;
  border-bottom: 3px solid $color;
  width: 50px;
  bottom: -1px;
  left: 0px;
}
.widget-title i {
  display: inline-block;
  margin-right: 15px;
  font-size: 16px;
  color: $color;
}
.widget-title h4 {
  font-size: 16px;
  display: inline-block;
  text-transform: uppercase;
}
.inner-box {
  border: 1px solid #eee;
  padding: 30px;
  margin-bottom: 30px;
}
.categories-list ul {
  margin: 0;
}
.categories-list ul li a {
  padding: 10px;
  margin-bottom: 5px;
  display: block;
  font-size: 13px;
  color: #444;
  border-bottom: 1px solid #eee;
}
.categories-list ul li a:hover {
  color: $color;
}
.categories-list ul li a i {
  margin-right: 5px;
}
.categories-list ul li:last-child a {
  border: none;
}
/* ==========================================================================
   Categories All Page Style
   ========================================================================== */
.all-categories .cat-title {
  font-size: 14px;
  text-transform: uppercase;
  background: #F8F8F8;
  padding: 10px 20px;
  border: 1px solid #ddd;
  margin-bottom: 20px;
}
.all-categories .cat-title span {
  color: #999;
  font-size: 12px;
}
.all-categories ul {
  margin-bottom: 20px;
}
.all-categories ul li {
  padding: 4px 20px;
  font-size: 15px;
  line-height: 26px;
}
.all-categories ul li a {
  color: #999;
}
.all-categories ul li a:hover {
  color: $color;
}
/* ==========================================================================
   Pagination
   ========================================================================== */
.pagination-bar {
  padding-bottom: 35px;
  margin-top: 35px;
}
.pagination {
  margin: 0;
}
.pagination > li > a,
.pagination .pagination > li > span {
  border: 1px solid #eee;
  border-radius: 0;
}
.pagination .active > a,
.pagination .active > a:focus,
.pagination > .active > a:hover,
.pagination > .active > span,
.pagination > .active > span:focus,
.pagination > .active > span:hover {
  background-color: $color !important;
  border-color: $color !important;
}
.pagination > li > a:focus,
.pagination > li > a:hover,
.pagination > li > span:focus,
.pagination > li > span:hover {
  background: $color;
  border-color: $color;
  color: #fff;
}
.pagination > .active > a,
.pagination > .active > a:focus,
.pagination > .active > a:hover,
.pagination > .active > span,
.pagination > .active > span:focus,
.pagination > .active > span:hover {
  box-shadow: none;
}
.post-promo {
  background: #e5e5e5;
  border: 1px solid #ddd;
  padding: 30px;
}
.post-promo h2 {
  font-size: 24px;
  font-weight: 400;
  margin-bottom: 10px;
}
.post-promo h5 {
  font-size: 14px;
  font-weight: 400;
  margin-bottom: 20px;
}
/* ==========================================================================
   About Page Style
   ========================================================================== */
#service-main .section-title {
  margin-bottom: 30px;
}
.service-item {
  text-align: center;
  padding: 30px 15px;
  transition: all 0.4s ease-in-out;
  -moz-transition: all 0.4s ease-in-out;
  -webkit-transition: all 0.4s ease-in-out;
  -o-transition: all 0.4s ease-in-out;
}
.service-item .icon-wrapper {
  font-size: 40px;
  margin-bottom: 30px;
}
.service-item .icon-wrapper i {
  display: block;
  margin: 0 auto;
  color: $color;
}
.service-item h2 {
  font-size: 16px;
  letter-spacing: 0.5px;
  text-transform: uppercase;
  font-weight: 700;
  margin-bottom: 15px;
  transition: all 0.4s ease-in-out;
  -moz-transition: all 0.4s ease-in-out;
  -webkit-transition: all 0.4s ease-in-out;
  -o-transition: all 0.4s ease-in-out;
}
.service-item:hover {
  background: #f1f1f1;
}
.about-content {
  padding: 15px 15px;
}
.about-content .desc {
  font-weight: 700;
  line-height: 26px;
  margin-top: 20px;
}
.about-content p {
  margin-bottom: 20px;
}
/* ==========================================================================
   Job Details Page Style
   ========================================================================== */
.job-detail {
  background: #F5F5F5;
}
.job-detail .medium-title {
  margin-bottom: 30px;
  font-weight: 900;
}
.job-detail .box {
  background: #fff;
  margin-bottom: 30px;
}
.job-detail .thumb {
  float: left;
  margin: 0 20px 0 0;
}
.job-detail .text-left {
  float: left;
  width: 75%;
}
.job-detail .text-left h3 {
  font-size: 24px;
  margin: 0 0 5px 0;
}
.job-detail .text-left p {
  margin: 0 0 10px 0;
}
.job-detail .text-left .meta span {
  margin-right: 20px;
  color: #999;
}
.job-detail .text-left .meta span i {
  color: $color;
  margin-right: 3px;
}
.job-detail .text-left .price {
  font-size: 18px;
  padding: 10px 0 15px 0;
  display: block;
  clear: both;
}
.job-detail .text-left .price i {
  font-size: 15px;
  margin-right: 10px;
  color: $color;
}
.job-detail .text-left .btn {
  margin-right: 20px;
}
.job-detail .clearfix {
  display: inline-block;
  width: 100%;
  padding: 30px 0 0 0;
}
.job-detail .clearfix h4 {
  margin-bottom: 10px;
}
.job-detail .clearfix p {
  color: #888;
  margin: 0 0 20px 0;
}
.job-detail .clearfix ul li {
  padding: 0 0 30px 20px;
  overflow: hidden;
  display: block;
  font-size: 14px;
  color: #666;
  position: relative;
}
.job-detail .clearfix ul li i {
  position: absolute;
  left: 0;
  top: 4px;
  margin-right: 5px;
  color: $color;
}
.job-detail .sidebar .thumb {
  width: 100%;
  *background: #000;
  position: relative;
  border-radius: 4px;
  margin-bottom: 20px;
}
.job-detail .sidebar .text-box h4 {
  margin: 0 0 12px 0;
}
.job-detail .sidebar .text-box h4 a {
  color: $color;
}
.job-detail .sidebar .text-box p {
  color: #888;
  margin: 0 0 10px 0;
}
.job-detail .sidebar .text-box a.text {
  display: block;
  color: #888;
  padding: 0 0 5px 0;
}
.job-detail .sidebar .text-box a.text i {
  margin-right: 5px;
  color: $color;
}
.job-detail .sidebar .text-box strong.price {
  color: #666;
  font-size: 15px;
  display: block;
  padding: 3px 0 15px 0;
}
.job-detail .sidebar .text-box strong.price i {
  margin-right: 5px;
  color: $color;
}
.job-detail .sidebar .sidebar-jobs ul li {
  display: block;
  overflow: hidden;
  padding: 15px 0;
  border-bottom: 1px solid #eee;
}
.job-detail .sidebar .sidebar-jobs ul li:last-child {
  border: none;
}
.job-detail .sidebar .sidebar-jobs ul li a {
  display: block;
  padding: 0 0 5px 0;
}
.job-detail .sidebar .sidebar-jobs ul li span {
  color: #888;
  display: block;
}
.job-detail .sidebar .sidebar-jobs ul li span i {
  margin-right: 5px;
  color: $color;
}
/* ==========================================================================
   Browse Jobs Page Style
   ========================================================================== */
.full-time {
  font-size: 12px;
  color: #fff;
  background: #2c3e50 !important;
  border-radius: 4px;
  margin-left: 10px;
  padding: 7px 18px;
}
.part-time {
  font-size: 12px;
  color: #fff;
  background: #7f8c8d !important;
  border-radius: 4px;
  margin-left: 10px;
  padding: 7px 18px;
}
.job-browse .pagination {
  margin-top: 30px;
}
.job-browse .cat-list li {
  padding: 7px 0;
  border-bottom: 1px solid #eee;
}
.job-browse .cat-list li a {
  text-decoration: none;
  color: #999;
  display: inline-block;
  transition: all 0.2s ease-in-out;
  -moz-transition: all 0.2s ease-in-out;
  -webkit-transition: all 0.2s ease-in-out;
  -o-transition: all 0.2s ease-in-out;
}
.job-list {
  border: 1px solid #f1f1f1;
  padding: 15px;
  display: inline-block;
  margin-bottom: 15px;
  width:100%;
}
.job-list .thumb {
  float: left;
  width: 150px;
    height: 150px;
    margin-top: 40px;
    margin-right: 20px;
}
@media(max-width:780px){
  .job-list .thumb{
  float:none;
  width: 80%;
  margin:auto;
  margin-bottom:20px;
  text-align:center;
 
}
.job-list .job-list-content{
  margin:auto!important;
  width:80%;
  margin:auto;
  text-align:center;
}
.job-list .thumb img{
  max-width40%!important;
}
}
.job-list .thumb img {
  border-radius: 4px;
}
.job-list .job-list-content {
  display: block;
  margin-left: 180px;
  position: relative;
}
.job-list .job-list-content h4 {
  font-size: 24px;
  margin-bottom: 10px;
}
.job-list .job-list-content p {
  margin-bottom: 20px;
}
.job-list .job-tag {
  border-top: 1px solid #ddd;
  padding: 15px 0;
  line-height: 35px;
}
.job-list .job-tag .meta-tag span {
  font-size: 14px;
  color: #999;
  margin-right: 10px;
}
.job-list .job-tag .meta-tag span a {
  color: #999;
}
.job-list .job-tag .meta-tag span a:hover {
  color: $color;
}
.job-list .job-tag .meta-tag span i {
  margin-right: 5px;
}
.job-list .job-tag .icon {
  float: left;
  border: 1px solid #ddd;
  width: 40px;
  height: 40px;
  line-height: 42px;
  border-radius: 50px;
  text-align: center;
  margin-right: 18px;
  background: #f1f1f1;
  color: $color;
  font-size: 16px;
}
/* ==========================================================================
   Job Alerts Pages Style
   ========================================================================== */
.right-sideabr h4 {
  font-size: 13px;
  color: #999;
}
.right-sideabr .item {
  padding: 15px 0px;
  border-bottom: 1px solid #f1f1f1;
  margin-bottom: 15px;
}
.right-sideabr .lest li {
  padding: 5px 0;
}
.right-sideabr .lest li a {
  font-size: 14px;
  font-weight: 700;
  color: #888;
}
.right-sideabr .lest li a:hover {
  color: $color;
}
.right-sideabr .lest li a.active {
  color: $color;
}
.right-sideabr .lest .notinumber {
  float: right;
  width: 24px;
  height: 24px;
  background: $color;
  text-align: center;
  border-radius: 50px;
  color: #fff;
}
.job-alerts-item {
  border: 1px solid #eee;
  padding: 30px;
}
.job-alerts-item .alerts-list {
  padding: 15px 0;
  border-bottom: 1px solid #ddd;
  text-transform: uppercase;
}
.job-alerts-item .alerts-title {
  font-size: 26px;
  margin-bottom: 30px;
}
.job-alerts-item .alerts-content {
  padding: 30px 0;
  border-bottom: 1px solid #ddd;
}
.job-alerts-item .alerts-content h3 {
  font-size: 16px;
}
.job-alerts-item .alerts-content .location {
  color: #999;
}
.job-alerts-item .alerts-content p {
  color: #999;
  margin-top: 15px;
}
.job-alerts-item .job-list {
  border: none;
  padding: 15px 0;
}
/* ==========================================================================
   My Resume Page Style
   ========================================================================== */
.my-resume .item {
  padding: 20px 0;
  border-bottom: 1px solid #eee;
}
.my-resume .item h3 {
  font-size: 20px;
  letter-spacing: 0.5px;
  margin-bottom: 15px;
}
.my-resume .item h3 i {
  margin-right: 5px;
  color: #999;
}
.my-resume .item h4 {
  font-size: 16px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-bottom: 10px;
}
.my-resume .item h5 {
  font-size: 13px;
  color: #888;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-bottom: 5px;
}
.my-resume .item .date {
  font-size: 15px;
  color: #888;
}
.my-resume .item p {
  color: #888;
}
.my-resume .item br {
  margin-bottom: 20px;
}
.my-resume .author-resume {
  display: inline-block;
  border-bottom: 1px solid #eee;
  padding-bottom: 30px;
}
.my-resume .author-resume .thumb {
  float: left;
}
.my-resume .author-resume .thumb img {
  border-radius: 4px;
}
.my-resume .author-resume .author-info {
  margin-left: 140px;
}
.my-resume .author-resume .author-info h3 {
  font-size: 16px;
  text-transform: uppercase;
}
.my-resume .author-resume .author-info p {
  line-height: 30px;
}
.my-resume .author-resume .author-info .social-link {
  margin-top: 5px;
}
.my-resume .skill {
  margin-top: 30px;
}
.my-resume .skill h3 {
  font-size: 20px;
  letter-spacing: 0.5px;
  margin-bottom: 15px;
}
.my-resume .skill h3 i {
  margin-right: 5px;
  color: #999;
}
/* Add Resume Page */
.post-header {
  padding: 10px 15px;
  background: #ddd;
  margin-bottom: 20px;
}
.post-header a {
  color: $color;
}
.add-post-btn {
  width: 100%;
  display: inline-block;
  padding: 5px 0px 25px 0px;
}
.add-post-btn .btn-added {
  font-size: 12px;
  border-radius: 50px;
  font-weight: 700;
  background: #ddd;
  padding: 5px 15px;
}
.add-post-btn .btn-delete {
  color: red;
  font-size: 12px;
  border-radius: 50px;
  font-weight: 700;
  background: #ddd;
  padding: 5px 15px;
}
/* ==========================================================================
   Manager Resumes Pages Style
   ========================================================================== */
.manager-resumes-item {
  background-color: #fff;
  border: 1px solid #ddd;
  margin-bottom: 30px;
}
.manager-resumes-item .item-body {
  padding: 20px 30px;
  color: #999;
}
.manager-resumes-item .item-body .tag-list {
  margin-top: 15px;
}
.manager-resumes-item .item-body .tag-list span {
  background-color: #f8f9fb;
  color: #818a91;
  padding: 2px 6px;
  margin-right: 8px;
  margin-bottom: 4px;
  font-size: 12px;
  border-radius: 2px;
  line-height: 20px;
  white-space: nowrap;
  display: inline-block;
}
.manager-resumes-item .manager-content {
  padding: 20px 30px;
  border-bottom: 1px solid #f1f1f1;
  display: inline-block;
  width: 100%;
}
.manager-resumes-item .manager-content .resume-thumb {
  max-width: 64px;
  width: auto;
  margin-right: 30px;
  float: left;
}
.manager-resumes-item .manager-content .manager-info .manager-name {
  float: left;
}
.manager-resumes-item .manager-content .manager-info .manager-name h4 {
  font-size: 22px;
  line-height: 35px;
}
.manager-resumes-item .manager-content .manager-info .manager-name h5 {
  font-size: 17px;
  margin-top: 6px;
  color: #999;
}
.manager-resumes-item .manager-content .manager-info .manager-meta {
  float: right;
  text-align: right;
}
.manager-resumes-item .manager-content .manager-info .manager-meta span {
  display: block;
  color: #999;
  font-size: 16px;
  line-height: 35px;
}
.manager-resumes-item .update-date {
  padding: 5px 30px;
  display: inline-block;
  width: 100%;
}
.manager-resumes-item .update-date .status {
  float: left;
}
.manager-resumes-item .update-date .action-btn {
  float: right;
}
.manager-resumes-item .btn-xs {
  height: 24px;
  border-radius: 2px;
  line-height: 24px;
  padding: 0 12px;
  font-size: 11px;
}
.manager-resumes-item .btn {
  background: #eceeef;
}
.manager-resumes-item .btn-gray {
  color: #818a91;
}
.manager-resumes-item .btn-gray:hover {
  color: $color;
}
.manager-resumes-item .btn-danger {
  background-color: #ef4d42 !important;
}
/* ==========================================================================
   Notifications Page Style
   ========================================================================== */
.notification .pagination {
  margin-top: 30px;
}
.notification-item {
  display: inline-block;
  padding: 15px 0;
  border-bottom: 1px solid #eee;
  width: 100%;
}
.notification-item .thums {
  float: left;
}
.notification-item .thums img {
  border-radius: 4px;
  width: 80px;
}
.notification-item .text-left {
  margin-left: 98px;
  padding: 15px 0;
}
.notification-item .text-left p {
  font-size: 15px;
}
.notification-item .text-left .time {
  color: #999;
}
.notification-item .text-left .time i {
  margin-right: 5px;
}
/* ==========================================================================
   Applications Page Style
   ========================================================================== */
.applications-content {
  padding: 30px 0;
  border-bottom: 1px solid #ddd;
}
.applications-content .thums {
  float: left;
  width: 60px;
  margin-right: 12px;
}
.applications-content h3 {
  font-size: 14px;
  margin-top: 10px;
}
.applications-content p {
  color: #999;
  margin-top: 15px;
}
/* ==========================================================================
   Manage Jobs Page Style
   ========================================================================== */
.candidates .can-img img {
  width: 48px;
  margin: 5px 15px;
}
/* ==========================================================================
   Policy Page Style
   ========================================================================== */
.policy {
  background: #F5F5F5;
}
.policy .post-box {
  border-radius: 4px;
  background: #fff;
  box-shadow: 0 2px 3px 0 rgba(0, 0, 0, 0.15);
  -moz-box-shadow: 0 2px 3px 0 rgba(0, 0, 0, 0.15);
  -webkit-box-shadow: 0 2px 3px 0 rgba(0, 0, 0, 0.15);
}
.policy .post-box .text-box {
  width: 100%;
  padding: 20px 23px;
}
.policy .post-box .text-box h2 {
  line-height: 26px;
  clear: both;
  margin: 0 0 18px 0;
}
.policy .post-box .text-box h4 {
  line-height: 26px;
  clear: both;
  color: #999;
  margin: 0 0 18px 0;
}
.policy .post-box .text-box p {
  color: #888;
  margin: 0 0 20px 0;
}
.policy .post-box ul {
  padding: 0 0 20px 20px;
  margin: 0;
}
.policy .post-box ul li {
  padding: 0;
  display: block;
  overflow: hidden;
  color: #888;
}
/* ==========================================================================
   Post Job Style
   ========================================================================== */
fieldset label {
  margin-bottom: 10px;
}
fieldset p {
  margin-bottom: 10px;
}
.divider {
  padding: 10px 0px 20px;
  margin-bottom: 15px;
  border-bottom: 1px solid #eee;
}
/* ==========================================================================
   Pricing Table Style
   ========================================================================== */
.mainHeading {
  text-align: center;
  margin-bottom: 20px;
}
.mainHeading .section-title {
  font-size: 24px;
  letter-spacing: 0.1em;
  padding: 20px 0px;
  text-transform: uppercase;
  font-weight: 400;
}
#pricing-table {
  background: #F0F3FA;
  text-align: center;
}
#pricing-table .title {
  padding-top: 25px;
  padding-bottom: 20px;
}
#pricing-table .title h3 {
  text-transform: uppercase;
  font-size: 18px;
  margin-bottom: 0px;
}
#pricing-table .table {
  padding-bottom: 50px;
  border-radius: 4px;
  background: #fff;
  -webkit-transition: all .3s linear;
  -moz-transition: all .3s linear;
  -ms-transition: all .3s linear;
  -o-transition: all .3s linear;
  transition: all .3s linear;
}
#pricing-table .table .pricing-header {
  position: relative;
  padding: 30px 0px;
  background: #fff;
  text-align: center;
  border-bottom: 1px solid #eee;
  border-top: 1px solid #eee;
  margin-bottom: 50px;
  -webkit-transition: all .3s linear;
  -moz-transition: all .3s linear;
  -ms-transition: all .3s linear;
  -o-transition: all .3s linear;
  transition: all .3s linear;
}
#pricing-table .table .pricing-header .price-value {
  font-size: 52px;
  color: $color;
  position: relative;
  text-align: center;
  font-weight: 700;
  line-height: 62px;
}
#pricing-table .table .pricing-header .price-value sup {
  font-size: 30px;
  position: relative;
  top: -24px;
  font-weight: 400;
}
#pricing-table .table .pricing-header .price-quality {
  font-size: 14px;
  color: #999;
}
#pricing-table .table .description {
  text-align: center;
  padding: 0px 50px;
  margin-bottom: 30px;
}
#pricing-table .table .description li {
  font-size: 14px;
  color: #999;
  padding-bottom: 8px;
  font-weight: 700;
  letter-spacing: 0.5px;
}
#pricing-table .table:hover {
  box-shadow: 0 13px 21px rgba(0, 0, 0, 0.13);
  -webkit-box-shadow: 0 13px 21px rgba(0, 0, 0, 0.13);
  -moz-box-shadow: 0 13px 21px rgba(0, 0, 0, 0.13);
}
#pricing-table .table:hover .pricing-header {
  background: $color;
}
#pricing-table .table:hover .pricing-header .price-value {
  color: #ffffff;
}
#pricing-table .table:hover .pricing-header .price-quality {
  color: #ffffff;
}
#pricing-table #active-tb {
  box-shadow: 0 13px 21px rgba(0, 0, 0, 0.13);
  -webkit-box-shadow: 0 13px 21px rgba(0, 0, 0, 0.13);
  -moz-box-shadow: 0 13px 21px rgba(0, 0, 0, 0.13);
}
#pricing-table #active-tb .pricing-header {
  background: $color;
}
#pricing-table #active-tb .pricing-header .price-value {
  color: #ffffff;
}
#pricing-table #active-tb .pricing-header .price-quality {
  color: #ffffff;
}
/* ==========================================================================
   Account Archived ADS pages style
   ========================================================================== */
.collapse-box {
  margin-bottom: 15px;
}
.collapset-title {
  border-top: 1px solid #eee;
  color: #444;
  font-size: 14px;
  font-weight: normal;
  letter-spacing: 1px;
  margin-bottom: 0px;
  margin-top: 0px;
  padding-bottom: 10px;
  padding-top: 15px;
  text-transform: uppercase;
}
.no-border {
  border: none;
}
.user-panel-sidebar ul {
  padding: 0;
}
.user-panel-sidebar ul li a {
  background: #FFF;
  display: block;
  color: #444;
  font-size: 12px;
  letter-spacing: 0.5px;
  line-height: 26px;
  padding: 5px 10px;
  text-align: left;
  border-bottom: 1px solid #eee;
}
.user-panel-sidebar ul li a:hover,
.user-panel-sidebar ul li a:active,
.user-panel-sidebar ul li.active a {
  background-color: $color;
  color: #fff;
}
.user-panel-sidebar ul li a:hover .badge,
.user-panel-sidebar ul li a:focus .badge,
.user-panel-sidebar ul li.active a .badge {
  color: #fff;
}
.user-panel-sidebar ul li:last-child a {
  border-bottom: none;
}
.collapse-box .badge {
  float: right;
  background-color: transparent;
  color: #888;
  font-size: 11px;
  line-height: 20px;
  -webkit-transition: all .3s linear;
  -moz-transition: all .3s linear;
  -ms-transition: all .3s linear;
  -o-transition: all .3s linear;
  transition: all .3s linear;
}
.table-search .control-label {
  line-height: 16px;
  padding-right: 0;
}
.searchpan input#filter {
  font-size: 12px;
  height: 30px;
}
.clear-filter {
  font-size: 11px;
}
.add-img-td img {
  width: 100%;
}
.table-action {
  display: block;
  margin-bottom: 15px;
}
table.add-manage-table > tbody > tr > td,
table.add-manage-table > tbody > tr > th {
  vertical-align: middle;
}
.table > thead > tr > th {
  border-bottom: none;
  color: $color;
}
.ads-details-td h4 {
  font-size: 15px;
  margin-bottom: 6px;
}
.ads-details-td strong {
  font-size: 13px;
  color: #444;
}
.ads-details-td sapn {
  color: #888;
}
.price-td {
  text-align: center;
  color: #888;
}
.add-img-selector {
  width: 2%;
}
.add-img-td {
  width: 20%;
}
.ads-details-td {
  width: 60%;
}
.price-td {
  width: 16%;
}
.action-td {
  width: 10%;
}
.photo-count {
  background: none repeat scroll 0 0 #ccc;
  border: 0 none;
  border-radius: 0;
  font-size: 12px;
  opacity: 0.9;
  padding: 0 3px;
  position: absolute;
  right: 4px;
  top: 5px;
}
/* ==========================================================================
   Account home page
   ========================================================================== */
.userimg {
  border: 1px solid #eee;
  display: inline-block;
  width: 75px;
  padding: 3px;
  margin-right: 5px;
}
.usearadmin h3 {
  font-size: 18px;
  text-transform: uppercase;
}
.welcome-msg {
  margin-bottom: 30px;
}
.pt {
  margin-top: 15px;
}
.back-to-top {
  display: none;
  position: fixed;
  bottom: 18px;
  right: 15px;
}
.back-to-top i {
  display: block;
  width: 36px;
  height: 36px;
  line-height: 36px;
  color: #fff;
  font-size: 14px;
  text-align: center;
  border-radius: 50px;
  background-color: $color;
  -webkit-transition: all 0.2s linear;
  -moz-transition: all 0.2s linear;
  -o-transition: all 0.2s linear;
  transition: all 0.2s linear;
}
/* ==========================================================================
   Custom Component
   ========================================================================== */
.post-title {
  font-size: 22px;
  font-weight: 700;
  margin-bottom: 15px;
}
.post-title a {
  color: #444;
}
.blog-post {
  margin-bottom: 40px;
  padding-bottom: 20px;
  border-bottom: 1px solid #eee;
}
.blog-post .post-thumb {
  position: relative;
}
.blog-post .post-thumb .hover-wrap {
  position: absolute;
  left: 0;
  top: 0;
  display: block;
  width: 100%;
  text-align: center;
  height: 100%;
  background: rgba(5, 47, 67, 0.8);
  opacity: 0;
  -webkit-transition: all 0.4s ease;
  -moz-transition: all 0.4s ease;
  transition: all 0.4s ease;
}
.blog-post .post-thumb:hover .hover-wrap {
  opacity: 1;
}
.blog-post .post-thumb:hover .link {
  margin-top: 0px;
}
.blog-post .blog-author {
  float: left;
  height: 68px;
  margin-top: 32px;
  text-align: center;
  width: 68px;
}
.blog-post .blog-author img {
  border-radius: 50%;
}
.blog-post .post-content {
  width: 100%;
  padding: 30px 92px;
}
.blog-post .post-content .meta {
  font-size: 13px;
  margin-bottom: 17px;
  padding-bottom: 11px;
  border-bottom: 1px solid #eee;
}
.blog-post .post-content .meta .meta-part {
  display: inline-block;
  margin-bottom: 10px;
  margin-right: 25px;
}
.blog-post .post-content .meta .meta-part a {
  color: #999;
}
.blog-post .post-content .meta .meta-part a:hover {
  color: $color;
}
.blog-post .post-content .meta .meta-part i {
  margin-right: 5px;
}
.blog-post .post-content p {
  margin-bottom: 30px;
}
#pagination span,
#pagination a {
  display: inline-block;
  text-align: center;
  height: 34px;
  width: 34px;
  color: #666;
  line-height: 33px;
  border: 1px solid #eee;
  border-radius: 2px;
  -webkit-border-radius: 2px;
  -moz-border-radius: 2px;
  -o-border-radius: 2px;
  transition: all 0.2s ease-in-out;
  -moz-transition: all 0.2s ease-in-out;
  -webkit-transition: all 0.2s ease-in-out;
  -o-transition: all 0.2s ease-in-out;
}
#pagination a:hover {
  border-color: #ddd;
}
#pagination .all-pages,
#pagination .next-page {
  width: auto;
  padding: 0 14px;
}
.widget-title {
  font-size: 15px;
  font-weight: 400;
  color: #333333;
  letter-spacing: 1px;
  padding: 10px 0;
  margin-bottom: 20px;
  text-transform: uppercase;
  word-spacing: 1px;
  position: relative;
}
.widget-title:before {
  content: '';
  position: absolute;
  left: 0;
  bottom: 0;
  width: 60px;
}
.right-sidebar {
  padding-left: 20px;
}
.search {
  width: 100%;
  margin-bottom: 0px !important;
  position: relative;
}
.search-btn {
  position: absolute;
  top: 76px;
  right: 25px;
  border: none;
  background: transparent;
  font-size: 18px;
}
.search-btn i {
  color: #999;
}
#sidebar {
  margin-bottom: 30px;
}
#sidebar .widget {
  border-bottom: 1px solid #E9E9E9;
  margin-bottom: 22px;
  padding-bottom: 30px;
}
#sidebar .widget:last-child {
  border-bottom: none;
}
#sidebar .cat-list li {
  padding: 7px 0;
  border-bottom: 1px solid #eee;
}
#sidebar .cat-list li a {
  text-decoration: none;
  color: #999;
  display: inline-block;
  transition: all 0.2s ease-in-out;
  -moz-transition: all 0.2s ease-in-out;
  -webkit-transition: all 0.2s ease-in-out;
  -o-transition: all 0.2s ease-in-out;
}
#sidebar .cat-list li .num-posts {
  font-size: 12px;
}
#sidebar .cat-list li:last-child {
  border: none;
}
#sidebar .posts-list li {
  margin-bottom: 12px;
  padding-bottom: 12px;
  border-bottom: 1px solid #eee;
}
#sidebar .posts-list li:last-child {
  margin: 0;
  padding: 0;
  border: none;
}
#sidebar .posts-list .widget-thumb {
  float: left;
}
#sidebar .posts-list .widget-thumb a {
  display: block;
}
#sidebar .posts-list .widget-thumb a img {
  opacity: 1;
  max-width: 90px;
  margin: 5px 15px 0 0;
  transition: all 0.2s ease-in-out;
  -moz-transition: all 0.2s ease-in-out;
  -webkit-transition: all 0.2s ease-in-out;
  -o-transition: all 0.2s ease-in-out;
}
#sidebar .posts-list .widget-thumb:hover img {
  opacity: 0.7;
}
#sidebar .posts-list .widget-content a {
  font-weight: 400;
  color: #666;
}
#sidebar .posts-list .widget-content span {
  color: #999;
  font-size: 12px;
  display: block;
  margin: 3px 0;
}
#sidebar .posts-list .widget-content span i {
  padding-right: 5px;
}
#sidebar .tag a {
  display: inline-block;
  font-size: 12px;
  color: #fff;
  padding: 7px 12px;
  background: $color;
  margin: 4px 2px;
  border-radius: 50px;
  transition: all 0.4s ease-in-out;
  -moz-transition: all 0.4s ease-in-out;
  -webkit-transition: all 0.4s ease-in-out;
  -o-transition: all 0.4s ease-in-out;
}
#sidebar .tag a:hover {
  color: #fff;
}
.single-post p {
  margin-bottom: 20px!important;
}
blockquote {
  border-left: none;
  padding: 30px;
  background: $color;
}
blockquote .quote-text {
  font-size: 20px;
  font-weight: 400;
  color: #FFF;
  line-height: 34px;
}
blockquote p {
  margin-top: 10px;
  margin-bottom: 0px !important;
}
blockquote p a {
  color: #fff;
}
blockquote p a:hover {
  color: #fff;
}
#comments h3 {
  font-size: 20px;
  font-weight: 400;
}
#comments .comments-list {
  padding: 0;
  margin: 0 0 35px 0;
}
#comments .comments-list .media {
  padding: 30px 0;
}
#comments .comments-list .media .thumb-left {
  float: left;
  width: 75px;
  height: 75px;
}
#comments .comments-list .media .thumb-left img {
  border-radius: 50px;
}
#comments .comments-list .media .info-body {
  margin-left: 90px;
  background: #f1f1f1;
  padding: 20px;
}
#comments .comments-list .media .info-body .name {
  font-size: 15px;
  font-weight: 700;
  line-height: 25px;
  margin-right: 10px;
}
#comments .comments-list .media .info-body .comment-date {
  font-weight: 600;
  color: #999;
  margin-right: 5px;
  font-size: 12px;
}
#comments .comments-list li ul {
  padding-left: 85px;
}
.reply-link {
  color: $color;
  border-radius: 0px;
  font-size: 14px;
  -webkit-transition: all 0.4s ease;
  -moz-transition: all 0.4s ease;
  -ms-transition: all 0.4s ease;
  transition: all 0.4s ease;
}
.respond-title {
  font-size: 20px;
  font-weight: 400;
  padding: 0px 0px 30px;
}
.share-social span {
  float: left;
  margin-right: 10px;
  font-size: 14px;
  color: #999;
  line-height: 31px;
  font-weight: 700;
}
.social-link a {
  color: #CACACA;
  text-align: center;
  width: 32px;
  border: 1px solid #CACACA;
  line-height: 32px;
  border-radius: 50px;
  display: inline-block;
  height: 32px;
}
.social-link .facebook:hover {
  color: #3b5998;
  border-color: #3b5998;
}
.social-link .twitter:hover {
  color: #55acee;
  border-color: #55acee;
}
.social-link .google:hover {
  color: #dd4b39;
  border-color: #dd4b39;
}
.social-link .linkedin:hover {
  color: #007bb5;
  border-color: #007bb5;
}
.head-faq {
  margin-bottom: 20px;
}
.panel-group .panel {
  margin-bottom: 24px;
}
.panel-default {
  border-radius: 0px;
  border: none;
}
.panel-default .panel-heading {
  padding: 0px 30px;
  outline: none;
  border-radius: 0px;
  background: $color !important;
  border: 1px solid $color;
  width: 100%;
  box-shadow: none;
}
.panel-default .panel-heading .panel-title {
  margin-top: 0px;
  margin-bottom: 0px;
  font-size: 16px;
  color: inherit;
}
.panel-default .panel-heading a {
  font-size: 15px;
  font-weight: 400;
  padding: 15px 35px 15px 0px;
  display: inline-block;
  width: 100%;
  color: #fff;
  position: relative;
  text-decoration: none;
}
.panel-default .panel-heading a:after {
  font-family: 'themify';
  content: '\e61a';
  position: absolute;
  right: 15px;
  color: #fff;
  font-size: 14px;
  font-weight: 300;
  top: 50%;
  line-height: 1;
  margin-top: -7px;
}
.panel-default .panel-heading .collapsed:after {
  content: '\e622';
}
.panel-default .panel-collapse .panel-body {
  padding: 15px 30px;
  background-color: #fff;
  border: 1px solid #fff;
}
/* ==========================================================================
   Contact Pages
   ========================================================================== */
.contact-form,
.information {
  margin-top: 40px;
}
.contact-datails {
  margin-bottom: 12px;
  min-height: 75px;
  position: relative;
}
.contact-datails .icon {
  position: absolute;
}
.contact-datails .icon i {
  font-size: 18px;
}
.contact-datails .info {
  padding-left: 30px;
}
.contact-datails .info h3 {
  font-size: 15px;
  display: block;
  text-transform: uppercase;
}
.contact-datails .info .datail {
  display: block;
  color: #888;
}
.form-control {
  background-color: #FFF;
  border: 1px solid #ddd;
  border-radius: 0px;
  box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.075);
  color: #444;
  display: block;
  height: 55px;
  padding: 15px 10px;
  width: 100%;
}
.form-control:focus {
  box-shadow: none;
}
/* ==========================================================================
   .form-control, .form-group .form-control{
    border: 0;
    background-image: linear-gradient(@preset, @preset,), linear-gradient(#D2D2D2, #D2D2D2);
    background-size: 0 2px, 100% 1px;
    background-repeat: no-repeat;
    background-position: center bottom, center calc(100% - 1px);
    background-color: transparent;
    transition: background 0s ease-out;
    float: none;
    box-shadow: none;
    border-radius: 0;
    font-weight: 400;
}
.form-group.is-focused .form-control {
  outline: none;
  background-image: linear-gradient(@preset, @preset), linear-gradient(#D2D2D2, #D2D2D2);
  background-size: 100% 2px, 100% 1px;
  box-shadow: none;
  transition-duration: 0.3s;
}
   ========================================================================== */
.input-icon input {
  padding-left: 40px;
}
.input-icon {
  position: relative;
}
.login-form .input-icon i,
.cd-form .input-icon i {
  color: #444;
  opacity: 0.6;
  padding-right: 10px;
  margin-top: -3px;
}
.input-icon i {
  font-size: 15px;
  left: 12px;
  line-height: 22px;
  margin-top: -11px;
  position: absolute;
  top: 50%;
}
.form-group {
  margin-bottom: 20px;
  position: relative;
}
.form-group i {
  position: absolute;
  top: 20px;
  color: #888;
  left: 12px;
  font-size: 18px;
}
.checkbox-item {
  display: inline-block;
  width: 100%;
}
.checkbox-item .checkbox {
  float: left;
  margin: 0;
}
.checkbox-item a {
  float: right;
}
/* ==========================================================================
  My Account
   ========================================================================== */
.my-account {
  background: #f5f5f5;
}
.my-account-form .cd-switcher:after {
  content: '';
  display: table;
  clear: both;
}
.my-account-form .cd-switcher li {
  width: 50%;
  float: left;
  text-align: center;
}
.my-account-form .cd-switcher li:first-child a {
  border-radius: .4px 0 0 0;
}
.my-account-form .cd-switcher li:last-child a {
  border-radius: 0 .4px 0 0;
}
.my-account-form .cd-switcher a {
  display: block;
  width: 100%;
  font-size: 16px;
  height: 50px;
  line-height: 50px;
  background: $color;
  color: #fff;
}
.my-account-form .cd-switcher a.selected {
  background: #FFF;
  color: #505260;
}
@media only screen and (min-width: 600px) {
  .my-account-form {
    margin: 4px auto;
  }
  .my-account-form .cd-switcher a {
    height: 70px;
    line-height: 70px;
  }
}
@media only screen and (max-width: 768px) {
  .formulario-registro {
    width:100%;
  }
  .job-list .thumb img{
  /*max-width:75%!important;*/
}
}
 
#cd-login,
#cd-signup,
#cd-reset-password {
  display: none;
}
#cd-login.is-selected,
#cd-signup.is-selected,
#cd-reset-password.is-selected {
  display: block;
}
.cd-user-modal-container .cd-switcher a.selected {
  background: #FFF;
  color: #666;
}
.cd-form-message {
  text-align: center;
  margin-bottom: 20px;
  color: #888;
}
.cd-form-bottom-message {
  text-align: center;
}
/* ==========================================================================
   .form-control:focus,
    textarea:focus{
    box-shadow: none;
    border: 1px solid @preset;
    outline: none;
    }
   ========================================================================== */
.has-error .form-control:focus {
  box-shadow: none;
}
.addon {
  font-size: 20px;
  color: #888;
  border-radius: 0px;
  width: 32px!important;
}
.box {
  padding: 15px;
  border: 1px solid #ddd;
  box-shadow: 3px 3px 9px rgba(0, 0, 0, 0.075);
}
.page-login-form {
  padding: 15px;
  background: #fff;
  box-shadow: 3px 3px 9px rgba(0, 0, 0, 0.075);
}
.page-login-form h3 {
  font-size: 18px;
  color: #444;
  line-height: 18px;
  padding: 15px 0 30px;
  text-transform: uppercase;
  text-align: center;
}
.page-login-form .login-form .form-control {
  background: #ffffff !important;
}
.page-login-form .log-btn {
  width: 100%;
  padding: 12px 22px;
  margin: 0px 0px 20px;
  letter-spacing: 1;
  text-transform: capitalize;
  font-size: 16px;
}
.registration .form-group {
  margin: 0;
}
.registration .form-group .lable {
  margin-bottom: 10px;
}
.registration .form-group .form-control {
  background: #ffffff !important;
}
.registration .btn {
  padding: 7px 20px;
  border: none;
}
.form-ad .checkbox label {
  margin-bottom: 0px;
}
.control-label {
  font-size: 14px;
  color: #888;
  font-weight: 700;
  margin-bottom: 10px;
}
.btn-file input[type='file'] {
  position: absolute;
  top: 0px;
  right: 0px;
  min-width: 100%;
  min-height: 100%;
  text-align: right;
  opacity: 0;
  background: transparent none repeat scroll 0px 0px;
  cursor: inherit;
  display: block;
}
.file-caption {
  height: 54px;
}
.mb15 {
  margin-bottom: 15px;
}
.form-static {
  display: inline-block;
  margin-bottom: 0px;
  vertical-align: middle;
}
.btn-group,
.btn-group-vertical {
  margin: 0;
}
.btn-select {
  padding: 12px;
  border-radius: 2px;
  color: #2d2d2d !important;
  background: #fff;
  text-transform: none;
}
.btn-group.open > .dropdown-toggle.btn,
.btn-group.open > .dropdown-toggle.btn.btn-default,
.btn-group-vertical.open > .dropdown-toggle.btn,
.btn-group-vertical.open > .dropdown-toggle.btn.btn-default {
  background: #fff;
}
.btn-group.open .dropdown-toggle {
  box-shadow: 1px 3px 5px rgba(0, 0, 0, 0.125);
}
.btn-group.open .dropdown-toggle:focus {
  outline: none;
}
.dropdown-menu > li > a {
  padding: 12px 20px;
  margin-bottom: 4px;
}
.dropdown-menu li a:hover,
.dropdown-menu li a:focus,
.dropdown-menu li a:active {
  background-color: $color;
  color: #fff;
  border-radius: 0px;
}
.btn-group.bootstrap-select.dropdown-product ul.dropdown-menu.inner {
  display: none;
}
.btn-group.bootstrap-select.dropdown-product.open ul.dropdown-menu.inner {
  display: block;
  z-index: 9999;
}
.open .dropdown-menu {
  margin-top: 0;
}
.btn-group .dropdown-menu,
.btn-group-vertical .dropdown-menu {
  border-radius: 0px;
  text-transform: none;
}
.input-group-addon {
  border: none;
  background: transparent;
}

        ";
        $response = response($contents);
        $response->header('Content-Type', 'text/css');
        return $response;
    }

    public function cssCv(){
        $sitio = Sitio::first();
        if(isset($sitio->color)){
            if($sitio->color != ""){
                $color = $sitio->color;
            }else{
                $color = "#235F9E";
            }
        }else{
            $color = "#235F9E";
        }

        $contents = "
                @import url('https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700');
                @import url(http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800);

                /* --------------------------------------
                Table Of  Content

                1) Header
                2) Logo & Navbar Section
                3) Search Section
                4) Form Overlay
                5) Inner Categories Search Box
                6) Main Banner
                7) Banner Map
                8) Search Categories
                9) Feature Listing
                10) Tags
                11) Recent Listings
                12) Vfx Counter Block
                13) Pricing Plan
                14) Listing Product
                15) Breadcrum
                16) Footer Block
                17) About Company
                18) Featured Service Block
                19) Login Forms and Register Form Style
                20) Reviews Section
                21) Contact Section
                22) Listing Section
                23) Add Listings
                24) Right Side Bar
                25) User Dashboard
                26) Error Page 

                ---------------------------------------------- */

                body {
                    font-family:'Poppins', sans-serif;
                    font-size: 15px;
                    position: relative;
                    -webkit-transition: left .5s ease-out;
                    -o-transition: left .5s ease-out;
                    transition: left .5s ease-out
                }
                img {
                    max-width: 100%;
                }
                * {
                    margin: 0px;
                    padding: 0px;
                }
                a {
                    text-decoration: none !important;
                    outline: 0;
                }
                .nopadding-right {
                    padding-right: 0px;
                }
                .nopadding-left {
                    padding-left: 0px;
                }
                .nopadding {
                    padding: 0px;
                }
                .affix-top {
                    position: static;   
                }
                .affix {
                  top: 0;
                  width: 100%;
                  z-index:999;
                }
                .affix + .container-fluid {
                  padding-top: 70px;
                }
                button {
                    outline: none;
                }
                button:hover, button:active, button:focus {
                    outline: none;
                }
                .affix {
                    position: fixed;
                    top:0px;
                }
                option {
                    padding-left: 15px;
                }
                .login_form_text_center {
                    display: table;
                    margin: 0 auto;
                    text-align: center;
                }
                .v-center {
                    -moz-box-direction: normal;
                    -moz-box-orient: vertical;
                    -moz-box-pack: center;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                }
                #location-search-list option {
                    border-bottom: 1px solid #c2c2c2;
                    padding: 7px 15px;
                    font-size: 14px;
                }
                #location-search-list option:last-child {
                    border-bottom: 0;
                }
                .fixed {
                    position: fixed;
                }
                #vfx_loader_block {
                    background: #ffffff;
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    z-index: 99999;
                }
                .vfx-loader-item {
                    margin: 0 auto;
                    position: relative;
                    top: 50%;
                    width: 100px;
                }
                /***************************** placeholder color ********************/
                .form-control::-webkit-input-placeholder {
                    color:#969595;
                }
                .form-control:-moz-placeholder { /* dispatchfox 18- */
                    color:#969595;
                }
                .form-control::-moz-placeholder {  /* dispatchfox 19+ */
                    color:#969595;
                }
                .form-control:-ms-input-placeholder {
                    color:#969595;
                }
                /*********************************** Header ********************************/
                #header {
                    background: #262626;
                    padding: 15px 0px;
                    border-bottom: 2px solid #686868;
                    line-height: 15px;
                }
                #left-header h1 {
                    font-size: 14px;
                    color: #ffffff;
                    margin: 0px;
                    font-weight: normal;
                }
                #left-header h1 a, #left-header h1 span {
                    font-weight: 500;
                    color: #ffffff;
                }
                #left-header h1 br {
                    display: none;
                }
                #left-header h1 a:hover {
                    color: #4064A0;
                }
                #right-header h1 {
                    font-size: 14px;
                    color: #ffffff;
                    margin: 0px;
                    display: inline-block;
                    margin-right: 12px;
                }
                #right-header a {
                    color: #ffffff;
                    padding-left: 18px;
                }
                #right-header a i.fa {
                    transition: all 0.2s ease 0s;
                }
                #right-header a:hover {
                    color: #4064A0;
                }
                #right-header a:hover i.fa {
                    transform: scale(1.2);
                }
                /************************** logo & navbar section **************************/
                #logo-header {
                    background: #ffffff;
                    padding: 0;
                    height: 94px;
                    line-height: 55px;
                    box-shadow: 0 1px 8px 0 rgba(0, 0, 0, 0.2);
                }
                #logo {
                    width: 100%;
                    height: auto;
                    padding: 17px 0;
                }
                #logo img {
                    max-width: 100%;
                    height: auto
                }
                #nav_menu_list {
                    padding: 0;
                }
                #nav_menu_list ul {
                    line-height: 88px;
                    margin-bottom: 0;
                }
                #nav_menu_list ul li {
                    list-style-type: none;
                    display: inline-block;
                }
                #nav_menu_list ul li a {
                    font-family:'Poppins', sans-serif;
                    color: #262626;
                    font-size: 14px;
                    text-transform: none;
                    font-weight: 500;
                    margin-bottom: 5px;
                    padding: 35px 13px 33px;
                    -webkit-transition: all 0.3s ease 0s;
                    -moz-transition: all 0.3s ease 0s;
                    -o-transition: all 0.3s ease 0s;
                    transition: all 0.3s ease 0s;
                }
                #nav_menu_list ul li a:last-child {
                    margin-right: 0
                }
                #nav_menu_list li.active {
                    border-bottom: 5px solid #4064A0;
                    color: #4064A0;
                }
                #nav_menu_list li.active a {
                    margin-bottom: 0px;
                }
                #nav_menu_list li a:hover {
                    color: #4064A0;
                    background: transparent;
                }
                #nav_menu_list li.btn_item{
                    top:12px;
                }
                #nav_menu_list li.btn_item ul li{
                    float:left;
                }
                #nav_menu_list li.btn_item ul li button.btn_login, #nav_menu_list li.btn_item ul li button.btn_register {
                    font-family:'Poppins', sans-serif;
                    background: transparent linear-gradient(to right, #262626 50%, #4064A0 50%) repeat scroll right bottom / 202% 100%;
                    border: 0 none;
                    border-radius: 20px;
                    color: #3d3d3d;
                    font-size: 14px;
                    font-weight: 600;
                    height: 34px;
                    line-height: 18px;
                    padding: 8px 15px;
                    margin-left: 5px;
                    text-transform:none;    
                    vertical-align: middle;
                    -webkit-transition: all .6s ease 0;
                    transition: all 0.3s ease 0s;       
                }
                #nav_menu_list li.btn_item ul li button.btn_login:hover, #nav_menu_list li.btn_item ul li button.btn_register:hover {
                    background-position: left bottom;
                    color: #ffffff;
                }
                .navbar {
                    border: none;
                    position: relative;
                    margin-bottom: 0px;
                    min-height: auto;
                }
                .navbar-default {
                    background-color: transparent;
                    border: none;
                }
                .navbar-collapse {
                    padding: 0px;
                }
                .navbar-toggle {
                    margin-top: 4px;
                    background: #4064A0;
                    border-color: #4064A0;
                }
                .navbar-default .navbar-toggle .icon-bar {
                    background-color: #ffffff;
                }
                .navbar-default .navbar-toggle:focus, .navbar-default .navbar-toggle:hover {
                    background-color: #4064A0;
                    border-color: #4064A0;
                }
                /************************ search section **************************/
                #search-section {
                    background: #4064A0;
                    padding: 20px 0px;
                }
                #categorie-search-form {
                    float: left;
                    width: 100%;
                }
                form#categorie-search-form h1 {
                    font-family:'Poppins', sans-serif;
                    margin-bottom: 20px;
                    font-size: 26px;
                    letter-spacing: 0.5px;
                    font-weight:500;
                    text-transform: uppercase;
                    color: #ffffff;
                }
                #search-input .form-group {
                    margin-bottom: 0px;
                }
                select#location-search-list {
                    box-shadow: 3px 4px 8px rgba(0, 0, 0, 0.14) inset;
                }
                input.form-control {
                    box-shadow: 3px 4px 8px rgba(0, 0, 0, 0.14) inset;
                }
                #search-input .form-control {
                    font-family:'Open Sans', sans-serif;
                    height: 50px;
                    border: none;
                    font-size: 15px;
                    font-weight: 500;
                }
                #search-input select, select {
                    -moz-appearance: none;
                    -webkit-appearance: none;
                    appearance: none;
                }
                #search-input select.form-control {
                    font-family:'Poppins', sans-serif;
                    font-weight:400;
                    border-radius: 30px 0 0 30px;
                    border-right: 1px solid #c2c2c2;
                    color: #6f6f6f;
                    background: #ffffff url(assets/images/slt_btn_cat.png) top 50% right 15px no-repeat;
                    padding-left: 15px;
                }
                #search-input input.form-control {
                    font-family:'Poppins', sans-serif;
                    font-weight:400;
                    border-radius: 0 30px 30px 0;
                    padding-left: 15px;
                    color: #c2c2c2;
                }
                #location-search-btn button, #btn_buscar_perfil {
                    font-family:'Poppins', sans-serif;
                    background: -webkit-linear-gradient(left, #ffffff 50%, #4064A0 50%) repeat scroll right bottom/207% 100% transparent;
                    background: linear-gradient(to right, #ffffff 50%, #4064A0 50%) repeat scroll right bottom/207% 100% transparent;
                    color: #01273a;
                    padding: 14px;
                    font-size: 15px;
                    border: none;
                    font-weight: 500;
                    text-transform: uppercase;
                    border-radius:30px;
                    -webkit-transition: background 350ms ease-in-out;
                    transition: background 350ms ease-in-out;
                    width: 100%;
                    outline: 0;
                }
                #btn_buscar_perfil{
                width: auto;
                border-radius:0;
                color:#fff;
                padding: 10.9px;
                    margin-left: -5px
                }
                #txt-buscador-cargos{
                    width: 94%; 
                }
                .busc-text {
                    padding: 20px 10px;
                    text-align: justify;
                }
                .text-b{
                    font-size: 20px;
                    padding: 10px;
                }
                #location-search-btn button i.fa {
                    margin-right: 5px;
                }
                #location-search-btn button:hover {
                    background-position: left bottom;
                    color: #262626;
                }
                /****************** form overlay *****************/
                .formOverlay:before {
                    content: '\f110';
                    font-family:'FontAwesome';
                    -webkit-animation: fa-spin 1s infinite steps(8);
                    animation: fa-spin 1s infinite steps(8);
                    color: #4064A0;
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    font-size: 56px;
                    margin-top: -25px;
                    margin-left: -25px;
                }
                .formOverlay {
                    background: transparent;
                    display: block;
                    height: 100%;
                    left: 0;
                    position: absolute;
                    top: 0;
                    width: 100%;
                    z-index: 9999;
                }
                .alert .message-icon {
                    margin-right: 10px;
                    width: 30px;
                    height: 30px;
                    text-align: center;
                    border: 1px solid #9F9F9F;
                    border-radius: 50%;
                    line-height: 30px;
                }
                #dashboard_inner_block {
                    background: #ffffff;
                    padding:80px 0;
                }
                /************************ inner categories search box **************************/
                #vfx-search-item-inner {
                    padding: 70px 0 70px 0px;
                    background: url(assets/images/inner_search_bg.png) center center no-repeat;
                    background-size: cover;
                    background-attachment: fixed;
                    background-size: 100% 100%;
                    border-bottom: 1px solid #e4e4e4;
                }
                #vfx-search-box .form-group {
                    margin-bottom: 0px;
                }
                .vfx-search-categorie-title {
                    margin-bottom: 30px;
                }
                .vfx-search-categorie-title h1 {
                    font-family:'Poppins', sans-serif;
                    margin: 0px;
                    color: #01273a;
                    text-transform: uppercase;
                    font-weight: 600;
                    font-size: 28px;
                }
                .vfx-search-categorie-title h1 span {
                    color: #4064A0;
                }
                select#location-search-list {
                    box-shadow: 3px 4px 8px rgba(0, 0, 0, 0.14) inset;
                }
                input.form-control {
                    box-shadow: 3px 4px 8px rgba(0, 0, 0, 0.14) inset;
                }
                #vfx-search-box .form-control {
                    height: 50px;
                    border: none;
                    font-size: 15px;
                }
                #vfx-search-box select, select {
                    -moz-appearance: none;
                    -webkit-appearance: none;
                    appearance: none;
                }
                #vfx-search-box select option {
                    border-bottom: 1px solid #c2c2c2;
                    font-size: 14px;
                    padding: 7px 15px;
                }
                #vfx-search-box select.form-control {
                    font-family:'Poppins', sans-serif;
                    border-top-right-radius: 0px;
                    border-bottom-right-radius: 0px;
                    border-right: 1px solid #c2c2c2;
                    color: #6f6f6f;
                    font-weight:500;
                    background: #ffffff url('assets/images/slt_btn_cat.png') top 50% right 15px no-repeat;
                    padding-left: 15px;
                    box-shadow: 0px 5px 1px rgba(0, 0, 0, 0.3);
                    border: 1px solid #b4b4b4;
                }
                #vfx-search-box input.form-control {
                    font-family:'Poppins', sans-serif;
                    border-top-left-radius: 0px;
                    border-bottom-left-radius: 0px;
                    padding-left: 15px;
                    color: #c2c2c2;
                    font-weight:500;
                    box-shadow: 0px 5px 1px rgba(0, 0, 0, 0.3);
                    border: 1px solid #b4b4b4;
                    border-left: 0px;
                }
                #vfx-search-btn button {
                    font-family:'Poppins', sans-serif;
                    background: -webkit-linear-gradient(left, #01273a 50%, #4064A0 50%) repeat scroll right bottom/207% 100% transparent;
                    background: linear-gradient(to right, #01273a 50%, #4064A0 50%) repeat scroll right bottom/207% 100% transparent;
                    color: #01273a;
                    padding: 14px;
                    font-size: 16px;
                    border: none;
                    font-weight: 500;
                    text-transform: uppercase;
                    border-radius: 4px;
                    -webkit-transition: background 350ms ease-in-out;
                    transition: background 350ms ease-in-out;
                    width: 100%;
                    outline: 0;
                    box-shadow: 0px 5px 1px rgba(0, 0, 0, 0.3);
                }
                #vfx-search-btn button i.fa {
                    margin-right: 5px;
                }
                #vfx-search-btn button:hover {
                    background-position: left bottom;
                    color: #4064A0;
                }
                /******************* main banner *****************************/
                #slider-banner-section {
                    background: url(assets/images/banner.jpg) top left no-repeat;
                    background-size: cover;
                    background-attachment: fixed;
                    border-bottom: 7px solid #4064A0;
                }
                #location_slider_item_block {
                    text-align: center;
                }
                #location_slider_item_block button {
                    background: #4064A0;
                    display: inline-block;
                    width: 80px;
                    height: 40px;
                    border: none;
                    border-radius: 50px 50px 0 0;
                    left: 0;
                    bottom: 0;
                    margin: 0 auto;
                    position: absolute;
                    right: 0;
                }
                #location_slider_item_block button i.fa {
                    color: #01273a;
                    font-size: 30px;
                    position: relative;
                    bottom: -3px;
                }
                #home-slider-item {
                    padding-top: 100px;
                }
                #home-slider-item span.helpyou_item {
                    font-family:'Open Sans', sans-serif;
                    color: #ffffff;
                    margin-bottom: 20px;
                    font-size: 36px;
                    line-height: 36px;
                    font-weight: 700;
                    display: block;
                    text-transform: uppercase;
                    letter-spacing: 2px;
                    text-align: center;
                }
                #home-slider-item span.helpyou_item span {
                    color: #4064A0;
                }
                #home-slider-item h1 {
                    font-family:'Open Sans', sans-serif;
                    font-size: 54px;
                    color: #ffffff;
                    margin: 0px;
                    font-weight: 800;
                    letter-spacing: 1.6px;
                    text-transform: uppercase;
                }
                #home-slider-item h1 span {
                    color: #4064A0;
                }
                #home-slider-item p {
                    font-family:'Poppins', sans-serif;
                    font-size: 26px;
                    color: #ffffff;
                    margin: 20px 0px 0px;
                    letter-spacing: 0.5px;
                    text-transform: uppercase;
                    line-height: 30px;
                    font-weight: 500;
                }
                #search-categorie-item-block {
                    margin: 68px 0px 124px;
                    float: left;
                    width: 100%;
                }
                #search-categorie-item-block h1 {
                    font-size: 28px;
                    font-weight: 700;
                    color: #4064A0;
                    margin: 0px;
                    text-transform: uppercase;
                }
                /********************** banner map **********************/
                #location-map-block {
                    border-bottom: 7px solid #4064A0;
                    width: 100%;
                }
                #location-link-item {
                    text-align: center;
                }
                #location-link-item button {
                    position: absolute;
                    left: 0;
                    right: 0;
                    border: none;
                    text-align: center;
                    margin: 0 auto;
                    background: #4064A0;
                    width: 80px;
                    height: 40px;
                    bottom: 0;
                    border-radius: 50px 50px 0px 0px;
                }
                #location-link-item button i.fa {
                    color: #01273a;
                    font-size: 30px;
                    position: relative;
                    top: 2px;
                }
                #map, #location-homemap-block, #locationmap, #contactmap {
                    width: 100%;
                    height: 557px;
                    top: -1px;
                    margin-bottom: -2px;
                    display: inline-block;
                    float: left
                }
                /***************************** search categories *********************/
                #search-categorie-item {
                    background: #FAFAFA url(assets/images/category_bg.png) no-repeat center top;
                    background-position: cover;
                    background-attachment: fixed;
                    background-size: 100% 100%;
                    padding: 80px 0px 60px 0;
                }
                #search-categories-section {
                    padding: 10px 0px 60px;
                    background: #f7f7f7;
                    border-bottom: 2px solid #4064A0;
                }
                #search-categories-section .categories-list {
                    background: #ffffff;
                }
                .categories-heading {
                    margin-bottom: 50px;
                }
                .categories-heading h1 {
                    font-family:'Poppins', sans-serif;
                    margin: 0px;
                    color: #01273a;
                    text-transform: uppercase;
                    font-weight: 600;
                    font-size: 28px;
                }
                .categories-heading h1 span {
                    color: #4064A0;
                }
                .categorie_item {
                    background: #ffffff;
                    border-radius: 6px;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
                    padding: 20px;
                    margin-bottom: 30px;
                }
                .categorie_item:hover {
                    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.3);
                    -webkit-transform: scale(1.05);
                    transform: scale(1.05);
                    -webkit-transition: ease-out .5s;
                    -moz-transition: ease-out .5s;
                    -o-transition: ease-out .5s;
                    transition: ease-out .5s;
                    transition: all .6s ease-in-out 0;
                }
                .cate_item_block {
                    background: #fcfbfb;
                    border:1px solid rgba(0, 0, 0, 0.10);
                    border-radius: 6px;
                    text-align: center;
                    padding: 30px 0;
                }
                .cate_item_social {
                    background: #4064A0;
                    border-radius: 50px;
                    color: #ffffff;
                    height: 90px;
                    margin: 0 auto;
                    text-align: center;
                    vertical-align: middle;
                    width:90px;
                }
                .cate_item_social i {
                    display: block;
                    font-size: 40px;
                    line-height: 90px;
                    text-align: center;
                }
                .cate_item_social img {
                    border-radius:0px;
                    display: inline-block;
                    height: 97px;
                    max-width: 100%;
                    padding: 15px;
                    text-align: center;
                }
                .cate_item_block h1 {
                    color:#4a4a4a;
                    margin-bottom: 0px;
                    font-size: 18px;
                    font-weight:600;
                    text-transform: uppercase;
                }
                .cate_item_block h1 a {
                    font-family:'Poppins', sans-serif;
                    color: #4a4a4a;
                    font-weight:500;
                }
                .cate_item_block:hover {
                    background: #4064A0;
                    color: #01273a;
                }
                .categorie_item:hover .cate_item_social i {
                    background: transparent;
                    color: #4064A0;
                    border-radius: 50px;
                    border:1px solid rgba(0, 0, 0, 0.12);
                    width: 90px;
                    height: 90px;
                    line-height: 90px;
                    -webkit-transition: ease-out .5s;
                    -moz-transition: ease-out .5s;
                    -o-transition: ease-out .5s;
                    transition: ease-out .5s;
                    /*transform: rotate(360deg);*/
                    transition: all .6s ease-in-out 0;  
                }
                .hi-icon {
                    color:#ffffff;
                    display: block;
                    position: relative;
                    text-align: center;
                    z-index: 1
                }
                .hi-icon::after {
                    border-radius: 50%;
                    box-sizing: content-box;
                    content: '';
                    height: 100%;
                    pointer-events: none;
                    position: absolute;
                    width: 100%
                }
                .categorie_item:hover .hi-icon-effect-8 .hi-icon {
                    background: #fff;
                    color: #4064A0;
                    cursor: pointer
                }
                .hi-icon-effect-8 .hi-icon::after {
                    box-shadow: 0 0 0 2px rgba(255,255,255,0.1);
                    left: 0;
                    opacity: 0;
                    padding: 0;
                    top: 0;
                    transform: scale(0.9);
                    z-index: -1
                }
                .no-touch .hi-icon-effect-8 .hi-icon:hover {
                    background: rgba(255,255,255,0.05) none repeat scroll 0 0;
                    color: #fff;
                    transform: scale(0.93)
                }
                .categorie_item:hover .hi-icon-effect-8 .hi-icon::after {
                    animation: 1.3s ease-out 75ms normal none 1 running sonarEffect
                }
                @keyframes sonarEffect {
                 0% {
                opacity:.3
                }
                 40% {
                box-shadow:0 0 0 2px rgba(255,255,255,0.1), 0 0 7px 7px #9a9a9a, 0 0 0 7px rgba(255,255,255,0.1);
                opacity:.5
                }
                 100% {
                box-shadow:0 0 0 2px rgba(255,255,255,0.1), 0 0 7px 7px #9a9a9a, 0 0 0 7px rgba(255,255,255,0.1);
                opacity:0;
                transform:scale(1.5)
                }
                 0% {
                opacity:.3
                }
                 40% {
                box-shadow:0 0 0 2px rgba(255,255,255,0.1), 0 0 7px 7px #9a9a9a, 0 0 0 7px rgba(255,255,255,0.1);
                opacity:.5
                }
                 100% {
                box-shadow:0 0 0 2px rgba(255,255,255,0.1), 0 0 7px 7px #9a9a9a, 0 0 0 7px rgba(255,255,255,0.1);
                opacity:0;
                transform:scale(1.5)
                }
                }
                .bt_heading_3 .line_1 {
                    background-color: #6d6d6d;
                    display: inline-block;
                    height: 1px;
                    vertical-align: middle;
                    width: 60px;
                }
                .bt_heading_3 .icon {
                    color: #f9ca40;
                    display: inline-block;
                    font-size: 7px;
                    line-height: 4px;
                    margin: 0 3px;
                    vertical-align: middle;
                }
                .bt_heading_3 .line_2 {
                    background-color: #6d6d6d;
                    display: inline-block;
                    height: 1px;
                    vertical-align: middle;
                    width: 60px;
                }
                #search-categories-boxes, .search-categories-box {
                    padding-top: 50px;
                    display: inline-block;
                    width: 100%;
                }
                #search-categories-section #search-categories-boxes, #search-categories-section .search-categories-box {
                    padding-top: 50px;
                    display: inline-block;
                    width: 100%;
                }
                .all-categorie-list-title {
                    margin-bottom: 50px;
                }
                .all-categorie-list-title h1 {
                    font-family:'Poppins', sans-serif;
                    margin: 0px;
                    color: #01273a;
                    text-transform: uppercase;
                    font-weight: 600;
                    font-size: 28px;
                }
                .all-categorie-list-title h1 span {
                    color: #4064A0;
                }
                .search-categories-boxes {
                    width: 100%;
                    display: inline-block;
                }
                .search-categories-boxes h2 {
                    font-family:'Poppins', sans-serif;
                    margin: 0px;
                    padding: 10px 15px;
                    background: #14418b;
                    font-size: 15px;
                    text-align: left;   
                    color: #fff;
                    font-weight: 600;
                    position:relative;
                    padding-left:45px;
                    text-transform: uppercase;
                    height: 42px;
                    line-height: 22px;
                }
                .search-categories-boxes h2 i {
                    margin-right: 5px;
                    background: #fff;
                    padding: 0;
                    width: 30px;
                    height: 30px;
                    position: absolute;
                    left: 7px;
                    top: 6px;
                    text-align: center;
                    vertical-align: middle;
                    line-height: 30px;
                    border-radius: 30px;
                }
                #all-categorie-item-block {
                    background: #ffffff;
                    padding: 80px 0 60px 0;
                }
                .categories-list {
                    padding: 0px;
                    border: 1px solid #eeeeee;
                    border-top: none;   
                }
                .categorie-list-box {
                    box-shadow: 0 0px 15px rgba(0, 0, 0, 0.1);
                    margin-bottom: 30px;
                    border-radius: 4px;
                }
                .categories-list ul {
                    margin-bottom: 0px;
                }
                .categories-list ul li {
                    text-align: left;
                    list-style: none;
                    color: #636363;
                    font-size: 14px;
                    line-height: 35px;
                    padding: 2px 15px;
                    border-bottom: 1px solid #eeeeee;
                    text-transform: capitalize;
                    transition: all 0.5s ease 0s;
                    -webkit-transition: all 0.5s ease 0s;
                    -moz-transition: all 0.5s ease 0s;
                }
                .categories-list ul li:last-child {
                    border-bottom: 0px;
                }
                .categories-list ul li a {
                    font-family:'Poppins', sans-serif;
                    color: #696969;
                    font-size: 13px;
                    font-weight: 500;
                }
                .categories-list ul li:hover {
                    padding-left: 20px;
                    transition: all 0.3s ease 0s;
                    -webkit-transition: all 0.3s ease 0s;
                    -moz-transition: all 0.3s ease 0s;
                }
                .categories-list ul li:hover a {
                    color: #4064A0;
                }
                .categories-list ul li a i {
                    margin-right: 5px;
                }
                .categories-list ul li span {
                    font-family:'Poppins', sans-serif;
                    color: #898989;
                    font-weight:500;
                    font-size:13px;
                    float: right;
                }
                #categorie-item-search {
                    padding-top: 30px;
                    display: inline-block;
                    width: 100%;
                }
                .categorie-item-search {
                    display: inline-block;
                    width: 100%;
                }
                .categorie-item-search h2 {
                    margin: 0px;
                    padding: 10px 15px;
                    background: #4064A0;
                    font-size: 16px;
                    text-align: left;
                    border-top-left-radius: 4px;
                    border-top-right-radius: 4px;
                    color: #ffffff;
                    text-transform: capitalize;
                    height: 42px;
                }
                .categorie-item-search h2 img {
                    margin-right: 5px;
                }
                .categories-list1 {
                    padding: 15px;
                    border: 1px solid #e8e8e8;
                    border-top: none;
                    border-bottom-left-radius: 4px;
                    border-bottom-right-radius: 4px;
                }
                .categories-list1 ul {
                    margin-bottom: 0px;
                }
                .categories-list1 ul li {
                    text-align: left;
                    list-style: none;
                    color: #636363;
                    font-size: 14px;
                    line-height: 35px;
                    text-transform: capitalize;
                    transition: all 0.3s ease 0s;
                    -webkit-transition: all 0.3s ease 0s;
                    -moz-transition: all 0.3s ease 0s;
                }
                .categories-list1 ul li a {
                    color: #636363;
                }
                .categories-list1 ul li:hover {
                    padding-left: 3px;
                }
                .categories-list1 ul li:hover a {
                    color: #4064A0;
                }
                .categories-list1 ul li::before {
                    content: 'ï”';
                    font-family:'FontAwesome';
                    font-size: 10px;
                    margin-right: 10px;
                    color: #4064A0;
                }
                .categories-list1 ul li span {
                    float: right;
                }
                #search-categorie-item button {
                    background: -webkit-linear-gradient(left, #262626 50%, #4064A0 50%) repeat scroll right bottom/207% 100% transparent;
                    background: linear-gradient(to right, #262626 50%, #4064A0 50%) repeat scroll right bottom/207% 100% transparent;
                    border: none;
                    padding: 10px 30px;
                    border-radius: 4px;
                    color: #ffffff;
                    margin-top: 60px;
                    font-size: 16px;
                    -webkit-transition: all 0.3s ease 0s;
                    -moz-transition: all 0.3s ease 0s;
                    -o-transition: all 0.3s ease 0s;
                    transition: all 0.3s ease 0s;
                    width: 100%;
                    outline: 0;
                }
                #search-categorie-item button:hover {
                    background-position: left bottom;
                }
                #search-categorie-item button i.fa {
                    margin-right: 5px;
                }
                /************************* feature listing ************************/
                .feature-item-listing-heading {
                    margin-bottom: 50px;
                }
                .feature-item-listing-heading h1 {
                    font-family:'Poppins', sans-serif;
                    margin: 0px;
                    color: #01273a;
                    text-transform: uppercase;
                    font-weight: 600;
                    font-size: 28px;
                }
                .feature-item-listing-heading h1 span {
                    color: #4064A0;
                }
                #feature-item_listing_block {
                    background: #ffffff;
                    padding: 80px 0px 60px 0;
                }
                #feature-item-listing-heading h1 {
                    margin: 0px;
                    color: #242424;
                    text-transform: uppercase;
                    font-weight: 700;
                    font-size: 28px;
                }
                #feature-item-listing-heading h1 span {
                    padding: 0px 30px;
                }
                #feature-item-listing-heading h1 span::after {
                    border-right: 3px solid #4064A0;
                    content: '';
                    height: 30px;
                    margin-left: 20px;
                    width: 3px;
                    position: relative;
                    top: 5px;
                }
                #feature-item-listing-heading h1 span::before {
                    border-left: 3px solid #4064A0;
                    bottom: 5px;
                    content: '';
                    height: 30px;
                    margin-right: 20px;
                    position: relative;
                    width: 3px;
                }
                .feature-box {
                    padding-top: 60px;
                    width: 100%;
                    position: relative;
                    display: inline-block;
                }
                #feature-box1, .feature-box1 {
                    padding-top: 50px;
                    width: 100%;
                    position: relative;
                    display: inline-block;
                }
                .feature-item-container-box {
                    border: 1px solid #efeeee;
                    -webkit-transition: all 0.3s ease 0s;
                    -moz-transition: all 0.3s ease 0s;
                    -o-transition: all 0.3s ease 0s;
                    transition: all 0.3s ease 0s;
                    -ms-transition: all 0.3s ease 0s;
                    width: 100%;
                    overflow: hidden;
                    position: relative;
                    margin-bottom: 30px;
                }
                .feature-item-container-box .feature-title-item h1 {
                    font-family:'Poppins', sans-serif;
                    background: rgba(1, 39, 58, 0.8);
                    color: #4064A0;
                    font-size: 13px;
                    font-weight: 600;
                    text-transform: uppercase;
                    padding: 8px 15px;
                    position: absolute;
                    left: 0px;
                    top: 0px;
                    margin: 0;
                    border-radius:0 15px 15px 0px;
                    -webkit-transition: all 0.3s ease 0s;
                    -moz-transition: all 0.3s ease 0s;
                    -o-transition: all 0.3s ease 0s;
                    transition: all 0.3s ease 0s;
                    -ms-transition: all 0.3s ease 0s;
                }
                .feature-item-listing-item {
                    border: 1px solid #efeeee;
                    -webkit-transition: all 0.3s ease 0s;
                    -moz-transition: all 0.3s ease 0s;
                    -o-transition: all 0.3s ease 0s;
                    transition: all 0.3s ease 0s;
                    -ms-transition: all 0.3s ease 0s;
                    overflow: hidden;
                    position: relative;
                    margin-bottom: 0px;
                }
                .feature-item-listing-item .feature-title-item h1 {
                    background: rgba(1, 39, 58, 0.8);
                    color: #4064A0;
                    font-size: 15px;
                    font-weight: 700;
                    text-transform: uppercase;
                    padding: 8px 15px;
                    position: absolute;
                    left: 1px;
                    top: 1px;
                    margin: 0;
                    -webkit-transition: all 0.3s ease 0s;
                    -moz-transition: all 0.3s ease 0s;
                    -o-transition: all 0.3s ease 0s;
                    transition: all 0.3s ease 0s;
                    -ms-transition: all 0.3s ease 0s;
                }
                .feature-title-item {
                    background: rgba(0, 0, 0, 0) linear-gradient(to right, rgba(0, 0, 0, 0.3) -10%, rgba(0, 0, 0, 0.5) 20%, rgba(0, 0, 0, 0.5) 40%, transparent 80%) repeat scroll 0 0
                }
                .feature-title-item img {
                    width: 100%;
                    height: 200px;
                }
                .feature-item-container-box:hover {
                    border: 1px solid #4064A0;
                    box-shadow: 0 1px 15px rgba(0, 0, 0, 0.2);
                }
                .feature-item-container-box.active {
                    border: 1px solid #4064A0;
                    box-shadow: 0 1px 15px rgba(0, 0, 0, 0.2);
                }
                .feature-item-container-box:hover .feature-title-item img {
                    transform: scale(1.2);
                    transition: all 0.4s ease 0s;
                }
                .feature-item-container-box.active .feature-box-text a h3 {
                    color: #4064A0;
                }
                .feature-item-container-box .feature-box-text {
                    background: #fefefe;
                    padding:15px;
                    text-align: left;
                    position:relative;
                }
                .feature-item-container-box .feature-item-location {
                    background: #f4f4f4;
                    padding: 5px 15px;
                    float: left;
                    display: block;
                    width: 100%;
                    position: relative;
                }
                .feature-item-container-box .feature-item-location h2 {
                    font-family:'Poppins', sans-serif;
                    font-size: 13px;
                    color: #7d7d7d;
                    font-weight: 500;
                    margin: 0px;
                    text-align: left;
                    line-height: 30px;
                    float: left;
                }
                .feature-item-container-box .feature-item-location h2 i {
                    color: #ffcc58;
                    font-size:14px;
                    margin-right: 3px;
                }
                .feature-item-container-box .feature-item-location span {
                    float: right;
                    font-size: 13px;
                    position: relative;
                    top: 7px;
                }
                .feature-item-container-box .feature-item-location span i.fa {
                    color: #ffcc58;
                }
                .feature-box-text i.fa-star-half-empty {
                    margin-right: 5px;
                }
                .feature-item-container-box .feature-box-text h3 {  
                    margin-top: 0;
                    line-height:18px;
                    margin-bottom:10px;
                }
                .feature-item-container-box .feature-box-text h3 a{
                    font-family:'Poppins', sans-serif;
                    color: #4a4a4a;
                    font-weight: 500;
                    font-size: 18px;
                    margin-top: 0;  
                }
                .feature-item-container-box .feature-box-text h3 a:hover{
                    color: #4064A0; 
                }
                .feature-item-container-box .feature-box-text p {
                    color: #7d7d7d;
                    font-size: 13px;
                    line-height: 22px;
                    font-weight:500;
                    margin-top: 10px;
                    margin-bottom: 0;   
                }
                .feature-item-container-box .feature-box-text a {
                    font-family:'Poppins', sans-serif;
                    color: #4064A0;
                    font-size: 13px;
                    font-weight:400;
                    letter-spacing:0.2px;
                }
                .feature-item-container-box.active .feature-box-text a, .feature-item-container-box.active .feature-box-text a i {
                    color: #969595;
                }
                .feature-item-container-box .feature-box-text a i.fa {
                    color: #4064A0;
                    margin-right: 3px;
                }
                .feature-title-item {
                    position: relative;
                }
                .hover-overlay {
                    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
                    height: 48%;
                    left: 0px;
                    position: absolute;
                    right: 0px;
                    top: 0px;
                    width: auto;
                    bottom: 0px;
                }
                .feature-item-container-box:hover .hover-overlay {
                    background: rgba(0, 0, 0, 0.7) none repeat scroll 0 0;
                }
                .hover-overlay-inner {
                    height: 100%;
                    text-align: center;
                    vertical-align: middle;
                }
                .feature-item-container-box:hover .hover-overlay-inner::before, .feature-item-container-box:hover .hover-overlay-inner::after {
                    bottom: 10px;
                    content: '';
                    left: 10px;
                    opacity: 0;
                    position: absolute;
                    right: 10px;
                    top: 10px;
                    transition: opacity 0.35s ease 0s, transform 0.35s ease 0s;
                }
                .feature-item-container-box:hover .hover-overlay-inner::before {
                    border-bottom: 1px solid #ebc131;
                    border-top: 1px solid #ebc131;
                    transform: scale(0, 1);
                }
                .feature-item-container-box:hover .hover-overlay-inner::after {
                    border-left: 1px solid #ebc131;
                    border-right: 1px solid #ebc131;
                    transform: scale(1, 0);
                }
                .feature-item-container-box:hover .hover-overlay-inner::before, .feature-item-container-box:hover .hover-overlay-inner::after, .location-entry:hover .hover-overlay-inner::before, .location-entry:hover .hover-overlay-inner::after, .feature-item:hover .hover-overlay-inner::before, .feature-item:hover .hover-overlay-inner::after, .listing-item:hover .hover-overlay-inner::before, .listing-item:hover .hover-overlay-inner::after {
                    opacity: 1;
                    transform: scale(1);
                }
                .feature-item-container-box:hover .hover-overlay .hover-overlay-inner ul.listing-links {
                    display: block;
                    z-index: 900
                }
                .hover-overlay .hover-overlay-inner h3 a {
                    display: none;
                }
                .feature-item-container-box:hover .hover-overlay .hover-overlay-inner h3 {
                    display: list-item
                }
                .feature-item-container-box:hover .hover-overlay .hover-overlay-inner h3 a {
                    color: #4064A0;
                    display: block;
                    font-size: 16px;
                    font-weight: 600;
                    margin-left: 20px;
                    text-align: left;
                    position: absolute;
                    z-index: 99;
                }
                .feature-item-container-box:hover .hover-overlay .hover-overlay-inner h3 a:hover {
                    color: #ffffff;
                    text-decoration: underline;
                }
                .hover-overlay .hover-overlay-inner ul.listing-links {
                    position: absolute;
                    top: 50%;
                    transform: translateY(-50%);
                    display: block;
                    height: auto;
                    margin: 0 auto;
                    text-align: center;
                    right: 0;
                    left: 0;
                    display: none;
                }
                .hover-overlay .hover-overlay-inner ul.listing-links li:first-child {
                    margin-left: 0;
                }
                .hover-overlay .hover-overlay-inner ul.listing-links li {
                    display: inline-block;
                    margin-left: 5px;
                }
                .hover-overlay .hover-overlay-inner ul.listing-links li a {
                    background: #ffffff;
                    border-radius: 50%;
                    font-size: 18px;
                    height: 44px;
                    line-height: 44px;
                    width: 44px;
                    float: left;
                }
                .hover-overlay .hover-overlay-inner ul.listing-links li a:hover {
                    -webkit-transform: scale(1.1);
                    transform: scale(1.1);
                    -webkit-transition: ease-out .5s;
                    -moz-transition: ease-out .5s;
                    -o-transition: ease-out .5s;
                    transition: ease-out .5s;
                    transition: all .6s ease-in-out 0;
                    box-shadow: 0 3px 8px rgba(255, 255, 255, 0.3)
                }
                .green-1 {
                    color: #ccdb38;
                }
                .blue-1 {
                    color: #08c2f3;
                }
                .yallow-1 {
                    color: #fecc17;
                }
                .feature-item-listing-item:hover .recent-listing-box-image img {
                    /*transform: scale(1.2);
                    transition: all 0.4s ease 0s;*/
                }
                .feature-item-listing-item:hover .hover-overlay {
                    background: rgba(0, 0, 0, 0.7) none repeat scroll 0 0;
                }
                .feature-item-listing-item .hover-overlay {
                    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
                    height: 100%;
                    left: 0px;
                    position: absolute;
                    right: 0px;
                    top: 0px;
                    width: auto;
                    bottom: 0px;
                }
                .feature-item-listing-item:hover .hover-overlay-inner::before, .feature-item-listing-item:hover .hover-overlay-inner::after {
                    bottom: 10px;
                    content: '';
                    left: 10px;
                    opacity: 0;
                    position: absolute;
                    right: 10px;
                    top: 10px;
                    transition: opacity 0.35s ease 0s, transform 0.35s ease 0s;
                }
                .feature-item-listing-item:hover .hover-overlay-inner::before {
                    border-bottom: 1px solid #ebc131;
                    border-top: 1px solid #ebc131;
                    transform: scale(0, 1);
                }
                .feature-item-listing-item:hover .hover-overlay-inner::after {
                    border-left: 1px solid #ebc131;
                    border-right: 1px solid #ebc131;
                    transform: scale(1, 0);
                }
                .feature-item-listing-item:hover .hover-overlay-inner::before, .feature-item-listing-item:hover .hover-overlay-inner::after, .location-entry:hover .hover-overlay-inner::before, .location-entry:hover .hover-overlay-inner::after, .feature-item:hover .hover-overlay-inner::before, .feature-item:hover .hover-overlay-inner::after, .listing-item:hover .hover-overlay-inner::before, .listing-item:hover .hover-overlay-inner::after {
                    opacity: 1;
                    transform: scale(1);
                }
                .feature-item-listing-item:hover .hover-overlay .hover-overlay-inner ul.listing-links {
                    display: block;
                    z-index: 999
                }
                .feature-item-listing-item:hover .hover-overlay .hover-overlay-inner h3 {
                    display: list-item
                }
                .feature-item-listing-item:hover .hover-overlay .hover-overlay-inner h3 a {
                    color: #4064A0;
                    display: block;
                    font-size: 17px;
                    font-weight: 700;
                    margin-left: 20px;
                    text-align: left;
                    position: absolute;
                    z-index: 99;
                }
                .feature-item-listing-item:hover .hover-overlay .hover-overlay-inner h3 a:hover {
                    color: #ffffff;
                    text-decoration: underline;
                }
                /************************ recent listings ********************************/
                #recent-product-item-listing {
                    padding: 80px 0px 60px 0;
                    background: #ffffff;
                }
                .recent-item-listing-heading {
                    margin-bottom: 50px;
                }
                .recent-item-listing-heading h1 {
                    font-family:'Poppins', sans-serif;
                    margin: 0px;
                    color: #01273a;
                    text-transform: uppercase;
                    font-weight: 600;
                    font-size: 28px;
                }
                .recent-item-listing-heading h1 span {
                    color: #4064A0;
                }
                .listing-boxes {
                    padding-top: 50px;
                    display: inline-block;
                    width: 100%;
                }
                .listing-boxes1 {
                    padding-top: 30px;
                }
                .recent-listing-box-container-item {
                    display: block;
                    margin-bottom: 30px;
                    width: 100%;
                    border: 1px solid #efeeee;
                    -webkit-transition: all 0.3s ease 0s;
                    -moz-transition: all 0.3s ease 0s;
                    -o-transition: all 0.3s ease 0s;
                    transition: all 0.3s ease 0s;
                    -ms-transition: all 0.3s ease 0s;
                    overflow: hidden;
                    position: relative;
                }
                .recent-listing-box-container-item:hover {
                    border: 1px solid #4064A0;
                    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
                }
                .recent-listing-box-container-item:hover h1 span {
                    margin-bottom: 0px;
                }
                .listings-boxes-container:hover .listing-boxes-text {
                    border: 1px solid transparent;
                    border-top: none;
                }
                .recent-listing-box-container-item:hover .recent-listing-box-image img {
                    /*transform: scale(1.2);
                    transition: all 0.4s ease 0s;*/
                }
                .recent-listing-box-container-item:hover .hover-overlay {
                    background: rgba(0, 0, 0, 0.7) none repeat scroll 0 0;
                }
                .recent-listing-box-container-item .hover-overlay {
                    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
                    height: 100%;
                    left: 0px;
                    position: absolute;
                    right: 0px;
                    top: 0px;
                    width: auto;
                    bottom: 0px;
                }
                .recent-listing-box-container-item:hover .hover-overlay-inner::before, .recent-listing-box-container-item:hover .hover-overlay-inner::after {
                    bottom: 10px;
                    content: '';
                    left: 10px;
                    opacity: 0;
                    position: absolute;
                    right: 10px;
                    top: 10px;
                    transition: opacity 0.35s ease 0s, transform 0.35s ease 0s;
                }
                .recent-listing-box-container-item:hover .hover-overlay-inner::before {
                    border-bottom: 1px solid #ebc131;
                    border-top: 1px solid #ebc131;
                    border-left:1px solid #ebc131;
                    border-right:1px solid #ebc131;
                }   
                .recent-listing-box-container-item:hover .hover-overlay-inner::after {
                    border-left: 1px solid #ebc131;
                    border-right: 1px solid #ebc131;
                    transform: scale(1, 0);
                }
                .recent-listing-box-container-item:hover .hover-overlay-inner::before, .recent-listing-box-container-item:hover .hover-overlay-inner::after, .location-entry:hover .hover-overlay-inner::before, .location-entry:hover .hover-overlay-inner::after, .feature-item:hover .hover-overlay-inner::before, .feature-item:hover .hover-overlay-inner::after, .listing-item:hover .hover-overlay-inner::before, .listing-item:hover .hover-overlay-inner::after {
                    opacity: 1;
                    -webkit-transition: ease-out 1.0s;
                    -moz-transition: ease-out 1.0s;
                    -o-transition: ease-out 1.0s;
                    transition: ease-out 1.0s;
                    transition: all 1.0s ease-in-out 0;
                }
                .recent-listing-box-container-item:hover .hover-overlay .hover-overlay-inner ul.listing-links {
                    display: block;
                    z-index: 900;
                }
                .recent-listing-box-container-item:hover .hover-overlay .hover-overlay-inner h3 {
                    display: list-item
                }
                .recent-listing-box-container-item:hover .hover-overlay .hover-overlay-inner h3 a {
                    color: #4064A0;
                    display: block;
                    font-size: 17px;
                    font-weight: 700;
                    margin-left: 20px;
                    text-align: left;
                    position: absolute;
                    z-index: 99;
                }
                .recent-listing-box-container-item:hover .listing-boxes-text a h3 {
                    color: #01273a;
                    text-decoration: none;
                }
                .recent-listing-box-image img {
                    /*height: 214px;
                    max-width: 100%;
                    width: 100%;*/
                }
                .recent-listing-box-image > h1 {
                    font-size: 14px;
                    position: relative;
                    text-transform: capitalize;
                    margin: 0px;
                    color: #636363;
                    -webkit-transition: all 0.3s ease 0s;
                    -moz-transition: all 0.3s ease 0s;
                    -o-transition: all 0.3s ease 0s;
                    transition: all 0.3s ease 0s;
                    -ms-transition: all 0.3s ease 0s;
                }
                .recent-listing-box-image h1 {
                    font-family:'Poppins', sans-serif;
                    background: rgba(1, 39, 58, 0.8) none repeat scroll 0 0;
                    color: #4064A0;
                    font-size: 13px;
                    font-weight: 600;
                    left: 0px;
                    margin: 0;
                    padding: 8px 15px;
                    border-radius:0 15px 15px 0px;
                    position: absolute;
                    text-transform: uppercase;
                    top: 0px;
                    transition: all 0.3s ease 0s;
                }
                .recent-listing-box-item {
                    background-color: #ffffff;
                    text-align: left;
                    position: relative;
                }
                .listing-boxes-text {
                    padding: 15px;
                    text-align: left;
                }
                .recent-listing-box-item .recent-feature-item-rating {
                    background: #f4f4f4;
                    display: block;
                    float: left;
                    padding: 5px 15px;
                    width: 100%;
                    position: relative;
                    left: 0;
                    right: 0;
                    bottom: 0px;
                }
                .recent-feature-item-rating h2 {
                    font-family:'Poppins', sans-serif;
                    color: #7d7d7d;
                    float: left;
                    font-size: 13px;
                    font-weight: 500;
                    line-height: 30px;
                    margin: 0;
                    text-align: left;
                }
                .recent-feature-item-rating span {
                    float: right;
                    font-size: 13px;
                    position: relative;
                    top: 7px;
                }
                .recent-feature-item-rating span i.fa {
                    color: #ffcc58;
                }
                .listing-boxes-text a h3 {
                    font-family:'Poppins', sans-serif;
                    color: #4a4a4a; 
                    font-size: 18px;
                    font-weight:500;
                    margin-top: 0;
                    margin-bottom:6px;
                }
                .recent-listing-box-item .recent-feature-item-rating h2 i {
                    color: #ffcc58;
                    font-size:14px;
                    margin-right: 3px;
                }
                .listing-boxes-text p {
                    color: #7d7d7d;
                    font-size: 13px;    
                    font-weight:500;
                    line-height: 22px;
                    margin-bottom: 0;
                    margin-top: 10px;
                    letter-spacing:0.3px;
                }
                .listing-boxes-text a {
                    font-family:'Poppins', sans-serif;  
                    color: #4064A0;
                    font-size: 13px;
                    font-weight: 400;
                    letter-spacing:0.2px;
                }
                .listing-boxes-text a i.fa {
                    color: #4064A0;
                    margin-right: 3px;
                }
                /*********************** vfx counter block *********************/
                .vfx-counter-block {
                    background: #fafafa url(assets/images/vfx_counter_bg.png) no-repeat center top;
                    background-position: cover;
                    background-attachment: fixed;
                    background-size: 100% 100%;
                    padding: 60px 0px 30px 0;
                }
                .vfx-item-countup {
                    background:rgba(255, 255, 255, 0.4);
                    width: 262px;
                    height: 262px;
                    border-radius: 8px;
                    text-align: center;
                    padding: 55px 0;
                    border: 5px solid #4064A0;
                    box-shadow:0 7px 12px rgba(0, 0, 0, 0.20);
                    margin-bottom: 30px;
                }
                .vfx-item-counter-up .count_number {
                    font-family:'Poppins', sans-serif;
                    color: #4a4a4a;
                    font-size: 50px;
                    line-height: 60px;
                    font-weight: 800;
                    margin-top: 5px;
                }
                .vfx-item-counter-up .counter_text {
                    font-family:'Poppins', sans-serif;
                    color: #696969;
                    font-size: 18px;
                    font-weight: 500;
                    text-transform: uppercase;
                }
                .vfx-item-black-top-arrow {
                    line-height: 45px;
                }
                .vfx-item-black-top-arrow i {
                    font-size: 46px;
                    line-height: 50px;
                    color: #4064A0
                }
                /*********************** pricing plan **********************/
                #pricing-item-block {
                    background: #f2f2f2;
                    padding: 80px 0px;
                }
                #pricing-section {
                    padding-bottom: 60px;
                    background: #f7f7f7;
                    border-bottom: 2px solid #4064A0;
                }
                .pricing-heading-title {
                    margin-bottom: 50px;
                }
                .pricing-heading-title h1 {
                    font-family:'Poppins', sans-serif;
                    margin: 0px;
                    color: #01273a;
                    text-transform: uppercase;
                    font-weight: 600;
                    font-size: 28px;
                }
                .pricing-heading-title h1 span {
                    color: #4064A0;
                }
                .price-table-feature-block {
                    padding: 35px 0px;
                    background: #ffffff;
                    border: 1px solid #ebebeb;
                    position: relative;
                }
                .price-table-feature-block.active {
                    box-shadow: -2px 5px 15px 7px #e2e2e2;
                    border-radius: 4px;
                    border:1px solid rgba(0, 0, 0, 0.15);   
                }
                .price-table-feature-block:hover {
                    transition: all 0.3s ease 0s;
                    box-shadow: -2px 5px 15px 7px #e2e2e2;
                    border-radius: 4px;
                    border:1px solid rgba(0, 0, 0, 0.15);   
                    -webkit-transform: scale(1.0);
                    transform: scale(1.0);
                    -webkit-transition: ease-out .5s;
                    -moz-transition: ease-out .5s;
                    -o-transition: ease-out .5s;
                    transition: ease-out .5s;
                    transition: all .5s ease-in-out 0;
                }
                .price-table-feature-block h1 {
                    font-family:'Poppins', sans-serif;
                    margin: 0px;
                    color: #01273a;
                    font-size: 22px;
                    font-weight: 500;
                    text-transform: uppercase;
                }
                .price-table-feature-block > hr {
                    width: 90px;
                    margin: 10px auto 15px auto;
                    border-color: #4064A0;
                }
                .price-table-feature-block p {
                    color: #999999;
                    font-size: 16px;
                    font-weight:400;
                    padding: 0px 40px;
                }
                .price-table-feature-block p span {
                    color: #4064A0;
                }
                .vfx-price-list-item {
                    display: block;
                    width: auto;
                    background:rgba(0, 0, 0, 0.02);
                    padding:25px 0;
                    border-bottom:1px solid #ebebeb;
                }
                .vfx-price-list-item:nth-child(even){
                    background:#ffffff;
                }
                .vfx-price-list-item h2 {
                    margin: 0px;
                    color: #01273a;
                    font-size: 16px;
                    font-weight: 500;
                }
                .vfx-price-list-item > h2:before {
                    content: 'ï‡™';
                    font-family:'FontAwesome';
                    color: #4064A0;
                    margin-right: 10px;
                }
                .vfx-price-list-item p {
                    margin: 0px;
                    color: #999999;
                    font-size: 13px;
                    line-height: 22px;
                    font-weight: 400;
                    margin-top: 10px;   
                }
                .vfx-pl-seperator {
                    background: #ebebeb none repeat scroll 0 0;
                    display: inline-block;
                    height: 1px;
                    margin-bottom: -6px;
                    margin-top: 15px;
                    position: relative;
                    width: 100%;
                }
                .vfx-pl-seperator > span {
                    background: none;
                    color: #d0d0d0;
                    display: inline-block;
                    font-family:'FontAwesome';
                    font-size: 0;
                    height: 18px;
                    margin-left: -9px;
                    position: absolute;
                    top: -9px;
                    width: 11px;
                }
                .vfx-pl-seperator span i.fa-caret-down {
                    font-size: 24px;
                    margin-left: -1px;
                }
                .list hr {
                    width: 100%;
                }
                .vfx-price-btn {
                    margin-top: 35px;
                    display: inline-block;
                }
                .vfx-price-btn button.purchase-btn {
                    font-family:'Poppins', sans-serif;
                    background: -webkit-linear-gradient(left, #262626 50%, #4064A0 50%) repeat scroll right bottom/207% 100% transparent;
                    background: linear-gradient(to right, #262626 50%, #4064A0 50%) repeat scroll right bottom/207% 100% transparent;
                    color: #01273a;
                    text-transform: uppercase;
                    border-radius: 30px;
                    padding: 15px 30px;
                    font-weight: 500;
                    -webkit-transition: background 350ms ease-in-out;
                    transition: background 350ms ease-in-out;
                    border: none;
                    outline: 0;
                }
                .price-table-feature-block:hover button.purchase-btn {
                    color:#ffffff;
                    background-position: left bottom;
                    box-shadow:0px 6px 6px -2px rgba(0, 0, 0, 0.4);
                }
                .vfx-price-btn button.purchase-btn i{
                    margin-right:3px;
                }
                /******************** listing product **********************/
                #vfx-product-inner-item {
                    background: #ffffff;
                    padding: 80px 0;
                }
                .news-search-lt {
                    margin-bottom: 30px;
                    width: 100%;
                    position: relative;
                }
                .news-search-lt input.form-control {
                    background-color: #fff;
                    border: 1px solid #ededed;
                    border-radius: 0;
                    color: #696969;
                    font-size: 14px;
                    font-weight:500;
                    letter-spacing:0.5px;
                    line-height: 28px;
                    padding: 10px;
                    width: 100%;
                    height: 50px;
                }
                .news-search-lt input.form-control {
                    box-shadow: none;
                }
                .news-search-lt span.input-search i {
                    bottom: 0;
                    color: #4064A0;
                    cursor: pointer;
                    display: inline-table;
                    float: right;
                    position: absolute;
                    right: 15px;
                    top: 17px;
                    z-index: 0;
                }
                .list-group {
                    margin-bottom: 2rem;
                }
                .list-group-item:first-child, .list-group-item:last-child {
                    border-radius: 30px;
                }
                a.list-group-item.active {
                    background: transparent linear-gradient(to right, #4064A0 50%, #f5f5f5 50%) repeat scroll right bottom / 207% 100%;
                    border-color: #4064A0;
                    color: #01273a;
                    z-index: 0;
                    border-radius:30px;
                    background-position: left bottom;
                }
                a.list-group-item:hover {
                    background: transparent linear-gradient(to right, #4064A0 50%, #f5f5f5 50%) repeat scroll right bottom / 207% 100%;
                    color: #01273a;
                    text-decoration: none;
                    background-position: left bottom;
                    border-color: #ddd;
                }
                .list-group a.list-group-item span {
                    font-family:'Poppins', sans-serif;
                    background: #4064A0;
                    border-radius: 30px;
                    color: #fff;
                    float: right;
                    font-weight:500;
                    font-size: 11px;
                    height: 28px;
                    line-height: 28px;
                    margin-top: 10px;
                    text-align: center;
                    vertical-align: middle;
                    width: 28px;    
                }
                a.list-group-item:hover i {
                    color: #01273a;
                }
                a.list-group-item:hover span {
                    background: #ffffff;
                    color: #01273a;
                }
                a.list-group-item:hovre i {
                 color:#ffffff;
                }
                a.list-group-item.active i {
                    color: #01273a;
                }
                a.list-group-item.active span {
                    background: #ffffff;
                    color: #01273a;
                }
                .left-slide-slt-block {
                    margin-bottom: 30px;
                    width: 100%;
                        border: 0 !important;
                    padding: 0 !important;
                }
                .left-slide-slt-block h3:first-child {
                    margin-top: 0px;
                }
                .left-slide-slt-block h3 {
                    background: #f1f1f1;
                    border: 1px solid #ededed;
                    color: #6b6b6b;
                    font-size: 16px;
                    font-weight: 500;
                    padding: 15px;
                    text-align: left;
                    letter-spacing:0.4px;
                }
                .list-group-item {
                    background: transparent linear-gradient(to right, #4064A0 50%, #ffffff 50%) repeat scroll right bottom / 207% 100%;
                    border: 1px solid #ddd;
                    display: block;
                    margin-bottom: 8px;
                    position: relative;
                    color: #696969;
                    font-size: 13px;
                    border-radius:30px;
                    line-height: 46px;
                    padding: 0 12px 0 15px;
                    font-weight:500;
                    -webkit-transition: all .6s ease 0;
                    transition: all .6s ease 0;
                    transition: all 0.3s ease 0s;
                }
                #vfx-product-inner-item .list-group a{
                    color: #696969;
                    letter-spacing:0.3px
                }
                a.list-group-item, button.list-group-item {
                    text-align: inherit;
                    width: 100%;
                }
                .list-group-item i {
                    color: #f9ca40;
                    padding-right: 5px;
                }
                .archive-tag {
                    width: 100%;
                    background: #fff;
                    padding: 20px 10px;
                    border-radius: 4px;
                    margin-bottom: 25px;
                    box-shadow: 0 3px 3px rgba(0, 0, 0, 0.1);
                }
                .archive-tag ul {
                    display: inline-block;
                    margin-bottom: 0px;
                    padding: 0;
                }
                .archive-tag ul li {
                    float: left;
                    list-style: outside none none;
                    padding: 5px 0;
                }
                .archive-tag ul li a {
                    background: transparent linear-gradient(to right, #4064A0 50%, #f1f1f1 50%) repeat scroll right bottom / 206% 100%;
                    color: #696969;
                    display: inline-block;
                    font-size: 13px;
                    font-weight: 500;
                    margin-right: 7px;
                    padding: 7px 13px;
                    border-radius: 4px;
                    text-align: center;
                    -webkit-transition: all .6s ease 0;
                    transition: all .6s ease 0;
                    transition: all 0.3s ease 0s;
                }
                .archive-tag ul li a:hover {
                    background: transparent linear-gradient(to right, #4064A0 50%, #f1f1f1 50%) repeat scroll right bottom / 206% 100%;
                    color: #fff;
                    background-position: left bottom;
                }
                .archive-tag ul li a.active {
                    background: transparent linear-gradient(to right, #dadada 50%, #4064A0 50%) repeat scroll right bottom / 206% 100%;
                    color: #ffffff;
                }
                .left-location-item {
                    width: 100%;
                }
                .left-location-item ul {
                    margin-bottom: 30px;
                    padding: 0;
                    width: auto;
                }
                .left-location-item .list-lt {
                    font-family:'Poppins', sans-serif;
                    background: #01273a;
                    border-radius: 30px;
                    color: #fff;
                    float: right;
                    font-size: 11px;    
                    font-weight:500;
                    margin-right: 8px;
                    padding: 4px 2px;
                    text-align: center;
                    width: 28px;
                    height: 28px;
                    line-height: 20px;
                    vertical-align: middle;
                }
                .left-location-item ul li {
                    list-style: outside none none;
                    padding: 7px 0 7px 10px;
                    line-height: 28px;
                    border-top: 1px solid rgba(241, 241, 241, 0.8)
                }
                .left-location-item ul li i{
                    margin-right:5px;
                }
                .left-location-item ul li:last-child {
                    border-bottom: 1px solid rgba(241, 241, 241, 0.8)
                }
                .left-location-item ul li a {
                    color: #696969;
                    font-size: 13px;
                    text-align: left;   
                    font-weight:500;
                    letter-spacing:0.3px;
                }
                .left-location-item ul li a:hover {
                    padding-left:6px;
                    color: #4064A0; 
                    -webkit-transition: all .6s ease 0;
                    transition: all .6s ease 0;
                    transition: all 0.3s ease 0s;
                }
                .left-archive-categor {
                    width: 100%;
                }
                .left-archive-categor ul {
                    margin-bottom: 30px;
                    padding: 0;
                    width: auto;
                }
                .left-archive-categor .list-lt {
                    font-family:'Poppins', sans-serif;
                    background: #01273a;
                    border-radius: 30px;
                    color: #fff;
                    float: right;
                    font-size: 11px;    
                    font-weight:500;
                    margin-right: 8px;
                    padding: 6px 8px;
                    text-align: center;
                    width: 30px;
                    height: 30px;
                    line-height: 18px;
                    vertical-align: middle;
                }
                .left-archive-categor ul li {
                    list-style: outside none none;
                    padding: 7px 0 7px 10px;
                    line-height: 30px;
                    border-top: 1px solid rgba(241, 241, 241, 0.8)
                }
                .left-archive-categor ul li:last-child {
                    border-bottom: 1px solid rgba(241, 241, 241, 0.8)
                }
                .left-archive-categor ul li a {
                    color: #696969;
                    font-size: 13px;
                    text-align: left;   
                    font-weight:500;
                    letter-spacing:0.3px
                }
                .left-archive-categor ul li a i{
                    margin-right:5px;
                }
                .left-archive-categor ul li a:hover {
                    padding-left:6px;
                    color: #4064A0; 
                    -webkit-transition: all .6s ease 0;
                    transition: all .6s ease 0;
                    transition: all 0.3s ease 0s;
                }
                .working-hours .days {
                    border-bottom: 1px solid rgba(241, 241, 241, 0.8);
                    line-height: 44px;
                    color: #696969;
                    padding-left: 8px;
                    padding-right: 8px;
                    letter-spacing:0.5px;
                }
                .working-hours .days:first-child {
                    border-top: 1px solid rgba(241, 241, 241, 0.8);
                }
                .working-hours .name {
                    font-size: 13px;
                    font-weight: 500;
                }
                .working-hours .hours {
                    float: right;
                    font-size: 13px;
                    font-weight: 400;
                    letter-spacing:0;
                    color:#969595;
                }
                #cargos_seleccionados {
                    background: #FFf;
                    padding: 10px;
                    box-shadow: 0 3px 3px rgba(0, 0, 0, 0.1);
                    text-align: left;
                }
                .title-seleccionados {
                    border: 1px solid #ccc;
                    padding: 5px 10px;
                    background: #fafafa;

                }

                #cargos_seleccionados > div{
                  margin-bottom: 20px;
                    border: 1px solid  #ccc;
                    padding: 5px 10px;
                        overflow: hidden;   
                }
                .flex-item-cargo-seleccionado-texto{
                    width: 80%;
                    float: left;
                    font-size: 14px;
                }

                .flex-item-cargo-seleccionado-icon{
                background: #245494;
                    border-radius: 30px;
                    color: #fff;
                    float: right;
                    font-weight: 500;
                    font-size: 11px;
                    height: 28px;
                    line-height: 28px;
                    margin-top: 10px;
                    text-align: center;
                    vertical-align: middle;
                    width: 28px;
                    }

                /******************* footer block********************/
                #clients {
                    background: #ffffff;
                    padding: 40px 0px;
                    border-bottom: 2px solid #4064A0;
                }
                #clients .bx-viewport {
                    background: none;
                    box-shadow: none;
                    border: none;
                }
                .site-footer {
                    color: #fff;
                    -webkit-background-size: cover;
                    background-size: cover;
                    background-position: 50% 50%;
                    background-repeat: no-repeat
                }
                .site-footer a {
                    font-family:'Poppins', sans-serif;
                    color: #cfcfcf;
                    font-size: 14px;
                    font-weight: 400;
                    line-height: 22px;
                    display: block;
                }
                p.about-lt {
                    font-family:'Poppins', sans-serif;
                    font-size: 13px;
                    line-height: 24px;
                    font-weight: 400;
                    color:#cfcfcf;
                    margin-bottom: 10px;
                    letter-spacing:0.1px;
                }
                a.more-detail {
                    color: #f9ca40;
                    float: left;
                    font-size: 13px;
                    font-weight: 500;
                    margin-bottom: 20px;
                    text-align: right;
                    text-transform: uppercase;
                    width: 100%;
                }
                .site-footer a:hover {
                    color: #4064A0
                }
                .site-footer p .fa {
                    padding:0 .125rem
                }
                .site-footer ul {
                    list-style: none;
                    padding-left: 0;
                    margin-bottom: 0
                }
                .site-footer ul li {
                    padding:.09rem 0
                }
                .social-icons li {
                    display: inline-block;
                    margin-bottom: 0.125rem;
                }
                .social-icons a {
                    background: transparent linear-gradient(to right, #14418b 50%, #ffffff 50%) repeat scroll right bottom / 207% 100%;
                    border-radius: 30px;
                    color: #00283b;
                    display: inline-block;
                    font-size: 14px;
                    width: 30px;
                    height: 30px;
                    line-height: 30px;
                    margin-right: 0.5rem;
                    text-align: center;
                    transition: background-color 0.2s linear 0s;
                    -webkit-transition: all .6s ease 0;
                    transition: all .6s ease 0;
                    transition: all 0.3s ease 0s;
                }
                .social-icons a:hover {
                    background: transparent linear-gradient(to right, #14418b 50%, #ffffff 50%) repeat scroll right bottom / 207% 100%;
                    color: #00283b;
                    background-position: left bottom;
                }
                .site-footer.footer-map {
                    background-image: url(assets/images/bg-map.png);
                    background-color: #000;
                    -webkit-background-size: contain;
                    background-size: contain;
                    background-position: 50% -40px
                }
                ul.widget-news-simple li {
                    border-bottom: 1px solid rgba(255, 255, 255, 0.15);
                    padding-bottom: 15px;
                }
                .widget-news-simple li {
                    margin-bottom: 15px;
                }
                .widget-news-simple div {
                    color: #f9ca40;
                    font-size: 13px;
                    font-weight: 600;
                }
                .news-thum {
                    float: left;
                    height: 70px;
                    margin-right: 15px;
                    width: 70px;
                }
                .news-text-thum {
                    margin-top: -5px;
                    padding-left: 82px;
                }
                .widget-news-simple h6 {
                    font-size: 16px;
                    font-weight: 600;
                    line-height: 22px;
                    margin-top: 5px;
                    margin-bottom: 5px;
                }
                .widget-news-simple h6 a {
                    font-family:'Poppins', sans-serif;
                    font-size: 16px;
                    font-weight: 400;
                }
                .widget-news-simple p {
                    font-family:'Poppins', sans-serif;
                    color: #cfcfcf;
                    font-size: 12px;
                    font-weight: 400;
                    line-height: 18px;
                    margin-bottom: 5px;
                    letter-spacing:0.3px;
                }
                .widget-news-simple div {
                    font-family:'Poppins', sans-serif;
                    color: #f9ca40;
                    font-size: 13px;
                    font-weight: 400;
                }
                ul.widget-news-simple .news-thum a img {
                    border-radius: 4px;
                }
                ul.use-slt-link li:first-child{
                    padding-top:0;
                }
                ul.use-slt-link li {
                    border-bottom: 1px solid rgba(255, 255, 255, 0.15);
                    padding: 8px 0;
                    transition: all 0.5s ease 0s;
                    -webkit-transition: all 0.5s ease 0s;
                    -moz-transition: all 0.5s ease 0s;
                }
                .site-footer .form-alt .form-group .form-control {
                    background-color: #fff;
                    color: #072d40;
                    border: 0 none;
                    border-radius: 3px;
                    font-size: 14px;
                    font-weight: 500;
                    line-height: 22px;
                    padding: 10px;
                }
                .btn-quote {
                    font-family:'Poppins', sans-serif;
                    background: -webkit-linear-gradient(left, #fffff 50%, #4064A0 50%) repeat scroll right bottom/207% 100% transparent;
                    background: linear-gradient(to right, #ffffff 50%, #4064A0 50%) repeat scroll right bottom/207% 100% transparent;
                    border: 0 none;
                    border-radius: 30px;
                    color: #fff;
                    display: block;
                    font-size: 14px;
                    font-weight:600;
                    letter-spacing: 0;
                    line-height: 24px;
                    margin: 0 auto;
                    padding: 8px 20px;
                    text-align: center;
                    -webkit-transition: background 350ms ease-in-out;
                    transition: background 350ms ease-in-out;
                    text-transform: uppercase;
                    transition: all 0.2s linear 0s;
                }
                .btn-quote:hover, .btn-quote:focus, .btn-quote:active, .btn-quote:active:focus {
                    background-color: #fff;
                    border-color: transparent;
                    background-position: left bottom;
                    box-shadow: none;
                    color: #072d40;
                    outline: medium none;
                }
                .site-footer .form-group input {
                    height: 40px;
                    color: #072d40;
                }
                .site-footer textarea.form-control {
                    box-shadow: 3px 4px 8px rgba(0, 0, 0, 0.14) inset;
                }
                .site-footer .form-group::-moz-placeholder {
                    color: #afafaf;
                }
                .site-footer .form-group::placeholder {
                    color: #999;
                    opacity: 1;
                }
                .site-footer .form-group::-moz-placeholder {
                    color: #999;
                    opacity: 1;
                }
                .footer-top {
                    background: rgba(30, 30, 30, 0.98);
                    padding: 80px 0 70px;
                }
                .footer-top h2 {
                    font-family:'Poppins', sans-serif;
                    font-size: 20px;
                    line-height: 24px;
                    color: #fff;
                    margin-bottom: 35px;
                    font-weight: 400;
                    margin-top: 0;
                    text-transform:none;
                    letter-spacing:0.5px;
                }
                .site-footer .footer-top hr {
                    background: #4064A0;
                    border: 0 none;
                    bottom: 0;
                    height: 2px;
                    left: 0;
                    margin: 10px 0;
                    position: relative;
                    right: 0;
                    text-align: left;
                    top: -25px;
                    width: 14%
                }
                .footer-top .social-icons {
                    margin-top: -5px
                }
                .footer-bottom {
                    background-color: #191919;
                    font-size: 0.875rem;
                    border-top: 1px solid #353535;
                    padding: 30px 0;
                    position: relative;
                }
                .footer-bottom p {
                    font-weight: 200;
                    line-height: 38px;
                    margin-bottom: 0;
                    letter-spacing:0.6px;
                    text-align: center;
                    font-size: 14px;
                }
                .scrollup {
                    background: rgba(0, 0, 0, 0) url('assets/images/top-move.png') no-repeat scroll 0 0;
                    bottom: 28px;
                    display: none;
                    height: 40px;
                    opacity: 0.9;
                    outline: medium none;
                    position: fixed;
                    right: 15px;
                    text-indent: -9999px;
                    width: 40px;
                }
                /******************* breadcrum ***********************/
                #breadcrum-inner-block {
                    padding: 85px 0px;
                    background: url(assets/images/listing-detail.jpg) center top no-repeat;
                    background-size: cover;
                    background-attachment: fixed;
                    background-size: 100% auto;
                }
                .breadcrum-inner-header {
                    text-align: left;
                    padding-left: 20px;
                }
                .breadcrum-inner-header::before {
                    background-color: #f9c841;
                    bottom: 2px;
                    content: '';
                    left: 15px;
                    position: absolute;
                    top: 2px;
                    width: 4px;
                }
                .breadcrum-inner-header h1 {
                    font-family:'Poppins', sans-serif;
                    color: #ffffff;
                    letter-spacing:0.4px;
                    margin: 0px;
                    font-size: 32px;
                    font-weight: 500;
                    text-transform: uppercase;
                    margin-bottom: 10px;
                }
                .breadcrum-inner-header a {
                    font-family:'Poppins', sans-serif;
                    color: #ffffff;
                    font-size: 14px;
                    font-weight: 400;
                    text-transform: uppercase;
                }
                .breadcrum-inner-header a:hover{
                    color:#4064A0
                }
                .breadcrum-inner-header i.fa {
                    color: #ffffff;
                    margin: 0px 5px;
                    font-size: 6px;
                    position: relative;
                    bottom: 2px;
                }
                .breadcrum-inner-header a span {
                    color: #4064A0;
                    font-size: 14px;
                    font-weight: 500;
                }
                @media(min-width:200px) and (max-width:1199px) {
                #breadcrum-inner-block {
                    background-size: 100% 100%;
                    background-attachment: scroll;
                }
                }
                /**************************** about company ********************************/
                #about-company {
                    background: #ffffff;
                    padding: 80px 0 0 0;
                }
                .about-heading-title {
                    margin-bottom: 35px;
                }
                .about-heading-title h1 {
                    font-family:'Poppins', sans-serif;
                    margin: 0px;
                    color: #01273a;
                    text-transform: uppercase;
                    font-weight: 600;
                    font-size: 28px;
                }
                .about-heading-title h1 span {
                    color: #4064A0;
                }
                p.inner-secon-tl {
                    font-family:'Poppins', sans-serif;
                    color: #696969;
                    font-size: 14px;
                    line-height: 27px;
                    font-weight: 400;
                    letter-spacing:0.3px;
                }
                .user-lt-above img {
                    transform: translateX(-5%);
                    vertical-align: bottom;
                }
                @media(min-width:979px) and (max-width:1199px) {
                .user-lt-above img {
                    transform: translateY(16%);
                    vertical-align: bottom;
                }
                #about-company {
                    padding-bottom: 30px;
                }
                }
                /******************************* featured service block **************************************/
                #featured-service-block {
                    background: #f2f2f2;
                    padding: 80px 0 60px 0; 
                }
                .service-item-fearured {
                    background: rgba(255, 255, 255, 0.8);
                    box-shadow: 0 1px 14px 2px rgba(0, 0, 0, 0.05);
                    padding: 30px 30px 20px;
                    margin-bottom: 30px;
                    border:5px solid rgba(0, 0, 0, 0.02);
                    border-radius:6px;
                }
                .service-item-fearured:hover {
                    background: #01273a;
                    border:5px solid rgba(0, 0, 0, 0.02);
                    box-shadow: 0 3px 14px 3px rgba(0, 0, 0, 0.3);
                    -webkit-transform: scale(1.05);
                    transform: scale(1.05);
                    -webkit-transition: ease-out 1.0s;
                    -moz-transition: ease-out 1.0s;
                    -o-transition: ease-out 1.0s;
                    transition: ease-out 1.0s;
                    transition: all 1.0s ease-in-out 0;
                }
                .svt-spec-service-icon {
                    margin-bottom: 25px;
                }
                .svt-spec-service-icon i {
                    background: #14418b;
                    border-radius: 50%;
                    color: #fff;
                    display: block;
                    font-size: 40px;
                    height: 90px;
                    line-height: 92px;
                    margin: 0 auto;
                    text-align: center;
                    width: 90px;
                }
                .service-item-fearured h3 {
                    font-family:'Poppins', sans-serif;
                    color: #4a4a4a;
                    font-size: 18px;
                    font-weight: 500;
                    margin-bottom: 20px;
                    margin-top: 10px;
                    text-align: center;
                    text-transform:none;
                }
                .service-item-fearured p {
                    font-family:'Poppins', sans-serif;
                    color:#696969;
                    font-size: 13px;
                    font-weight: 400;
                    line-height: 24px;
                    text-align: center;
                    letter-spacing:0.2px;
                }
                .service-item-fearured:hover h3, .service-item-fearured:hover p {
                    color: #ffffff;
                }
                .service-item-fearured:hover .hi-icon-effect-8 .hi-icon {
                    background: #14418b;
                    color: #ffffff; 
                    cursor: pointer;
                }
                .service-item-fearured:hover .hi-icon-effect-8 .hi-icon::after {
                    animation: 1.3s ease-out 75ms normal none 2 running sonarEffect
                }
                /* HORIZONTAL */

                @-webkit-keyframes horizontal {
                  0% {
                    -webkit-transform: translate(0,0);
                    transform: translate(0,0);
                  }

                  6% {
                    -webkit-transform: translate(5px,0);
                    transform: translate(5px,0);
                  }

                  12% {
                    -webkit-transform: translate(0,0);
                    transform: translate(0,0);
                  }

                  18% {
                    -webkit-transform: translate(5px,0);
                    transform: translate(5px,0);
                  }

                  24% {
                    -webkit-transform: translate(0,0);
                    transform: translate(0,0);
                  }

                  30% {
                    -webkit-transform: translate(5px,0);
                    transform: translate(5px,0);
                  }

                  36% {
                    -webkit-transform: translate(0,0);
                    transform: translate(0,0);
                  }
                }

                @keyframes horizontal {
                  0% {
                    -webkit-transform: translate(0,0);
                    -ms-transform: translate(0,0);
                    transform: translate(0,0);
                  }

                  6% {
                    -webkit-transform: translate(5px,0);
                    -ms-transform: translate(5px,0);
                    transform: translate(5px,0);
                  }

                  12% {
                    -webkit-transform: translate(0,0);
                    -ms-transform: translate(0,0);
                    transform: translate(0,0);
                  }

                  18% {
                    -webkit-transform: translate(5px,0);
                    -ms-transform: translate(5px,0);
                    transform: translate(5px,0);
                  }

                  24% {
                    -webkit-transform: translate(0,0);
                    -ms-transform: translate(0,0);
                    transform: translate(0,0);
                  }

                  30% {
                    -webkit-transform: translate(5px,0);
                    -ms-transform: translate(5px,0);
                    transform: translate(5px,0);
                  }

                  36% {
                    -webkit-transform: translate(0,0);
                    -ms-transform: translate(0,0);
                    transform: translate(0,0);
                  }
                }
                /**************************** Login Forms and Register Form Style ***************************/
                #m-info-window .info-window-hding {
                    margin-top: 0px;
                    font-size: 16px;
                }
                #m-info-window .info-window-desc {
                    margin-bottom: 0px;
                    line-height: 1.6em;
                }
                .modal-open .modal {
                    overflow-x: hidden;
                    overflow-y: auto;
                }
                .modal-dialog {
                    margin: 78px auto;
                    width: 600px;
                }
                .modal {
                    background: rgba(0, 0, 0, 0.7) none repeat scroll 0 0;
                    bottom: 0;
                    display: none;
                    left: 0;
                    outline: 0 none;
                    overflow: hidden;
                    position: fixed;
                    right: 0;
                    top: 0;
                    z-index: 1050;
                }
                .modal.in .modal-dialog {
                    transform: translate(0px, 0px);
                }
                .modal.fade .modal-dialog {
                    transform: translate(0px, 0%);
                    transition: transform 0.3s ease-out 0s;
                }
                .listing-modal-1.modal-dialog {
                    width: 395px;
                }
                .listing-modal-1 .modal-content {
                    background: #f7fbfc none repeat scroll 0 0;
                    border-radius: 0;
                    padding: 40px 30px;
                }
                .modal-content {
                    background-clip: padding-box;
                    background-color: #fff;
                    border: 1px solid rgba(0, 0, 0, 0.2);
                    border-radius: 6px;
                    box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
                    outline: 0 none;
                    position: relative;
                }
                .listing-modal-1 .modal-header {
                    border-bottom: medium none;
                    padding: 0;
                }
                .modal-header {
                    border-bottom: 1px solid #e5e5e5;
                    min-height: 16.43px;
                    padding: 15px;
                }
                .listing-modal-1 .modal-header .close {
                    color: #08c2f3;
                    font-size: 24px;
                    line-height: 1;
                    margin-top: 3px;
                    opacity: 1;
                }
                button.close {
                    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
                    border: 0 none;
                    cursor: pointer;
                    padding: 0;
                }
                .close {
                    color: #000;
                    float: right;
                    font-size: 21px;
                    font-weight: 700;
                    line-height: 1;
                    opacity: 0.2;
                    text-shadow: 0 1px 0 #fff;
                }
                .listing-modal-1 .modal-header .modal-title {
                    color: #08c2f3;
                    line-height: 1;
                    text-align: left;
                }
                .modal-title {
                    line-height: 1.42857;
                    margin: 0;
                }
                .listing-modal-1 .modal-body {
                    padding: 30px 0 0;
                }
                .listing-form-field {
                    position: relative;
                }
                .listing-form-field input.form-field {
                    border: 1px solid #eee;
                    box-shadow: none;
                    margin-bottom: 10px;
                    padding: 15px;
                }
                .listing-form-field input {
                    text-transform: normal;
                    width: 100%;
                }
                input[type='checkbox'], input[type='radio'] {
                    line-height: normal;
                    margin: 4px 0 0;
                }
                .regular-checkbox {
                    display: none;
                }
                .regular-checkbox + label {
                    border: 2px solid #4064A0;
                    display: inline-block;
                    height: 20px;
                    line-height: 20px;
                    position: relative;
                    top: -4px;
                    width: 20px;
                    border-radius:30px;
                }
                label.checkbox-lable {
                    color: #999;
                    position: relative;
                    top: -8px;
                }
                .listing-register-form .listing-form-field a {
                    color: #4064A0;
                    float: none;
                    top: -8px;
                }
                .listing-modal-1.modal-dialog {
                    width: 395px;
                }
                .listing-modal-1 .modal-content {
                    background: #f7fbfc;
                    border-radius: 10px;
                    padding: 35px 30px;
                }
                .listing-form-field label {
                    margin-bottom: -1px;
                    font-weight:500;
                }
                .listing-modal-1 .modal-header {
                    border-bottom: medium none;
                    padding: 0;
                }
                .listing-modal-1 .modal-header .modal-title {
                    font-family:'Poppins', sans-serif;
                    color: #4064A0;
                    font-size:20px;
                    line-height: 1;
                    text-align: left;
                    font-weight: 500;
                    display:block;
                    float:left;
                    text-transform: none
                }
                .listing-modal-1 .modal-header .close {
                    background: #eaeaea;
                    border-radius: 20px;
                    color: #01273a;
                    font-size: 25px;
                    height: 36px;
                    line-height: 34px;
                    margin-top: -9px;
                    opacity: 1;
                    width: 36px;
                    display: block;
                }
                .listing-modal-1 .modal-body {
                    padding: 40px 0 0;
                }
                .listing-form-field {
                    position: relative;
                }
                .listing-form-field i {
                    background: #ededed;
                    font-size: 20px;
                    border-left: 1px solid #eee;
                    height: 51px;
                    line-height: 50px;
                    position: absolute;
                    left: 0;
                    text-align: center;
                    top: 0;
                    color: #c1c1c1;
                    width: 51px;
                }
                .listing-form-field input {
                    text-transform: normal;
                    width: 100%;
                }
                .listing-form-field input.form-field {
                    border: 1px solid #eee;
                    box-shadow: none;
                    margin-bottom: 10px;
                    padding: 15px;
                }
                .listing-form-field a {
                    font-family:'Poppins', sans-serif;
                    display: inline-block;
                    float: right;
                    position: relative;
                    text-align: right;
                    top: -4px;
                    color: #4064A0;
                }
                .listing-register-form .listing-form-field a {
                    color: #4064A0;
                    float: none;
                    top: -8px;
                }
                .listing-form-field input.submit {
                    border: medium none;
                    border-radius: 4px;
                    color: #fff;
                    text-transform: uppercase;
                }
                .regular-checkbox:checked + label::after {
                    color: #4064A0;
                    content: 'âœ”';
                    font-size: 12px;
                    left: 0;
                    line-height: 20px;
                    position: absolute;
                    right: 0;
                    text-align: center;
                    top: -2px;
                }
                label.checkbox-lable {
                    font-family:'Poppins', sans-serif;
                    color: #999;
                    position: relative;
                    top: -8px;
                    margin-left: 5px;
                }
                .listing-register-form .listing-form-field a {
                    color: #4064A0;
                    float: none;
                    top: -8px;
                }
                .listing-register-form .listing-form-field a:hover {
                    color: #999999;
                    text-decoration: underline;
                }
                .listing-form-field input {
                    text-transform: normal;
                    width: 100%;
                }
                .bottom-links p {
                    font-family:'Poppins', sans-serif;
                    text-align:center;
                    font-weight:500;
                    text-transform:normal;
                }
                .bottom-links p a {
                    color: #4064A0;
                    display: inline-block;
                    margin-left: 10px;
                }
                .bottom-links p a:hover {
                    color: #999999;
                    text-decoration: underline;
                }
                .bgwhite {
                    background: #fff none repeat scroll 0 0;
                }
                .margin-top-20 {
                    margin-top: 20px;
                }
                .margin-bottom-20 {
                    margin-bottom: 20px;
                }
                .listing-form-field input.submit {
                    background: transparent linear-gradient(to right, #01273a 50%, #4064A0 50%) repeat scroll right bottom / 207% 100%;
                    border: none;
                    margin:0 auto;
                    width:68%;
                    display:block;
                    text-align:center;
                    font-size:15px; 
                    padding:14px 0;
                    margin-bottom:15px;
                    border-radius: 40px;
                    font-weight: 600;
                    color: #01273a;
                    text-transform: uppercase;
                    -webkit-transition: all .6s ease 0;
                    transition: all .6s ease 0;     
                }
                .listing-form-field input.submit:hover {
                    background-position: left bottom;
                    color: #ffffff;
                }
                .listing-form-field input.form-field {
                    font-family:'Poppins', sans-serif;
                    box-shadow: none;
                    font-weight:500;
                    font-size:14px;
                    margin-bottom: 10px;
                    padding:14px 10px 14px 60px;
                }
                .listing-form-field input.form-field:focus{ 
                    box-shadow:0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px rgba(102, 175, 233, 0.6);
                    outline:0 none;
                }
                .listing-form-field input {
                    text-transform: normal;
                    width: 100%;
                }
                .listings-images {
                    margin-right: 3px;
                    overflow: hidden;
                    position: relative;
                }
                .listings-images img {
                    height: 450px;
                    transition: all 0.5s ease 0s;
                }
                .listings-images:hover img {
                    transform: scale(1.2);
                }
                .listings-images1 {
                    display: inline-block;
                    margin-bottom: 3px;
                    float: left;
                    margin-right: 3px;
                    overflow: hidden;
                    position: relative;
                }
                .listings-images1 img {
                    transition: all 0.5s ease 0s;
                }
                .listings-images1:hover img {
                    transform: scale(1.2);
                }
                .listing-detail {
                    position: relative;
                    width: 100%;
                    display: inline-block;
                    margin-top: 15px;
                }
                .listing-detail h1 {
                    color: #242424;
                    font-weight: 500;
                    font-size: 18px;
                    text-transform: uppercase;
                    margin: 0px;
                }
                .listing-detail-text {
                    position: relative;
                    display: inline-block;
                    width: 100%;
                    margin-bottom: 5px;
                    background: #ffffff;
                    border: 1px solid #e8e8e8;
                }
                .listing-detail-text h1 {
                    margin: 0px;
                    color: #636363;
                    text-transform: capitalize;
                    font-weight: normal;
                    padding: 10px 14px 10px 14px;
                    font-size: 14px;
                    line-height: 20px;
                }
                .listing-detail-text p {
                    margin: 0px;
                    color: #999999;
                    font-size: 14px;
                    padding: 10px 14px 10px 14px;
                    border-left: 1px solid #e8e8e8;
                    text-transform: capitalize;
                }
                .listing-detail-text p span i.fa {
                    color: #4064A0;
                }
                .listing-detail-text p i.fa-map-marker, .listing-detail-text p a {
                    color: #999999;
                    margin-right: 5px;
                }
                #tags-share {
                    margin-top: 45px;
                    position: relative;
                    display: inline-block;
                    width: 100%;
                }
                #listings-tags p {
                    color: #636363;
                    margin: 0px;
                    font-size: 14px;
                    text-transform: capitalize;
                }
                #listings-tags p i.fa {
                    color: #636363;
                    margin-right: 10px;
                }
                #listings-tags p span {
                    margin-left: 30px;
                }
                #listings-tags p span a {
                    color: #999999;
                    display: inline-block;
                    font-size: 14px;
                    padding: 10px 12px;
                    background: #ffffff;
                    border-radius: 3px;
                    margin-bottom: 5px;
                }
                #listings-tags p span a:hover {
                    color: #ffffff;
                }
                #listings-share p {
                    color: #636363;
                    margin: 0px;
                    font-size: 14px;
                    text-transform: capitalize;
                    display: inline-block;
                }
                #listings-share p i.fa {
                    color: #636363;
                    margin-right: 10px;
                }
                #listings-share .social {
                    margin: 0px 30px 0px 30px;
                    display: inline-block;
                }
                #listings-share .social a {
                    background: #ffffff;
                    color: #cccccc;
                }
                #listings-share .social a:hover {
                    color: #ffffff;
                }
                /************************ reviews section *********************/
                #reviews-section {
                    background: #ffffff;
                    padding: 50px 0px;
                    border-bottom: 2px solid #4064A0;
                }
                .reviews-section, .reviews-section-new {
                    position: relative;
                    display: inline-block;
                    width: 100%;
                    padding: 10px 0px;
                }
                .reviews-section-new {
                    padding: 30px 0px;
                }
                .reviews-section-text h1 {
                    margin: 0px;
                }
                .reviews-section-text h1 a {
                    color: #000000;
                    font-weight: 500;
                    margin: 0px;
                    font-size: 16px;
                    text-transform: capitalize;
                }
                .reviews-section-text h4 {
                    font-weight: normal;
                    color: #636363;
                    margin: 7px 0px;
                    text-transform: uppercase;
                    font-size: 12px;
                }
                .reviews-section-text p {
                    color: #636363;
                    font-size: 14px;
                    margin: 0px;
                    line-height: 25px;
                }
                .reviews-section-text p a {
                    margin-left: 10px;
                    color: #636363;
                }
                .reviews-section-text p a:hover, .reviews-section-text h1 a:hover {
                    color: #4064A0;
                }
                #write-review h1, #reviews h1 {
                    color: #242424;
                    font-weight: 500;
                    text-transform: uppercase;
                    font-size: 18px;
                    margin: 0px;
                    border-left: 2px solid #4064A0;
                    padding: 5px 15px;
                }
                #write-review hr, #reviews hr, .contact-heading hr {
                    border-color: #e8e8e8;
                }
                #review-form, #contact-form {
                    position: relative;
                    display: inline-block;
                    margin-top: 15px;
                    width: 100%;
                }
                .review-form .form-control, .contact-form .form-control {
                    height: 45px;
                    border: 1px solid #cccccc;
                    border-left-color: #4064A0;
                    font-size: 14px;
                    transition: all 0.3s ease 0s;
                    -webkit-transition: all 0.3s ease 0s;
                    -moz-transition: all 0.3s ease 0s;
                    margin-bottom: 30px;
                    padding: 10px 12px;
                }
                .contact-form .form-control {
                    background: transparent;
                }
                .review-form .form-control:focus, .contact-form .form-control:focus {
                    border-color: #4064A0;
                }
                .review-form textarea.form-control {
                    height: 170px;
                }
                .contact-form textarea.form-control {
                    height: 235px;
                }
                #review-button, #contact-button {
                    display: inline-block;
                    width: 100%;
                    margin-top: 15px;
                }
                #review-button button, #contact-button button {
                    background: -webkit-linear-gradient(left, #262626 50%, #4064A0 50%) repeat scroll right bottom/207% 100% transparent;
                    background: linear-gradient(to right, #262626 50%, #4064A0 50%) repeat scroll right bottom/207% 100% transparent;
                    color: #ffffff;
                    border-radius: 4px;
                    border: none;
                    outline: 0;
                    font-weight: 500;
                    font-size: 14px;
                    padding: 10px 25px;
                    -webkit-transition: background 350ms ease-in-out;
                    transition: background 350ms ease-in-out;
                }
                #review-button button:hover, #contact-button button:hover {
                    background-position: left bottom;
                }
                /************************** contact section *********************/
                #contact-section {
                    padding: 60px 0px;
                    background: #f7f7f7;
                }
                .contact-heading {
                    position: relative;
                    width: 100%;
                    display: inline-block;
                }
                .contact-heading h1 {
                    margin: 0px;
                    text-transform: uppercase;
                    padding: 5px 15px;
                    border-left: 2px solid #4064A0;
                    font-weight: 500;
                    font-size: 18px;
                    color: #242424;
                }
                #contact-section-info p {
                    margin: 0px 0px 10px;
                    color: #636363;
                    font-size: 14px;
                    margin-top: 12px;
                }
                .contact-text .social {
                    margin-top: 15px;
                }
                .contact-text .social a {
                    background: #ffffff;
                    color: #cccccc;
                    height: 30px;
                    width: 30px;
                    line-height: 30px;
                }
                .contact-text .social a:hover {
                    color: #ffffff;
                }
                .contact-icon i.fa {
                    font-size: 20px;
                }
                .contact-icon .fa.fa-share-alt {
                    font-size: 16px;
                }
                #contact-map {
                    border-bottom: 2px solid #4064A0;
                }
                /******************** listing section ********************/
                #listing-section {
                    background: #f7f7f7;
                    padding-bottom: 55px;
                    border-bottom: 2px solid #4064A0;
                }
                .sorts-by-results {
                    border: 1px solid #ededed;
                    background: #f1f1f1;
                    border-radius: 6px;
                    display: block;
                    float: left;
                    margin-bottom: 30px;
                    position: relative;
                    white-space: nowrap;
                    height: auto;
                    line-height: 42px;
                    padding: 12px;
                    width: 100%;
                }
                .sorts-by-results span.result-item-view {
                    font-family:'Poppins', sans-serif;
                    font-size: 14px;
                    font-weight:500;
                    color:#6b6b6b;
                }
                .sorts-by-results span.result-item-view span.yellow {
                    color: #4064A0;
                    font-weight: 500;
                }
                .sorts-by-results .disp-f-right {
                    float: right;
                }
                .disp-f-right .disp-style {
                    float: left;
                    margin: 3px 5px 0 5px;
                }
                .disp-f-right .disp-style:last-child {
                    margin-right: 0px;
                }
                .sorts-by-results .disp-style a {
                    background: #fcfcfc;
                    border-radius: 5px;
                    border: 2px solid transparent;
                    float: right;
                    font-size: 14px;
                    line-height: 32px;
                    padding: 0px 9px;
                    color: #01273a;
                }
                .sorts-by-results .disp-style a:hover {
                    border: 2px solid rgba(255, 193, 7, 0.9);
                    color: #4064A0;
                    box-shadow: 0 1px 6px rgba(0, 0, 0, 0.2);
                }
                .sorts-by-results .disp-style.active a {
                    border: 2px solid rgba(255, 193, 7, 0.9);
                    color: #4064A0;
                    box-shadow: 0 1px 6px rgba(0, 0, 0, 0.2);
                }
                .list-view-item {
                    padding: 5px;
                }
                .list-view-item .listing-boxes-text p {
                    min-height: 90px;
                    height: 90px;
                }
                .list-view-item .listing-boxes-text p:before {
                    background: rgba(0, 0, 0, 0) linear-gradient(to bottom, rgba(255, 255, 255, 0), rgba(255, 255, 255, 1)) repeat scroll 0 0
                }
                .list-view-item:hover {
                    border: 1px solid #4064A0;
                    box-shadow: 0 0px 15px rgba(0, 0, 0, 0.2);
                }
                .list-view-item.active {
                    border: 1px solid #4064A0;
                    box-shadow: 0 0px 15px rgba(0, 0, 0, 0.2);
                }
                .list-view-item.active .recent-listing-box-item a h3 {
                    color: #4064A0;
                }
                .list-view-item.active .recent-listing-box-item a, .list-view-item.active .recent-listing-box-item a i {
                    color: #969595;
                }
                .list-view-item:hover .recent-listing-box-item a h3 {
                    color: #4a4a4a;
                }
                .vfx-person-block {
                    margin: 0 auto;
                    text-align: center;
                    width: 100%;
                    float: left;
                }
                .vfx-pagination {
                    border-radius: 0.25rem;
                    display: inline-flex;
                    list-style-type: none;
                    margin: 15px 0;
                }
                ul.vfx-pagination a {
                    background-color: #f9ca40;
                    border: medium none;
                    border-radius: 30px;
                    color: #fff;
                    float: left;
                    padding: 10px;
                    display: inline-block;
                    font-size: 14px;
                    font-weight: 600;
                    height: 34px;
                    line-height: 15px;
                    transition: all 0.2s linear 0s;
                    width: 34px;
                }
                ul.vfx-pagination li {
                    margin: 0 4px;
                }
                ul.vfx-pagination li.active a, ul.vfx-pagination li:hover a {
                    background-color: #00283b;
                    border: 0 none;
                    color: #fff;
                    border-radius: 30px;
                }
                /************************** add listings ***********************/
                #add-listings {
                    background: #f7f7f7;
                    padding: 60px 0px;
                    border-bottom: 2px solid #4064A0;
                }
                #user-option {
                    background: #ffffff;
                    padding: 50px 30px;
                    display: inline-block;
                    width: 100%;
                    height: 300px;
                }
                #user-option h1 {
                    margin: 0px;
                    font-size: 18px;
                    font-weight: 500;
                    text-transform: uppercase;
                    color: #242424;
                }
                #user-option hr {
                    border-color: #e8e8e8;
                }
                #user-option p {
                    color: #636363;
                    font-size: 16px;
                    margin: 0px;
                    padding-top: 10px;
                }
                #user-option p span {
                    text-transform: capitalize;
                    color: #242424;
                    cursor: pointer;
                    font-weight: normal;
                    transition: all 0.3s ease 0s;
                }
                #user-option p span.selected {
                    color: #4064A0;
                }
                #user-signup, #user-signin {
                    margin-top: 30px;
                    display: inline-block;
                    width: 100%;
                    transition: all 0.3s ease 0s;
                }
                #user-signup .form-group, #user-signin .form-group, #title-form .form-group {
                    margin-bottom: 0px;
                }
                #user-signup .form-control, #user-signin .form-control, #title-form .form-control, #locations .form-control {
                    border-color: #cccccc;
                    background: transparent;
                    padding-left: 20px;
                    height: 45px;
                    line-height: 30px;
                }
                .hide-form {
                    display: none;
                    transition: all 0.3s ease 0s;
                }
                #enter-listings {
                    padding: 50px 30px 20px;
                    margin-top: 40px;
                    background: #ffffff;
                    display: inline-block;
                    width: 100%;
                }
                #enter-listings h1 {
                    margin: 0px;
                    font-size: 18px;
                    font-weight: 500;
                    text-transform: uppercase;
                    color: #242424;
                }
                #enter-listings hr {
                    border-color: #e8e8e8;
                }
                #title-form {
                    margin-top: 10px;
                    display: inline-block;
                    width: 100%;
                }
                #title-form input {
                    margin-bottom: 30px;
                }
                .detail-content h2 {
                    color: #313131;
                    font-size: 22px;
                    font-weight: 500;
                    line-height: 24px;
                    margin: 20px 0 30px;
                }
                .detail-content .detail-amenities {
                    list-style: outside none none;
                    margin-bottom: 20px;
                    margin-top:30px;
                    padding-left: 0;
                }
                .detail-content .detail-amenities li {
                    width: 31%;
                }
                .detail-content .detail-amenities li.yes::before {
                    background-color: #14418b;
                    border-color: #14418b;
                    color: #ffffff;
                    content: 'ï€Œ';
                }
                .detail-content .detail-amenities li::before {
                    background-color: #01273a;
                    border: 2px solid #01273a;
                    border-radius: 15px;
                    color: #ffffff;
                    content: 'ï€';
                    display: inline-block;
                    font-family:'FontAwesome';
                    font-size: 10px;
                    height: 20px;
                    line-height: 15px;
                    margin-right: 10px;
                    text-align: center;
                    vertical-align: 2px;
                    width: 20px;
                }
                .detail-content .detail-amenities li {
                    display: inline-block;
                    font-size: 14px;
                    line-height: 40px;
                    color: #696969;
                    font-weight: 500;
                    margin-right: 10px;
                }
                .dlt-title-item {
                    margin-bottom: 25px;
                }
                .dlt-title-item h2 {
                    color: #4a4a4a;
                    font-size: 22px;
                    font-weight: 500;
                    line-height: 30px;
                    margin-bottom: 5px;
                }
                .dlt-title-item div {
                    color: #696969;
                    display: inline-block;
                    font-size: 14px;
                    font-weight: 400;
                    letter-spacing: 0.3px;
                    line-height: 18px;
                    padding-bottom: 6px;
                    text-transform: none;
                }
                .dlt-title-item div span {
                    font-family:'Poppins', sans-serif;
                    color: #ffbf02;
                }
                .dlt-title-item p {
                    margin-top: 25px;
                    color: #696969;
                    font-size: 14px;
                    font-weight: 400;
                    line-height: 28px;
                    letter-spacing:0.2px;
                }
                .dlt-title-item ul {
                    list-style: none;
                    margin-top:20px;
                    margin-bottom: 30px;
                }
                .dlt-title-item ul li {
                    list-style-image: url(assets/images/ic_right.png);
                    list-style-position: inside;
                    color: #696969;
                    font-size: 14px;
                    font-weight: 400;
                    line-height: 30px;
                    letter-spacing:0.2px;
                }
                .dlt-spons-item {
                    display: inline-block;
                    margin-bottom: 30px;
                    width: 100%;
                }
                .dlt-spons-item a:first-child {
                    margin-left: 0;
                }
                .dlt-spons-item a {
                    background: transparent linear-gradient(to right, #4064A0 50%, #f1f1f1 50%) repeat scroll right bottom / 206% 100%;
                    color:#696969;
                    display: inline-block;
                    font-size: 13px;
                    margin: 0 3px;
                    padding: 7px 15px;
                    font-weight: 500;
                    border-radius: 2px;
                    -webkit-transition: all .6s ease 0;
                    transition: all .6s ease 0;
                    transition: all 0.3s ease 0s;
                }
                .dlt-spons-item a:hover {
                    background: transparent linear-gradient(to right, #4064A0 50%, #f1f1f1 50%) repeat scroll right bottom / 206% 100%;
                    color: #ffffff;
                    background-position: left bottom;
                }
                .dlt-spons-item a.active {
                    background: transparent linear-gradient(to right, #f1f1f1 50%, #4064A0 50%) repeat scroll right bottom / 207% 100%;
                    color: #ffffff;
                }
                .dlt-com-lt-block {
                    background: #f8f8f8;
                    border: 1px solid #f5f5f5;
                    float: left;
                    padding: 30px;
                    width: 100%;
                }
                .dlt-com-lt-block:hover{
                    box-shadow:0 2px 10px rgba(0, 0, 0, 0.2)
                }
                .dlt-com-lt-img img {
                    border: 2px solid #e1e1e1;
                    border-radius: 50%;
                    height: auto;
                    width: 150px;
                }
                .dlt-com-lt-img {
                    display: block;
                    float: left;
                    margin-right: 20px;
                }
                .dlt-com-lt-img .social-icons {
                    margin: 15px auto 0;
                    text-align: center;
                }
                .social-icons li {
                    display: inline-block;
                    margin-bottom: 0.125rem;
                }
                .dlt-com-lt-img .social-icons a {
                    background: transparent linear-gradient(to right, #ffffff 50%, #14418b 50%) repeat scroll right bottom / 207% 100%;
                    border: 1px solid #14418b;
                    border-radius: 100%;
                    color: #fff;
                    margin: 0 5px;
                    width: 36px;
                    height: 36px;
                    line-height: 34px;
                    font-size: 16px;
                    -webkit-transition: all .6s ease 0;
                    transition: all .6s ease 0;
                    transition: all 0.3s ease 0s;
                }
                .dlt-com-lt-img .social-icons a:hover {
                    background: transparent linear-gradient(to right, #ffffff 50%, #14418b 50%) repeat scroll right bottom / 207% 100%;
                    border: 1px solid #14418b;
                    border-radius: 100%;
                    background-position: left bottom;
                    color: #14418b;
                }
                .dlt-com-lt-text {
                    color: #969696;
                    font-size: 14px;
                    padding-left: 180px;
                    text-align: left;
                }
                .dlt-com-lt-title {
                    color: #4a4a4a;
                    float: left;
                    font-size: 24px;
                    font-weight: 500;
                    margin-bottom: 4px;
                    padding-left: 3px;
                    width: 100%;
                }
                .dlt-com-clt {
                    color: #14418b;
                    font-size: 13px;
                    font-weight:500;
                    margin-bottom: 15px;
                }
                .dlt-com-lt-block p {
                    color: #696969;
                    font-size: 14px;
                    line-height: 26px;
                    font-weight:400;
                    letter-spacing:0.2px
                }
                .dlt-com-lt-comment-user {
                    display: block;
                    float: left;
                }
                .dlt-com-lt-comment-user h2 {
                    color: #4a4a4a;
                    font-size: 22px;
                    font-weight: 500;
                    line-height: 30px;
                    margin: 20px 0 30px;
                }
                .comments-wrapper {
                    float: left;
                    margin-top: 20px;
                    width: 100%;
                }
                .comments-wrapper h2 {
                    color: #313131;
                    font-size: 24px;
                    font-weight: 400;
                    line-height: 24px;
                    margin: 20px 0 30px;
                }
                .comments-wrapper .media {
                    background-color: #fff;
                    border: 1px solid #eee;
                    margin-top: 40px;
                    overflow: visible;
                    position: relative;
                }
                .media {
                    display: flex;
                    margin-bottom: 1rem;
                }
                .comments-wrapper .media-body, .media-left, .media-right {
                    display: table-cell;
                    vertical-align: top;
                }
                .comments-wrapper .media-body, .media-left, .media-right {
                    display: table-cell;
                    vertical-align: top;
                }
                .comments-wrapper .media .media-left img {
                    background: #fff none repeat scroll 0 0;
                    border-color: -moz-use-text-color #eee #eee;
                    border-image: none;
                    border-style: none solid solid;
                    border-width: 0 1px 1px;
                    border-color:#eeeeee;
                    bottom: -13px;
                    height: 56px;
                    left: -1px;
                    padding: 0 8px 8px;
                    position: absolute;
                    width: 65px;
                }
                .comments-wrapper .media-body p {
                    font-size: 13px;
                    font-weight: 400;
                    line-height: 24px;
                    color: #696969;
                    margin: 0;
                    padding: 20px 25px 20px 15px;
                    text-align: left;
                    letter-spacing:0.2px
                }
                .comment-meta {
                    background: #f9f9f9 none repeat scroll 0 0;
                    border-top: 1px solid #eee;
                    color: #969595;
                    font-size: 10px;
                    padding: 8px 10px 8px 65px;
                }
                .comment-meta a {
                    font-weight:600;
                    color: #01273a;
                    line-height:15px;
                }
                .comment-meta .author-name {
                    font-size: 14px;
                    margin-right: 5px;
                }
                .comment-meta .rating-box {
                    margin-left: 20px;
                    margin-bottom: 0;
                    vertical-align: middle;
                }
                .comment-meta .rating {
                    color: #f9a630;
                    vertical-align: middle;
                }
                .comment-meta .rating i {
                    font-size: 16px;
                    color:#ffcc58;
                    margin-top:3px;
                }
                span.comment-lt-time {
                    color: #969595;
                    font-size: 12px;
                }
                .comment-meta .comment-reply-link {
                    font-family:'Poppins', sans-serif;  
                    background: transparent linear-gradient(to right, #14418b 50%, #ffffff 50%) repeat scroll right bottom / 207% 100%;
                    border: 1px solid #eee;
                    color: #969595;
                    font-size:12px;
                    font-weight:500;
                    padding: 5px 15px;
                    border-radius:20px;
                    text-transform: uppercase;
                    -webkit-transition: all .6s ease 0;
                    transition: all .6s ease 0;
                    transition: all 0.3s ease 0s;
                }
                .comment-meta .comment-reply-link:hover {
                    background: transparent linear-gradient(to right, #14418b 50%, #ffffff 50%) repeat scroll right bottom / 207% 100%;
                    color: #00283b;
                    background-position: left bottom;
                }
                .comment-respond .form-group {
                    margin-bottom: 20px;
                }
                .comment-respond {
                    margin-top: 50px;
                }
                .comments-wrapper h2 {
                    color: #4a4a4a;
                    font-size: 22px;
                    font-weight: 500;
                    line-height: 30px;
                    margin: 20px 0 30px;
                }
                .comment-respond .rating-box span.rating i{
                    font-size:20px;
                    color:#ffcc58;
                    margin-right:5px;
                    margin-bottom:10px;
                }
                .comments-wrapper .form-control {
                    background-color: #f9f9f9;
                    border: 1px solid #f1f1f1;
                    border-radius:4px;
                    display: block;
                    font-size: 14px;
                    height: 46px;
                    line-height: 24px;
                    font-weight: 400;
                    padding: 15px 20px;
                    color: #969595;
                    transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
                    width: 100%;
                    box-shadow: none;
                }
                .comments-wrapper .form-control:focus {
                    border-color: #4064A0;
                    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px rgba(102, 175, 233, 0.6);
                    outline: 0 none;
                }
                .comments-wrapper textarea.form-control {
                    height: auto;
                }
                .comments-wrapper .comment-respond .btn {
                    background: transparent linear-gradient(to right, #4064A0 50%, #14418b 50%) repeat scroll right bottom / 207% 100%;
                    border-radius: 0;
                    color: #01273a;
                    font-size: 17px;
                    font-weight: 500;
                    height: 44px;
                    line-height:44px;
                    border-radius: 30px;
                    letter-spacing: 0.3px;
                    padding: 0 40px;
                    box-shadow: 0 3px 1px rgba(0, 0, 0, 0.25);
                    text-align: center;
                    text-transform: uppercase;
                    transition: all 0.2s linear 0s;
                    -webkit-transition: all .6s ease 0;
                    transition: all .6s ease 0;
                    transition: all 0.3s ease 0s;
                }
                .comments-wrapper .comment-respond .btn:hover {
                    background: transparent linear-gradient(to right, #01273a 50%, #dadada 50%) repeat scroll right bottom / 207% 100%;
                    color: #ffffff;
                    background-position: left bottom;
                    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.25)
                }
                .mce-tinymce iframe {
                    height: 220px;
                }
                #mceu_14-body, #mceu_28-body {
                    display: none;
                }
                .mce-btn {
                    background: #e8e8e8;
                }
                div.mce-edit-area {
                    border: 1px solid #cccccc;
                    border-top: none;
                }
                .mce-panel {
                    background-color: #e8e8e8;
                    border: 0 solid rgba(0, 0, 0, 0);
                }
                .mce-container, .mce-container *, .mce-widget, .mce-widget *, .mce-reset {
                    color: #787878;
                }
                #mceu_28 {
                    border-width: 0px;
                }
                .mce-toolbar-grp {
                    padding: 10px 0px;
                }
                .mce-btn-group:not(:first-child) {
                    border-left: none;
                }
                #mceu_22 > div {
                    display: none;
                }
                .mce-btn.mce-disabled button, .mce-btn.mce-disabled:hover button {
                    opacity: 1;
                }
                /******************** tags *****************/
                .tagsinput {
                    min-height: auto;
                    margin-top: 30px;
                    height: 45px;
                    border-radius: 4px;
                    border: 1px solid #cccccc;
                }
                div.tagsinput input {
                    width: 100%;
                    margin-bottom: 0px;
                }
                div.tagsinput span.tag {
                    background: #4064A0;
                    font-size: 12px;
                    color: #ffffff;
                    border: none;
                    border-radius: 4px;
                    margin: 3px 2px 0px 2px;
                }
                #tags_1_addTag > input {
                    color: #d0d0d0;
                    font-size: 14px;
                }
                div.tagsinput span.tag a {
                    color: #ffffff;
                }
                div.tagsinput {
                    padding-left: 20px;
                }
                #select-category {
                    display: inline-block;
                    position: relative;
                    width: 100%;
                    margin-top: 30px;
                }
                #select-category select {
                    height: 45px;
                    color: #999999;
                    background: url(assets/images/slt_btn_cat.png) top 50% right 15px no-repeat;
                    margin-bottom: 25px;
                }
                #select-category select:disabled {
                    color: #d0d0d0;
                    background: #e8e8e8 url(assets/images/slt_btn_cat.png) top 50% right 15px no-repeat;
                    border: none;
                }
                #location-detail {
                    padding: 50px 30px 50px;
                    margin-top: 40px;
                    background: #ffffff;
                    display: inline-block;
                    width: 100%;
                }
                #locations {
                    margin-top: 10px;
                    display: inline-block;
                    width: 100%;
                }
                .inner-addon i.fa {
                    bottom: 0;
                    color: #999999;
                    left: 3%;
                    position: absolute;
                    text-align: center;
                    top: 34%;
                }
                .inner-addon .form-control {
                    padding-left: 45px;
                    color: #c2c2c2;
                }
                #location-detail h1 {
                    margin: 0px;
                    font-size: 18px;
                    font-weight: 500;
                    text-transform: uppercase;
                    color: #242424;
                }
                #location-detail hr {
                    border-color: #e8e8e8;
                }
                #locations .form-group {
                    margin-bottom: 30px;
                }
                #locations .form-group .form-control {
                    color: #c2c2c2;
                }
                #gallery-images {
                    padding: 50px 30px 50px;
                    margin-top: 40px;
                    background: #ffffff;
                    display: inline-block;
                    width: 100%;
                }
                #gallery-images h1 {
                    margin: 0px;
                    font-size: 18px;
                    font-weight: 500;
                    text-transform: uppercase;
                    color: #242424;
                }
                #gallery-images hr {
                    border-color: #e8e8e8;
                }
                #gallery-images span {
                    display: inline-block;
                    color: #636363;
                    text-transform: capitalize;
                    font-size: 14px;
                    font-weight: 500;
                    margin-top: 20px;
                    cursor: pointer;
                }
                #add-images {
                    position: relative;
                    display: inline-block;
                    width: 100%;
                }
                .file-upload {
                    position: relative;
                    overflow: hidden;
                    width: 250px;
                    height: 250px;
                    background: #ffffff url(assets/images/add-image.png) top left no-repeat;
                    text-align: center;
                    margin-top: 20px;
                }
                .file-upload input.upload {
                    position: absolute;
                    top: 0;
                    right: 0;
                    margin: 0;
                    padding: 0;
                    font-size: 20px;
                    cursor: pointer;
                    opacity: 0;
                    filter: alpha(opacity=0);
                    height: 100%;
                    width: 100%;
                }
                #price-package {
                    padding: 50px 30px 50px;
                    margin-top: 40px;
                    background: #ffffff;
                    display: inline-block;
                    width: 100%;
                }
                #price-package h1 {
                    margin: 0px;
                    font-size: 18px;
                    font-weight: 500;
                    text-transform: uppercase;
                    color: #242424;
                }
                #price-package hr {
                    border-color: #e8e8e8;
                }
                #price-package p {
                    color: #636363;
                    font-size: 14px;
                    margin: 0px;
                    padding-top: 20px;
                }
                #packages {
                    margin: 30px 20px 0px;
                    color: #636363;
                    font-size: 14px;
                }
                input[type='checkbox'], input[type='radio'] {
                    margin-right: 10px;
                    margin-bottom: 15px;
                }
                input[type=radio]:checked {
                    color: #4064A0;
                    background: #4064A0;
                }
                #preview-add {
                    display: inline-block;
                    margin-top: 30px;
                }
                #preview-add button {
                    background: -webkit-linear-gradient(left, #262626 50%, #4064A0 50%) repeat scroll right bottom/207% 100% transparent;
                    background: -o-linear-gradient(left, #262626 50%, #4064A0 50%) repeat scroll right bottom/207% 100% transparent;
                    background: linear-gradient(to right, #262626 50%, #4064A0 50%) repeat scroll right bottom/207% 100% transparent;
                    border: none;
                    color: #ffffff;
                    -webkit-transition: all 0.3s ease 0s;
                    -moz-transition: all 0.3s ease 0s;
                    -o-transition: all 0.3s ease 0s;
                    transition: all 0.3s ease 0s;
                    padding: 10px 20px;
                    font-weight: 500;
                    font-size: 14px;
                    text-transform: capitalize;
                    border-radius: 4px;
                    outline: 0;
                }
                #preview-add button:hover {
                    background-position: left bottom;
                }
                /**************************** right side bar ***************************/
                #process, #sidebar-navigation {
                    padding: 40px 25px;
                    background: #ffffff;
                    display: inline-block;
                    width: 100%;
                }
                #scroll-element {
                    position: relative;
                }
                #sidebar-navigation {
                    margin-top: 30px;
                    display: none;
                }
                #process h1, #sidebar-navigation h1 {
                    margin: 0px;
                    font-size: 18px;
                    font-weight: 500;
                    text-transform: uppercase;
                    color: #242424;
                    padding-bottom: 30px;
                }
                #process a, #sidebar-navigation a {
                    color: #636363;
                    font-size: 14px;
                    text-transform: capitalize;
                    list-style: none;
                    padding: 0px;
                }
                #process-section a span {
                    color: #4064A0;
                    margin-right: 10px;
                }
                #process ul li a:hover, #process ul li a:focus, #process ul li a:active, #sidebar-navigation a:hover, .active a {
                    color: #4064A0;
                    background-color: transparent;
                }
                #process hr, #sidebar-navigation hr {
                    border-color: #e8e8e8;
                }
                .navbar ul {
                    padding: 0;
                    list-style: none;
                }
                .navbar ul li {
                    display: inline-block;
                    position: relative;
                    line-height: 21px;
                    text-align: left;
                }
                .navbar ul li a {
                    display: block;
                    padding: 8px 25px;
                    color: #333;
                    text-decoration: none;
                }
                .navbar ul li a:hover {
                    color: #fff;
                    background: #939393;
                }
                ul.dropdown li a {
                    background: transparent linear-gradient(to right, #4064A0 50%, #ffffff 50%) repeat scroll right bottom / 207% 100%;
                    text-transform: none;
                    width: 100%;
                    display: block;
                    transition: all .6s ease 0;
                    -webkit-transition: background 350ms ease-in-out;
                    transition: background 350ms ease-in-out;
                }
                ul.dropdown li a:hover {
                    background: transparent linear-gradient(to left, #ffffff 50%, #4064A0 50%) repeat scroll left bottom / 207% 100% !important;
                    color: #262626 !important;
                    background-position: left bottom;
                }
                ul.dropdown i.fa {
                    color: #262626;
                    margin-right: 5px;
                }
                .navbar ul li ul.dropdown {
                    width: 230px;
                    background: #f2f2f2;
                    display: none;
                    position: absolute;
                    z-index: 999;
                    left: 0;
                    border: 5px solid rgba(0, 0, 0, 0.1);
                    line-height: 30px !important;
                }
                .navbar ul li ul.dropdown li a {
                    padding: 12px 10px !important;
                    width: 220px;
                    margin-bottom: 0 !important;
                }
                #nav_menu_list a i.fa {
                    margin-left: 5px;
                }
                .navbar ul li ul.dropdown li {
                    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
                }
                .navbar ul li ul.dropdown li:last-child {
                    border-bottom: 0px;
                    margin-bottom: 0px;
                }
                .navbar ul li:hover ul.dropdown {
                    display: block;
                }
                .navbar ul li ul.dropdown li {
                    display: block;
                    width: 220px;
                }
                .details-lt-block {
                    background-attachment: fixed;
                    background-position: right center;
                    background-size: auto 100%;
                }
                .details-lt-block .slt_block_bg img {
                    height: auto;
                    width: 100%;
                }
                .slt_block_bg img {
                    position: relative;
                    z-index: -1;
                }
                .slt_block_bg {
                    background: rgba(0, 0, 0, 0) linear-gradient(to bottom, rgba(0, 0, 0, 0.50) 0%, rgba(0, 0, 0, 0.95) 100%) repeat scroll 0 0;
                    transition: all 0.3s ease 0s;
                }
                .header_slt_block {
                    position: relative;
                }
                .slt_item_head {
                    bottom:100px;
                    position: absolute;
                    width: 100%;
                }
                .header_slt_block .user_logo_pic {
                    background: rgba(0, 0, 0, 0.15) linear-gradient(to bottom, rgba(16, 14, 13, 0.0) 0%, rgba(16, 14, 13, 0.8) 100%) repeat scroll 0 0;
                    border-radius: 90px;
                    height: 180px;
                    left: 0px;
                    padding: 10px;
                    position: relative;
                    text-align: center;
                    top: 0px;
                    width: 180px;
                    float: left;
                }
                .header_slt_block .user_logo_pic img {
                    border-radius: 90px;
                    height: auto;
                    margin: 0;
                    width: 100%;
                }
                .slt_item_contant {
                    float: left;
                    left: 185px;
                    margin-bottom: 10px;
                    margin-left: 25px;
                    position: absolute;
                }
                .slt_item_head h1 {
                    font-family:'Poppins', sans-serif;
                    color: #ffffff;
                    font-size: 32px;
                    font-weight:500;
                    margin-bottom: 10px;
                    margin-top: 0px;
                }
                .slt_item_head .contact_number i, .slt_item_head .email_detail i, .slt_item_head .location i{
                    padding-right:8px;
                    text-align:center;
                    width:24px;
                    height:auto;    
                    color:#14418b;
                }
                .slt_item_head .contact_number{
                    font-family:'Poppins', sans-serif;
                    color: #fff;
                    margin-right: 0px;
                    font-size:16px;
                    font-weight:400;
                }
                .slt_item_head .email_detail{
                    color: #fff;
                    margin-right: 0px;
                    font-weight:400;
                }
                .slt_item_head .email_detail a{
                    color: #fff;    
                    font-weight:400;
                }
                .slt_item_head .email_detail a:hover{
                    text-decoration:none;
                    color:#ffcc58;
                }
                .slt_item_head .location {
                    color: #fff;
                    margin-right: 0px;
                    font-weight:400;
                }
                .head-bookmark-bock {
                    float: left;
                    margin-top: 12px;
                    width: 100%;
                    line-height: 40px;
                    display: block;
                }
                .slt_item_head .detail-banner-btn {
                    display: inline-block;
                    margin-right: 10px;
                }
                .slt_item_head .detail-banner-btn a {
                    background: transparent linear-gradient(to right, #ffffff 50%, #4064A0 50%) repeat scroll right bottom / 207% 100%;     
                    color: #01273a;
                    cursor: pointer;
                    padding: 9px 15px;
                    font-weight: 600;
                    font-size: 14px;
                    border-radius:30px;
                    -webkit-transition: all .6s ease 0;
                    transition: all .6s ease 0;
                    transition: all 0.3s ease 0s;
                    text-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
                }
                .slt_item_head .detail-banner-btn a:hover {
                    background: transparent linear-gradient(to right, #ffffff 50%, #4064A0 50%) repeat scroll right bottom / 207% 100%;
                    background-position: left bottom;   
                    color: #01273a;
                    -webkit-transition: all .6s ease 0;
                    transition: all .6s ease 0;
                    transition: all 0.3s ease 0s;
                }
                .slt_item_head .detail-banner-btn a:hover i {
                    color: #323232;
                }
                .rating-box, .venue-action {
                    color: #ffcc58;
                    margin-bottom: 5px;
                }
                .slt_item_head .detail-banner-btn {
                    color: #fff;
                    cursor: pointer;
                    font-family:'Open Sans', sans-serif;
                    text-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
                }
                .slt_item_head .detail-banner-btn i {
                    font-size: 16px;
                    margin-right: 5px;
                    color: #01273a;
                }
                @media(min-width:980px) and (max-width:1199px) {
                .slt_item_head {
                    width: 100%;
                    left: 0;
                    bottom:70px;
                    padding: 0 10px;
                }
                .slt_item_head h1 {
                    font-size: 32px;
                }
                }
                @media(min-width:768px) and (max-width:979px) {
                .slt_item_head {
                    bottom: 70px;
                    width: 100%;
                    left: 0;
                    padding: 0 10px;
                }
                .details-lt-block .slt_block_bg img {
                    height: 300px;
                    width: 100%;
                }
                .slt_item_head h1 {
                    font-size: 26px;
                }
                }
                @media(max-width:640px) {
                .slt_item_head h1 {
                    color: #fff;
                    font-size: 22px;
                    margin-bottom: 10px;
                    margin-top: 10px;
                }
                .slt_item_head .location {
                    float: none;
                }
                .slt_item_head .contact_number, .slt_item_head .email_detail a, .slt_item_head .location{
                    font-size:14px;
                }
                }
                @media(max-width:767px) {
                .header_slt_block .user_logo_pic {
                    height: 130px;
                    left: 0px;
                    padding: 10px;
                    position: relative;
                    text-align: center;
                    top: 0;
                    float: none;
                    width: 130px;
                }
                .slt_item_contant {
                    float: none;
                    left: 0;
                    margin-bottom: 10px;
                    margin-left: 0px;
                    position: relative;
                }
                .slt_block_bg {
                    min-height: 460px;
                }
                .slt_item_head {
                    left: 0;
                    padding: 0 15px;
                    width: 100%;
                }
                .slt_item_head .detail-banner-btn {
                    margin-right: 10px;
                }
                }
                .sidebar-listing-search-wrap {
                    padding: 0px;
                    width: 100%;
                }
                .sidebar-listing-search-wrap form p {
                    font-size:16px;
                    font-weight: 500;
                    color: #7e7e7e;
                    margin-top: 15px;
                    text-align: left;
                }
                .sidebar-listing-search-wrap form select.sidebar-listing-search-select {
                    -moz-appearance: none;
                    border: medium none;
                    background: #f9f9f9 url('assets/images/form-icon-2.png') no-repeat scroll 100% 0px;
                    box-shadow: 0 0 0 1px #ececec;
                    color: #696969;
                    font-size: 14px;
                    height: 44px;
                    line-height: 44px;
                    margin-bottom: 8px;
                    margin-top: 8px;
                    padding: 0 0 0 15px;
                    font-weight:500;
                    text-transform: capitalize;
                    width: 100%;
                }
                .sidebar-listing-search-wrap form select.sidebar-listing-search-select option {
                    background-color: #fff;
                    border-color:rgba(0, 0, 0, 0.2);
                    border-style: solid none none;
                    border-width: 1px medium medium;
                    font-size: 13px;
                    padding: 10px 12px;
                    font-weight:500;
                }
                .sidebar-listing-search-wrap form input.sidebar-listing-search-input {
                    background-color: #f9f9f9;
                    box-shadow: 0 0 1px 1px #ececec;
                    border: medium none;
                    margin-bottom: 8px;
                    margin-top: 8px;
                    padding: 10px 15px;
                    width: 100%;
                    font-weight:500;
                }
                .sidebar-listing-search-wrap form input.sidebar-listing-search-input::before {
                    -moz-appearance: none;
                    border: medium none;
                    background: #f9f9f9 url('assets/images/form-icon-2.png') no-repeat scroll 100% 0px;
                    box-shadow: 0 0 0 1px #ececec;
                    color: #696969;
                    font-size: 14px;
                    height: 44px;
                    line-height: 56px;
                    margin-bottom: 8px;
                    margin-top: 8px;
                    padding: 0 0 0 15px;
                    text-overflow: '';
                    text-transform: capitalize;
                    width: 100%;
                }
                .sidebar-listing-search-wrap form .listing-search-btn::before {
                    content: 'ï€‚';
                    font-family:'FontAwesome';
                    left: 30%;
                    position: absolute;
                    text-align: center;
                    top: 48%;
                    color: #ffffff;
                    transform: translateY(-50%);
                }
                .sidebar-listing-search-wrap form .listing-search-btn {
                    margin-top: 15px;
                    margin-bottom: 25px;
                    position: relative;
                }
                .sidebar-listing-search-wrap form input.sidebar-listing-search-btn {
                    border: 2px solid #01273a;
                    margin-top: 0;
                    padding: 10px;
                    width: 100%;
                    font-weight: 500;
                    background: transparent linear-gradient(to right, #4064A0 50%, #01273a 50%) repeat scroll right bottom / 206% 100%;
                    color: #ffffff;
                    -webkit-transition: all .6s ease 0;
                    transition: all .6s ease 0;
                    transition: all 0.3s ease 0s;
                }
                .sidebar-listing-search-wrap form input.sidebar-listing-search-btn:hover {
                    border: 2px solid #4064A0;
                    background: transparent linear-gradient(to right, #4064A0 50%, #01273a 50%) repeat scroll right bottom / 206% 100%;
                    background-position: left bottom;
                    color: #ffffff;
                }
                .detail-content h2 {
                    color: #4a4a4a;
                    font-size: 22px;
                    font-weight: 500;
                    line-height: 30px;
                    margin-bottom: 5px;
                }
                .detail-content .detail-video {
                    margin: 25px 0;
                    max-width: 100%;
                    float:left;
                    display:block;
                }
                .contact-heading-title {
                    margin-bottom: 50px;
                }
                .contact-heading-title h1 {
                    margin: 0px;
                    color: #01273a;
                    text-transform: uppercase;
                    font-weight: 600;
                    font-size: 28px;
                }
                .contact-heading-title h1 span {
                    color: #4064A0;
                }
                .clt-content {
                    font-family:'Poppins', sans-serif;
                    color: #696969;
                    display: inline-block;
                    font-size: 14px;
                    font-weight:400;
                    line-height: 28px;
                    margin-bottom: 60px;
                    padding: 0 15px;
                    text-align: left;
                }
                .from-list-lt input {
                    background: #f9f9f9;
                    border: 1px solid #f1f1f1;
                    border-radius: 4px;
                    box-shadow: none;
                    font-size: 14px;
                    font-weight: 400;
                    height: 44px;
                    padding-left: 60px;
                }
                .from-list-lt input:focus {
                    border-color: #4064A0
                }
                .from-list-lt .from-input-ic {
                    border-right: 1px solid rgba(216, 216, 216, 0.6);
                    bottom: 0;
                    left: 15px;
                    padding-right: 15px;
                    position: absolute;
                    top: 0;
                    width: 44px;
                }
                .from-list-lt .from-input-ic i {
                    color: #d8d8d8;
                    font-size: 17px;
                    margin-left: 15px;
                    margin-top: 13px;
                }
                .form-float {
                    transform: translateY(0%);
                }
                .from-list-lt .form-control:focus {
                    background: #fff none repeat scroll 0 0;
                    opacity: 1;
                }
                .from-list-lt textarea {
                    background: #f9f9f9;
                    border: 1px solid #f1f1f1;
                    border-radius: 4px;
                    box-shadow: none;
                    font-size: 14px;
                    font-weight: 500;
                    padding-left: 60px;
                }
                .from-list-lt textarea:focus {
                    border-color: #4064A0
                }
                textarea.form-control {
                    height: 110px;
                    line-height: 26px;
                    font-weight:400;
                }
                .from-list-lt .from-input-ic {
                    border-right: 1px solid rgba(216, 216, 216, 0.6);
                    bottom: 0;
                    left: 15px;
                    padding-right: 15px;
                    position: absolute;
                    top: 0;
                    width: 44px;
                }
                .from-list-lt .btn {
                    background: transparent linear-gradient(to right, #4064A0 50%, #14418b 50%) repeat scroll right bottom / 207% 100%;
                    border-radius: 0;
                    color: #fff;
                    font-size: 16px;
                    font-weight: 600;
                    height: 46px;
                    line-height:46px;
                    border-radius: 30px;    
                    padding: 0 30px;
                    box-shadow: 0 5px 8px rgba(0, 0, 0, 0.25);
                    text-align: center;
                    *text-transform: uppercase;
                    transition: all 0.2s linear 0s;
                    -webkit-transition: all .6s ease 0;
                    transition: all .6s ease 0;
                    transition: all 0.3s ease 0s;
                    margin-top: 20px;
                }
                .from-list-lt .btn:hover {
                    background: transparent linear-gradient(to right, #01273a 50%, #dadada 50%) repeat scroll right bottom / 207% 100%;
                    color: #fff;
                    background-position: left bottom;
                    box-shadow: 0 3px 1px rgba(0, 0, 0, 0.25)
                }
                input.verifi_code {
                    border:1px solid #f1f1f1;
                    border-radius: 4px;
                    font-size: 14px;
                    font-weight: 500;
                    height: 44px;
                    padding-left: 20px;
                }
                #captcha {
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    box-shadow: 0 0 7px -4px rgba(0, 0, 0, 0.3);
                    margin-top: 0;
                }
                .buttons input, .captchareload {
                    background: #14418b;
                    border-color: #14418b;
                    border-radius: 5px;
                    border-style: solid;
                    border-width: 2px;
                    color: #fff;
                    padding: 2px 5px;
                    vertical-align: middle;
                }
                .captchareload {
                    margin-left: 15px;
                }
                .lt-co-icon {
                    display: block;
                    float: left;
                }
                .lt-co-blok-text {
                    padding-left: 55px;
                }
                .lt-co-title {
                    color: #343d46;
                    font-size: 18px;
                    font-weight: 600;
                }
                .lt-co-blok-text hr {
                    border: 0 none;
                    bottom: 0;
                    height: 2px;
                    left: 0;
                    margin: 10px 0;
                    position: relative;
                    right: 0;
                    text-align: left;
                    top: -3px;
                    width: 10%;
                }
                .lt-co-yellow-hr {
                    background: #494e53;
                }
                .media-iconic .media-body p {
                    color: #343d46;
                    font-size: 14px;
                    font-weight: 500;
                    line-height: 26px;
                    padding-bottom: 10px;
                }
                .lt-bdr-one {
                    border-bottom: 2px solid #494e53;
                }
                .lt-co-blok-text hr {
                    border: 0 none;
                    bottom: 0;
                    height: 2px;
                    left: 0;
                    margin: 10px 0;
                    position: relative;
                    right: 0;
                    text-align: left;
                    top: -3px;
                    width: 10%;
                }
                .lt-co-green-hr {
                    background: #f5c026;
                }
                .lt-bdr-two {
                    border-bottom: 2px solid #f5c026;
                }
                .media-iconic .media-body p b {
                    font-weight: 600;
                }
                .lt-co-blok-text hr {
                    border: 0 none;
                    bottom: 0;
                    height: 2px;
                    left: 0;
                    margin: 10px 0;
                    position: relative;
                    right: 0;
                    text-align: left;
                    top: -3px;
                    width: 10%;
                }
                .lt-bg-blue-hr {
                    background: #39a2e9;
                }
                .media-iconic .media-body p {
                    color: #7e7e7e;
                    font-size: 14px;
                    font-weight: 400;
                    line-height: 26px;
                    padding-bottom: 10px;
                }
                .media-iconic .media-body p a{
                    color:#7e7e7e
                }
                .media-iconic .media-body p a:hover{
                    color:#f5c026
                }
                .lt-bdr-three {
                    border-bottom: 2px solid #39a2e9;
                }
                /************************************ dashboard page **************************************/
                #leftcol_item {
                    margin-bottom: 30px;
                }
                .user_dashboard_pic {
                    background: #f9f9f9;
                    border: 1px dashed #e9e9e9;
                    border-radius: 10px;
                    padding: 10px;
                    position: relative;
                    box-shadow: 0 1px 7px rgba(0, 0, 0, 0.1);
                }
                .user_dashboard_pic img {
                    height: auto;
                    width: 100%;
                    border: 1px dashed #e9e9e9;
                    border-radius: 10px;
                }
                .user-photo-action {
                    background: rgba(255, 255, 255, 0.85);
                    bottom: 10px;
                    color: #363636;
                    font-family:'Poppins', sans-serif;
                    left: 10px;
                    padding: 10px 0;
                    border-radius: 0 0 10px 10px;
                    position: absolute;
                    height: 44px;
                    line-height: 22px;
                    font-weight: 500;
                    right: 10px;
                    text-align: center;
                }
                .dashboard_nav_item {
                    margin-bottom: 25px;
                }
                .dashboard_nav_item ul {
                    display: block;
                    float: left;
                    list-style-type: none;
                    margin-bottom: 20px;
                    width: 100%;
                }
                .dashboard_nav_item ul li {
                    background: transparent linear-gradient(to right, #4064A0 50%, #f9f9f9 50%) repeat scroll right bottom / 207% 100%;
                    width: 100%;
                    float:left;
                    margin-bottom:12px;
                    display: block;
                    border-radius:30px;
                    -webkit-transition: background 350ms ease-in-out;
                    transition: background 350ms ease-in-out;
                    border: 1px solid #e9e6e0;
                }
                .dashboard_nav_item ul li a {
                    font-family:'Poppins', sans-serif;
                    font-size: 14px;
                    font-weight: 500;
                    color: #4e4e4e;
                    height: 46px;
                    line-height: 26px;
                    padding: 10px 15px;
                    text-align: left;
                    display: block;
                    letter-spacing:0.3px;
                    vertical-align: middle;
                }
                .dashboard_nav_item ul li a i {
                    float: left;
                    font-size: 17px;
                    padding-right: 10px;
                    padding-top: 3px;
                    text-align: center;
                }
                .dashboard_nav_item ul li:hover {
                    background: transparent linear-gradient(to right, #4064A0 50%, #f9f9f9 50%) repeat scroll right bottom / 207% 100%;
                    background-position: left bottom;
                    border: 1px solid #e9e6e0;
                    box-shadow:0 3px 3px rgba(0, 0, 0, 0.1);
                }
                .dashboard_nav_item ul li.active {
                    background: transparent linear-gradient(to right, #4064A0 50%, #f9f9f9 50%) repeat scroll right bottom / 207% 100%;
                    background-position: left bottom;
                    border: 1px solid #e9e6e0;
                    box-shadow:0 3px 3px rgba(0, 0, 0, 0.1);
                }
                .dashboard_nav_item ul li.active a, .dashboard_nav_item ul li:hover a{
                color: #fff;

                }
                .dashboard_nav_item ul li.active:last-child, .dashboard_nav_item ul li:hover:last-child {
                    border-bottom: 0px;
                }
                #dashboard_listing_blcok {
                    display: block;
                    margin-bottom: 30px;
                }
                #dashboard_listing_blcok .statusbox {
                    background: #fcfcfc;
                    padding: 0;
                    margin-bottom: 30px;
                    box-shadow: 0 1px 10px rgba(0, 0, 0, 0.1);
                    border-radius: 6px;
                    border: 1px solid #e9e6e0;
                }
                #dashboard_listing_blcok .statusbox h3 {
                    font-family:'Poppins', sans-serif;
                    background:rgba(0, 0, 0, 0.04);
                    border-radius:4px 4px 0 0;
                    padding: 10px;
                    text-align: center;
                    font-size: 16px;
                    font-weight: 500;
                    color: rgba(54, 54, 54, 0.7);
                    text-transform: capitalize;
                    height: 50px;
                    vertical-align: middle;
                    line-height: 16px;
                    margin: 0;
                    border-bottom: 1px solid #e9e6e0;
                }
                #dashboard_listing_blcok .statusbox-content {
                    padding: 25px 0;
                    text-align: center;
                }
                #dashboard_listing_blcok .statusbox .statusbox-content .ic_status_item {
                    display: inline-block;
                    text-align: center;
                    margin: 0 auto 15px auto;
                }
                #dashboard_listing_blcok .statusbox .statusbox-content .ic_status_item i {
                    border-radius: 50px;
                    font-size: 30px;
                    height: 90px;
                    line-height: 90px;
                    text-align: center;
                    vertical-align: middle;
                    width: 90px;
                    box-shadow: 0 0px 7px rgba(0, 0, 0, 0.08);
                }
                #dashboard_listing_blcok .statusbox .statusbox-content .ic_col_one i {
                    background: #d5f6fd;
                    border: 2px solid #0e8bcb;
                    color: #0e8bcb;
                }
                #dashboard_listing_blcok .statusbox .statusbox-content .ic_col_two i {
                    background: #ffe2ec;
                    border: 2px solid #fd6b9c;
                    color: #fd6b9c;
                }
                #dashboard_listing_blcok .statusbox .statusbox-content .ic_col_three i {
                    background: #e3e0f3;
                    border: 2px solid #7264bc;
                    color: #7264bc;
                }
                #dashboard_listing_blcok .statusbox .statusbox-content .ic_col_four i {
                    background: #e7f4e0;
                    border: 2px solid #81c860;
                    color: #81c860;
                }
                #dashboard_listing_blcok .statusbox-content h2 {
                    font-family:'Open Sans', sans-serif;
                    color:#6e6e6e;
                    display: block;
                    font-size: 26px;
                    font-weight: 600;
                    margin: 0;
                }
                #dashboard_listing_blcok .statusbox-content span {
                    color: rgba(54, 54, 54, 0.6);
                    display: block;
                    font-size: 13px;
                    font-weight: 500;
                    margin-top: 10px;
                    padding: 0 5px;
                }
                .submit_listing_box {
                    background: #f9f9f9;
                    padding: 20px;
                    border: 1px solid #e9e6e0;
                    border-radius: 4px;
                    margin-bottom: 25px;
                    box-shadow:0 3px 3px rgba(0, 0, 0, 0.1);
                }
                .submit_listing_box h3 {
                    padding-bottom: 25px;
                    margin-top: 10px;
                    margin-bottom: 20px;
                    border-bottom: 1px solid #e9e6e0;
                    font-size: 18px;
                    font-weight: 500;
                    text-align: left;
                    color: #4a4a4a;
                }
                .submit_listing_box .form-alt label {
                    display: block;
                    text-align: left;
                    margin-bottom: 8px;
                    color: #696969;
                    font-size: 14px;
                    font-weight: 500;
                }
                .submit_listing_box .form-alt label span {
                    color: #ff0000;
                }
                .submit_listing_box .btn_change_pass {
                    margin: 10px auto;
                    text-align: center;
                    display: inline-block;
                }
                .submit_listing_box .form-alt input {
                    background-color: #fff;
                    border: 0 none;
                    border-radius: 4px;
                    color: #9d9795;
                    height: 44px;
                    border: 1px solid #e9e6e0;
                    font-size: 14px;
                    font-weight: 400;
                    line-height: 22px;
                    padding: 10px;
                    box-shadow: none;
                }
                .submit_listing_box .form-alt textarea {
                    background-color: #fff;
                    border: 0 none;
                    border-radius: 4px;
                    color: #535353;
                    border: 1px solid #e9e6e0;
                    font-size: 14px;
                    font-weight: 400;
                    height: auto;
                    padding: 10px;
                    box-shadow: none;
                }
                .submit_listing_box .form-group:last-child {
                    margin-bottom: 0;
                }
                .submit_listing_box .form-alt input:focus {
                    border-color: #4064A0;
                    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px rgba(102, 175, 233, 0.6);
                    outline: 0 none;
                }
                .submit_listing_box .form-alt textarea:focus {
                    border-color: #4064A0;
                    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px rgba(102, 175, 233, 0.6);
                    outline: 0 none;
                }
                .submit_listing_box select.selectcategory {
                    background: #ffffff url('assets/images/slt_btn_cat.png') no-repeat scroll right 15px top 50%;
                    color: #999999;
                    height: 44px;
                    border: 1px solid #e9e6e0;
                    box-shadow: none;
                    font-size: 14px;
                    font-weight: 400;
                }
                .submit_listing_box select.selectcategory option {
                    padding: 8px 15px;
                    border-bottom: 1px solid #e9e6e0;
                    font-size: 14px;
                    font-weight: 400;
                }
                #location-map {
                    display: block;
                    margin-top: 10px;
                }
                #location-map iframe{
                    width:100%;
                    height:320px;
                    border:0;
                }
                #location-map .map_view_location {
                    cursor: pointer;
                    min-height: 300px;
                    width: 100%;
                }
                .fileupload_block {
                    border: 1px solid #c8d1d3;
                    border-radius: 2px;
                    float: left;
                    margin-bottom: 15px;
                    padding: 10px;
                    width: 100%;
                }
                .fileupload_block #fileupload {
                    float: left;
                    margin-top: 6%;
                }
                .fileupload_img {
                    display: inline-block;
                    float: left;
                    margin-top: 0;
                }
                .fileupload_img img {
                    display: inline-block;
                    height: 120px;
                    width: 120px;
                    border-radius: 60px;
                }
                .submit_listing_box .amenities_block {
                    display: block;
                }
                .submit_listing_box ul.detail-amenities {
                    list-style-type: none;
                }
                .amenities_block .detail-amenities li {
                    display: inline-block;
                    font-size: 14px;
                    line-height: 2.4;
                    margin-right: 15px;
                    width: 30%;
                    text-align: left;
                    float: left;
                }
                .checkbox {
                    padding-left: 25px;
                    margin-top: 5px;
                    margin-bottom: 5px;
                }
                .checkbox label {
                    font-weight:500;
                    color:#696969;
                    display: inline-block;
                    line-height: 20px;
                    padding-left: 10px;
                    position: relative;
                    vertical-align: middle;
                }
                input[type='checkbox'] {
                    line-height: normal;
                    margin: 12px 0 0;
                }
                .checkbox label::before {
                    background-color: #ffffff;
                    border: 1px solid #e0dcd1;
                    border-radius:20px;
                    content: '';
                    outline:0;
                    display: inline-block;
                    height: 20px;
                    left: 0;
                    margin-left: -23px;
                    position: absolute;
                    transition: border 0.15s ease-in-out 0s, color 0.15s ease-in-out 0s;
                    width: 20px;
                }
                .checkbox label::after {
                    color: #555;
                    display: inline-block;
                    font-size: 11px;
                    height: 20px;
                    left: 0;
                    margin-left: -23px;
                    margin-top: 0;
                    padding-left: 5px;
                    padding-top: 0;
                    position: absolute;
                    top: 0;
                    width: 20px;
                }
                .checkbox input[type='checkbox'], .checkbox input[type='radio'] {
                    cursor: pointer;
                    opacity: 0;
                    z-index: 1;
                }
                .checkbox input[type='checkbox']:focus + label::before, .checkbox input[type='radio']:focus + label::before {
                    outline: thin dotted;
                    outline-offset: -2px;
                }
                .checkbox input[type='checkbox']:checked + label::after, .checkbox input[type='radio']:checked + label::after {
                    content: 'ï€Œ';
                    font-family:'FontAwesome';
                }
                .checkbox input[type='checkbox']:disabled + label, .checkbox input[type='radio']:disabled + label {
                    opacity: 0.65;
                }
                .checkbox input[type='checkbox']:disabled + label::before, .checkbox input[type='radio']:disabled + label::before {
                    background-color: #eee;
                    cursor: not-allowed;
                }
                .checkbox.checkbox-circle label::before {
                    border-radius: 50%;
                }
                .checkbox.checkbox-inline {
                    margin-top: 0;
                }
                .checkbox-success input[type='checkbox']:checked + label::before, .checkbox-success input[type='radio']:checked + label::before {
                    background-color: #01273a;
                    border-color: #01273a;
                }
                .checkbox-success input[type='checkbox']:checked + label::after, .checkbox-success input[type='radio']:checked + label::after {
                    color: #fff;
                }
                .tg-listing {
                    float: left;
                    padding: 0;
                    width: 100%;
                    text-align:left;
                }
                .tg-listing-head {
                    background:#01273a;
                    color: #fff;
                    float: left;
                    padding:0px 10px;
                    text-transform: uppercase;
                    width: 100%;
                }
                .tg-listing-head .tg-titlebox {
                    border-right: 1px solid rgba(255, 255, 255, 0.3);
                    float: left;
                    padding: 20px 10px;
                    width: 38.33%;
                }
                .tg-listing-head .tg-titlebox:last-child{
                    border-right:0px;
                }
                .tg-listing-head .tg-titlebox h3 {
                    font-family:'Poppins', sans-serif;
                    color: #fff;
                    font-size: 18px;
                    line-height: 18px;
                    margin: 0;
                    font-weight:500;
                }
                .tg-list .tg-listbox + .tg-listbox, .tg-listing-head .tg-titlebox + .tg-titlebox {
                    width: 22%;
                }
                .tg-pluck {
                    float: left;
                    width: 100%;
                    margin-bottom:20px;
                }
                .tg-list:nth-child(2n+1) {
                    background: #f3f3f3;
                }
                .tg-list {
                    float: left;
                    padding:10px;
                    width: 100%;
                    background:#ebebeb;
                }
                .tg-listbox .tg-listdata {
                    overflow: hidden;
                    padding-top:3px;
                }
                .tg-listbox .tg-listdata h4 {
                    font-size: 16px;
                    line-height: 16px;
                    margin: 0 0 10px;
                    text-transform: uppercase;
                }
                .tg-list .tg-listbox {
                    float: left;
                    padding:6px 10px;
                    width: 38.33%;
                }
                .tg-list .tg-listbox + .tg-listbox, .tg-listing-head .tg-titlebox + .tg-titlebox {
                    width: 22%;
                }
                .tg-list .tg-listbox:last-child, .tg-listing .tg-titlebox:last-child{
                    width: 14.5%;
                }
                .tg-listbox span {
                    font-family:'Poppins', sans-serif;
                    font-size:14px;
                    display: block;
                }
                .list_user_thu{
                    border:1px solid #c7c5d2;
                    float: left;
                    margin: 0 15px 0 0;
                    border-radius:50px;
                    padding:4px;
                }
                .list_user_thu img{
                    width:75px;
                    height:75px;
                    border-radius:50px;
                }
                .tg-btn-list {
                    background:#01273a;
                    color: #fff;
                    float: left;
                    box-shadow:0 1px 7px rgba(0, 0, 0, 0.1);
                    line-height: 40px;
                    text-align: center;
                    width: 40px;
                    border-radius:30px;
                }
                a.tg-btn-list:hover, a.tg-btn-list:focus{
                    background:#4064A0;
                    box-shadow:0 4px 5px rgba(0, 0, 0, 0.3);
                    color:#373542;
                }
                .tg-listbox .tg-btn-list + .tg-btn-list {
                    margin: 0 0 0 10px;
                }
                .tg-listdata h4 a{
                    font-family:'Poppins', sans-serif;
                    color:#4e4e4e;
                    font-weight:600;
                    font-size:18px;
                    text-transform:uppercase;
                }
                .tg-listdata h4 a:hover{
                    color:#4064A0;
                }
                .tg-listbox .tg-listdata span, .tg-listbox .tg-listdata time{
                    font-family:'Poppins', sans-serif;
                    font-size:14px;
                    color:#6f6f6f;
                }
                @media(min-width:768px) and (max-width:1199px){
                .tg-list .tg-listbox::after {
                    background:#01273a;
                    color: #fff;
                    content: attr(data-title);
                    font-family:'Poppins', sans-serif;
                    font-size: 18px;
                    height: 100%;
                    left: 0;
                    line-height: 102px;
                    padding: 0 15px;
                    position: absolute;
                    text-transform: uppercase;
                    top: 0;
                    width: 46%;
                }
                .tg-list .tg-listbox:nth-child(2)::after {
                    content: attr(data-viewed);
                    line-height: 50px;
                }
                .tg-list .tg-listbox:nth-child(3)::after {
                    content: attr(data-favorites);
                    line-height: 40px;
                }
                .tg-list .tg-listbox:nth-child(4)::after {
                    content: attr(data-action);
                    line-height: 40px;
                }
                .tg-listing-head {
                    display:none;
                }
                .tg-list .tg-listbox + .tg-listbox, .tg-list .tg-listbox {
                    padding: 15px 15px 15px 50%;
                    position: relative;
                    width: 100%;
                }
                .tg-listing-head {
                    background: #373542 none repeat scroll 0 0;
                    color: #fff;
                    float: left;
                    padding: 15px;
                    text-transform: uppercase;
                    width: 100%;
                }
                }
                @media (max-width:767px){
                .tg-list .tg-listbox::after {
                    background: #01273a;
                    color: #fff;
                    content: attr(data-title);
                    font-family:'Poppins', sans-serif;
                    font-size: 18px;
                    height: 100%;
                    left: 0;
                    line-height: 102px;
                    padding: 0 15px;
                    position: absolute;
                    text-transform: uppercase;
                    top: 0;
                    width: 46%;
                }
                .affix{
                    position: static;   
                }
                .tg-list .tg-listbox:nth-child(2)::after {
                    content: attr(data-viewed);
                    line-height: 50px;
                }
                .tg-list .tg-listbox:nth-child(3)::after {
                    content: attr(data-favorites);
                    line-height: 40px;
                }
                .tg-list .tg-listbox:nth-child(4)::after {
                    content: attr(data-action);
                    line-height: 40px;
                }
                .tg-listing-head {
                    display:none;
                }
                .tg-list .tg-listbox + .tg-listbox, .tg-list .tg-listbox {
                    padding: 15px 15px 15px 50%;
                    position: relative;
                    width: 100%;
                }
                .tg-listing-head {
                    background: #373542 none repeat scroll 0 0;
                    color: #fff;
                    float: left;
                    padding: 15px;
                    text-transform: uppercase;
                    width: 100%;
                }
                }
                @media (max-width:480px){
                .tg-list .tg-listbox::after {
                    font-size: 14px;
                    height: 100%;
                    padding: 0 7px;
                    width: 34%;
                }
                .tg-list .tg-listbox + .tg-listbox, .tg-list .tg-listbox {
                    padding: 15px 15px 15px 36%;
                    position: relative;
                    width: 100%;
                }
                .tg-listbox span {
                    display: inline-block;
                    float: none;
                    margin: 0 auto 15px 0;
                    text-align: left;
                }
                }
                /************************************ error page **************************************/
                div.error-page-alt {
                    background:#ffffff url(assets/images/error-page-bg.jpg);
                    background-position: 50% 50%;
                    background-repeat: no-repeat;
                    background-size: cover;
                    padding: 7rem 0;
                    position: relative;
                    z-index: 0;
                }
                .f-title-error span {
                    color: #01273a;
                    font-size: 13.0769em;
                    line-height: 0.76471;
                }
                .b-title-error span, .b-title-error strong {
                    display: block;
                    text-align: center;
                }
                .f-title-error strong {
                    color: #f9ca40;
                    font-size: 44px;
                    font-weight: 400;
                    margin-top: 10px;
                }
                .f-error-description span, .f-error-description strong {
                    color: #6d7a83;
                }
                .f-error-description strong {
                    font-size: 22px;
                    font-weight: 600;
                    line-height: 1.2;
                    margin-bottom: 10px;
                }
                .f-title-error .f-primary-eb {
                    font-family:'Open Sans', sans-serif;
                    font-weight:800;
                }
                .f-error-description span, .f-error-description strong {
                    color: #6d7a83;
                }
                .f-error-description span {
                    font-size: 14px;
                    line-height:22px;
                }
                .b-error-search .b-input-search {
                    padding-right: 40px;
                }
                .b-form-row, .b-form-row--big {
                    margin-bottom: 10px;
                }
                .b-error-description {
                    margin: 20px 0 0;
                }
                .b-error-description span, .b-error-description strong {
                    display: block;
                    text-align: center;
                }
                .b-error-search .form-control {
                    background-color: #fff;
                    background-image: none;
                    border: 1px solid #d3dadc;
                    border-radius: 4px;
                    color: #666;
                    box-shadow: 3px 4px 8px rgba(0, 0, 0, 0.14);
                    display: block;
                    font-size: 14px;
                    height: 42px;
                    line-height: 42px;
                    padding: 6px 12px;
                    width: 100%;
                }
                .b-error-search {
                    margin: 40px auto 0;
                    max-width: 375px;
                }
                .b-error-search .b-btn-search {
                    height: 42px;
                    width: 44px;
                }
                .b-error-search .f-btn-search {
                    font-size: 18px;
                    line-height: 26px;
                }
                .b-form-row .b-btn {
                    background: #01273a none repeat scroll 0 0;
                    cursor: pointer;
                    display: inline-block;
                    padding: 8px 14px;
                }
                .b-input-search {
                    padding-right: 47px;
                    position: relative;
                }
                .b-btn-search {
                    color: #f9ca40;
                    font-size: 1.07692em;
                    line-height: 2.42857;
                    text-align: center;
                    border-radius: 2px 4px 4px 2px;
                    position: absolute;
                    right: 0;
                    top: 0;
                    width: 34px;
                }

                @import url(http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800);
                @import url('https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900');

                /* --------------------------------------
                Table Of  Content

                1) Header
                2) Logo & Navbar Section
                3) Search Section
                4) Form Overlay
                5) Inner Categories Search Box
                6) Main Banner
                7) Banner Map
                8) Search Categories
                9) Feature Listing
                10) Tags
                11) Recent Listings
                12) Vfx Counter Block
                13) Pricing Plan
                14) Listing Product
                15) Breadcrum
                16) Footer Block
                17) About Company
                18) Featured Service Block
                19) Login Forms and Register Form Style
                20) Reviews Section
                21) Contact Section
                22) Listing Section
                23) Add Listings
                24) Right Side Bar
                25) User Dashboard
                26) Error Page 

                ---------------------------------------------- */

                body {
                    font-family: 'Raleway', sans-serif;
                    font-size: 15px;
                    position: relative;
                    -webkit-transition: left .5s ease-out;
                    -o-transition: left .5s ease-out;
                    transition: left .5s ease-out
                }
                img {
                    max-width: 100%;
                }
                * {
                    margin: 0px;
                    padding: 0px;
                }
                a {
                    text-decoration: none !important;
                    outline: 0 !important;
                }
                .nopadding-right {
                    padding-right: 0px;
                }
                .nopadding-left {
                    padding-left: 0px;
                }
                .nopadding {
                    padding: 0px;
                }
                .affix-top {
                    position: static;
                    width: 265px !important;
                }
                button {
                    outline: none;
                }
                button:hover, button:active, button:focus {
                    outline: none;
                }
                .affix {
                    position: fixed !important;
                    top: 20px;
                    width: 265px !important;
                }
                option {
                    padding-left: 15px;
                }
                .v-center {
                    -moz-box-direction: normal;
                    -moz-box-orient: vertical;
                    -moz-box-pack: center;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                }
                #location-search-list option {
                    border-bottom: 1px solid #c2c2c2;
                    padding: 7px 15px;
                    font-size: 14px;
                }
                #location-search-list option:last-child {
                    border-bottom: 0;
                }
                .fixed {
                    position: fixed;
                }
                #vfx_loader_block {
                    background: #ffffff;
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    z-index: 99999;
                }
                .vfx-loader-item {
                    margin: 0 auto;
                    position: relative;
                    top: 50%;
                    width: 100px;
                }
                /***************************** placeholder color ********************/
                .form-control::-webkit-input-placeholder {
                    color:#969595;
                }
                .form-control:-moz-placeholder { /* dispatchfox 18- */
                    color:#969595;
                }
                .form-control::-moz-placeholder {  /* dispatchfox 19+ */
                    color:#969595;
                }
                .form-control:-ms-input-placeholder {
                    color:#969595;
                }
                /*********************************** Header ********************************/
                #header {
                    background: #262626;
                    padding: 15px 0px;
                    border-bottom: 2px solid #686868;
                    line-height: 15px;
                }
                #left-header h1 {
                    font-size: 14px;
                    color: #ffffff;
                    margin: 0px;
                    font-weight: normal;
                }
                #left-header h1 a, #left-header h1 span {
                    font-weight: 500;
                    color: #ffffff;
                }
                #left-header h1 br {
                    display: none !important;
                }
                #left-header h1 a:hover {
                    color: $color;
                }
                #right-header h1 {
                    font-size: 14px;
                    color: #ffffff;
                    margin: 0px;
                    display: inline-block;
                    margin-right: 12px;
                }
                #right-header a {
                    color: #ffffff;
                    padding-left: 18px;
                }
                #right-header a i.fa {
                    transition: all 0.2s ease 0s;
                }
                #right-header a:hover {
                    color: $color;
                }
                #right-header a:hover i.fa {
                    transform: scale(1.2);
                }
                /************************** logo & navbar section **************************/
                #logo-header {
                    background: #ffffff;
                    padding: 0;
                    height: 94px;
                    line-height: 55px;
                    box-shadow: 0 1px 8px 0 rgba(0, 0, 0, 0.2);
                }
                #logo {
                    width: 100%;
                    height: auto;
                    padding: 17px 0;
                }
                #logo img {
                    max-width: 80%;
                    height: auto
                }
                #nav_menu_list {
                    padding: 0;
                }
                #nav_menu_list ul {
                    line-height: 88px;
                    margin-bottom: 0;
                }
                #nav_menu_list ul li {
                    list-style-type: none;
                    display: inline-block;
                }


                #nav_menu_list ul li a {
                    font-family: 'Open Sans', sans-serif;
                    color: #262626;
                    font-size: 14px;
                    text-transform: none;
                    font-weight: 600;
                    margin-bottom: 5px;
                    padding: 10px 14px; 
                    -webkit-transition: all 0.3s ease 0s;
                    -moz-transition: all 0.3s ease 0s;
                    -o-transition: all 0.3s ease 0s;
                    transition: all 0.3s ease 0s;
                }
                #nav_menu_list ul li a:last-child {
                    margin-right: 0
                }
                .btn_item li a{
                    color: $color !important;
                    background-color: rgba(255, 255, 255, 0.1);
                    border: 1px solid $color;
                    padding: 10px 15px;
                    margin-right: 0px;
                    text-transform: uppercase;
                    font-size: 18px;
                    border-radius: 4px;
                }
                .btn_item li a:hover{

                background: $color !important;
                color: #fff !important;
                }

                #nav_menu_list li.active {
                    border-bottom: 5px solid $color;
                    color:$color;
                }
                #nav_menu_list li.active a {
                    margin-bottom: 0px;
                }
                #nav_menu_list li a:hover {
                    color: $color;
                    background: transparent;
                }
                #nav_menu_list span.btn_item button.btn_login, #nav_menu_list span.btn_item button.btn_register {
                    font-family: 'Open Sans', sans-serif;
                    background: transparent linear-gradient(to right, #262626 50%, $color 50%) repeat scroll right bottom / 207% 100%;
                    border: 0 none;
                    border-radius: 4px;
                    color: #3d3d3d;
                    font-size: 14px;
                    font-weight: 700;
                    height: 34px;
                    line-height: 18px;
                    padding: 8px 15px;
                    margin-left: 5px;
                    -webkit-transition: all .6s ease 0;
                    transition: all .6s ease 0;
                    text-transform: uppercase;
                    transition: all 0.3s ease 0s;
                    text-transform: uppercase;
                    vertical-align: middle;
                }
                #nav_menu_list span.btn_item button.btn_login:hover, #nav_menu_list span.btn_item button.btn_register:hover {
                    background-position: left bottom;
                    color: #ffffff;
                }
                .navbar {
                    border: none;
                    position: relative;
                    margin-bottom: 0px;
                    min-height: auto;
                }
                .navbar-default {
                    background-color: transparent;
                    border: none;
                }
                .navbar-collapse {
                    padding: 0px;
                }
                .navbar-toggle {
                    margin-top: 4px;
                    background: $color;
                    border-color: $color !important;
                }
                .navbar-default .navbar-toggle .icon-bar {
                    background-color: #ffffff;
                }
                .navbar-default .navbar-toggle:focus, .navbar-default .navbar-toggle:hover {
                    background-color: $color;
                    border-color: $color;
                }
                /************************ search section **************************/
                #search-section {
                    background: $color;
                    padding: 20px 0px;
                }
                #categorie-search-form {
                    float: left;
                    width: 100%;
                }
                form#categorie-search-form h1 {
                    font-family: 'Open Sans', sans-serif;
                    margin-bottom: 20px;
                    font-size: 26px;
                    letter-spacing: 0.5px;
                    font-weight:600;
                    text-transform: uppercase;
                    color: #ffffff;
                }
                #search-input .form-group {
                    margin-bottom: 0px;
                }
                select#location-search-list {
                    box-shadow: 3px 4px 8px rgba(0, 0, 0, 0.14) inset;
                }
                input.form-control {
                    box-shadow: 3px 4px 8px rgba(0, 0, 0, 0.14) inset;
                }
                #search-input .form-control {
                    font-family: 'Open Sans', sans-serif;
                    height: 50px;
                    border: none;
                    font-size: 15px;
                    font-weight: 500;
                }
                #search-input select, select {
                    -moz-appearance: none;
                    -webkit-appearance: none;
                    appearance: none;
                }
                #search-input select.form-control {
                    font-family: 'Open Sans', sans-serif;
                    border-top-right-radius: 0px;
                    border-bottom-right-radius: 0px;
                    border-right: 1px solid #c2c2c2;
                    color: #6f6f6f;
                    background: #ffffff url(assets/images/slt_btn_cat.png) top 50% right 15px no-repeat;
                    padding-left: 15px;
                }
                #search-input input.form-control {
                    border-top-left-radius: 0px;
                    border-bottom-left-radius: 0px;
                    padding-left: 15px;
                    color: #c2c2c2;
                }
                #location-search-btn button {
                    font-family: 'Open Sans', sans-serif;
                    background: -webkit-linear-gradient(left, #ffffff 50%, $color 50%) repeat scroll right bottom/207% 100% transparent;
                    background: linear-gradient(to right, #ffffff 50%, $color 50%) repeat scroll right bottom/207% 100% transparent;
                    color: #01273a;
                    padding: 14px;
                    font-size: 15px;
                    border: none;
                    font-weight: 600;
                    text-transform: uppercase;
                    border-radius: 4px;
                    -webkit-transition: background 350ms ease-in-out;
                    transition: background 350ms ease-in-out;
                    width: 100%;
                    outline: 0 !important;
                }
                #location-search-btn button i.fa {
                    margin-right: 5px;
                }
                #location-search-btn button:hover {
                    background-position: left bottom;
                    color: #262626;
                }
                /****************** form overlay *****************/
                .formOverlay:before {
                    content: '\f110';
                    font-family: fontawesome;
                    -webkit-animation: fa-spin 1s infinite steps(8);
                    animation: fa-spin 1s infinite steps(8);
                    color: $color;
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    font-size: 56px;
                    margin-top: -25px;
                    margin-left: -25px;
                }
                .formOverlay {
                    background: transparent;
                    display: block;
                    height: 100%;
                    left: 0;
                    position: absolute;
                    top: 0;
                    width: 100%;
                    z-index: 9999;
                }
                .alert .message-icon {
                    margin-right: 10px;
                    width: 30px;
                    height: 30px;
                    text-align: center;
                    border: 1px solid #9F9F9F;
                    border-radius: 50%;
                    line-height: 30px;
                }
                .white_bg_block {
                    background: #f2f2f2 !important;
                }
                /************************ inner categories search box **************************/
                #vfx-search-item-inner {
                    padding: 70px 0 70px 0px;
                    background: url(assets/images/inner_search_bg.png) center center no-repeat;
                    background-size: cover;
                    background-attachment: fixed;
                    background-size: 100% 100%;
                    border-bottom: 1px solid #e4e4e4;
                }
                #vfx-search-box .form-group {
                    margin-bottom: 0px;
                }
                .vfx-search-categorie-title {
                    margin-bottom: 30px;
                }
                .vfx-search-categorie-title h1 {
                    font-family: 'Raleway', sans-serif;
                    margin: 0px;
                    color: #01273a;
                    text-transform: uppercase;
                    font-weight: 700;
                    font-size: 28px;
                }
                .vfx-search-categorie-title h1 span {
                    color: $color;
                }
                select#location-search-list {
                    box-shadow: 3px 4px 8px rgba(0, 0, 0, 0.14) inset;
                }
                input.form-control {
                    box-shadow: 3px 4px 8px rgba(0, 0, 0, 0.14) inset;
                }
                #vfx-search-box .form-control {
                    height: 50px;
                    border: none;
                    font-size: 15px;
                }
                #vfx-search-box select, select {
                    -moz-appearance: none;
                    -webkit-appearance: none;
                    appearance: none;
                }
                #vfx-search-box select option {
                    border-bottom: 1px solid #c2c2c2;
                    font-size: 14px;
                    padding: 7px 15px;
                }
                #vfx-search-box select.form-control {
                    font-family: 'Open Sans', sans-serif;
                    border-top-right-radius: 0px;
                    border-bottom-right-radius: 0px;
                    border-right: 1px solid #c2c2c2;
                    color: #6f6f6f;
                    background: #ffffff url('assets/images/slt_btn_cat.png') top 50% right 15px no-repeat;
                    padding-left: 15px;
                    box-shadow: 0px 5px 1px rgba(0, 0, 0, 0.3);
                    border: 1px solid #b4b4b4;
                }
                #vfx-search-box input.form-control {
                    font-family: 'Open Sans', sans-serif;
                    border-top-left-radius: 0px;
                    border-bottom-left-radius: 0px;
                    padding-left: 15px;
                    color: #c2c2c2;
                    box-shadow: 0px 5px 1px rgba(0, 0, 0, 0.3);
                    border: 1px solid #b4b4b4;
                    border-left: 0px;
                }
                #vfx-search-btn button {
                    font-family: 'Open Sans', sans-serif;
                    background: -webkit-linear-gradient(left, #01273a 50%, $color 50%) repeat scroll right bottom/207% 100% transparent;
                    background: linear-gradient(to right, #01273a 50%, $color 50%) repeat scroll right bottom/207% 100% transparent;
                    color: #01273a;
                    padding: 14px;
                    font-size: 15px;
                    border: none;
                    font-weight: 600;
                    text-transform: uppercase;
                    border-radius: 4px;
                    -webkit-transition: background 350ms ease-in-out;
                    transition: background 350ms ease-in-out;
                    width: 100%;
                    outline: 0 !important;
                    box-shadow: 0px 5px 1px rgba(0, 0, 0, 0.3);
                }
                #vfx-search-btn button i.fa {
                    margin-right: 5px;
                }
                #vfx-search-btn button:hover {
                    background-position: left bottom;
                    color: $color;
                }
                /******************* main banner *****************************/
                #slider-banner-section {
                    background: url(assets/images/banner.jpg) top left no-repeat;
                    background-size: cover;
                    background-attachment: fixed;
                    border-bottom: 7px solid $color;
                }
                #location_slider_item_block {
                    text-align: center;
                }
                #location_slider_item_block button {
                    background: $color;
                    display: inline-block;
                    width: 80px;
                    height: 40px;
                    border: none;
                    border-radius: 50px 50px 0 0;
                    left: 0;
                    bottom: 0;
                    margin: 0 auto;
                    position: absolute;
                    right: 0;
                }
                #location_slider_item_block button i.fa {
                    color: #01273a;
                    font-size: 30px;
                    position: relative;
                    bottom: -3px;
                }
                #home-slider-item {
                    padding-top: 100px;
                }
                #home-slider-item span.helpyou_item {
                    font-family: 'Open Sans', sans-serif;
                    color: #ffffff;
                    margin-bottom: 20px;
                    font-size: 36px;
                    line-height: 36px;
                    font-weight: 700;
                    display: block;
                    text-transform: uppercase;
                    letter-spacing: 2px;
                    text-align: center;
                }
                #home-slider-item span.helpyou_item span {
                    color: $color;
                }
                #home-slider-item h1 {
                    font-family: 'Open Sans', sans-serif;
                    font-size: 54px;
                    color: #ffffff;
                    margin: 0px;
                    font-weight: 800;
                    letter-spacing: 1.6px;
                    text-transform: uppercase;
                }
                #home-slider-item h1 span {
                    color: $color;
                }
                #home-slider-item p {
                    font-family: 'Open Sans', sans-serif;
                    font-size: 26px;
                    color: #ffffff;
                    margin: 20px 0px 0px;
                    letter-spacing: 1px;
                    text-transform: uppercase;
                    line-height: 30px;
                    font-weight: 600;
                }
                #search-categorie-item-block {
                    margin: 68px 0px 124px;
                    float: left;
                    width: 100%;
                }
                #search-categorie-item-block h1 {
                    font-size: 28px;
                    font-weight: 700;
                    color: $color;
                    margin: 0px;
                    text-transform: uppercase;
                }
                /********************** banner map **********************/
                #location-map-block {
                    border-bottom: 7px solid $color;
                    width: 100%;
                }
                #location-link-item {
                    text-align: center;
                }
                #location-link-item button {
                    position: absolute;
                    left: 0;
                    right: 0;
                    border: none;
                    text-align: center;
                    margin: 0 auto;
                    background: $color;
                    width: 80px;
                    height: 40px;
                    bottom: 0;
                    border-radius: 50px 50px 0px 0px;
                }
                #location-link-item button i.fa {
                    color: #01273a;
                    font-size: 30px;
                    position: relative;
                    top: 2px;
                }
                #map, #location-homemap-block, #locationmap, #contactmap {
                    width: 100%;
                    height: 557px;
                    top: -1px;
                    margin-bottom: -2px;
                    display: inline-block;
                    float: left
                }
                /***************************** search categories *********************/
                #search-categorie-item {
                    background: #FAFAFA url(assets/images/category_bg.png) no-repeat center top;
                    background-position: cover;
                    background-attachment: fixed;
                    background-size: 100% 100%;
                    padding: 80px 0px 60px 0;
                }
                #search-categories-section {
                    padding: 10px 0px 60px;
                    background: #f7f7f7;
                    border-bottom: 2px solid $color;
                }
                #search-categories-section .categories-list {
                    background: #ffffff;
                }
                .categories-heading {
                    margin-bottom: 50px;
                }
                .categories-heading h1 {
                    font-family: 'Raleway', sans-serif;
                    margin: 0px;
                    color: #01273a;
                    text-transform: uppercase;
                    font-weight: 700;
                    font-size: 28px;
                }
                .categories-heading h1 span {
                    color: $color;
                }
                .categorie_item {
                    background: #ffffff;
                    border-radius: 6px;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
                    padding: 20px;
                    margin-bottom: 30px;
                }
                .categorie_item:hover {
                    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.3);
                    -webkit-transform: scale(1.05);
                    transform: scale(1.05);
                    -webkit-transition: ease-out .5s;
                    -moz-transition: ease-out .5s;
                    -o-transition: ease-out .5s;
                    transition: ease-out .5s;
                    transition: all .6s ease-in-out 0;
                }
                .cate_item_block {
                    background: #fcfbfb;
                    border: 1px solid #dcdcdc;
                    border-radius: 6px;
                    text-align: center;
                    padding: 30px 0;
                }
                .cate_item_social {
                    background: $color;
                    border-radius: 50px;
                    color: #ffffff;
                    height: 90px;
                    margin: 0 auto;
                    text-align: center;
                    vertical-align: middle;
                    width: 90px;
                }
                .cate_item_social i {
                    display: block;
                    font-size: 40px;
                    line-height: 90px;
                    text-align: center;
                }
                .cate_item_block h1 {
                    margin-bottom: 0px;
                    font-size: 18px;
                    text-transform: uppercase;
                }
                .cate_item_block h1 a {
                    font-family:'Raleway',sans-serif;
                    color: #4a4a4a;
                    font-weight:600;
                }
                .cate_item_block:hover {
                    background: $color;
                    color: #01273a;
                }
                .categorie_item:hover .cate_item_social i {
                    background: transparent;
                    color: $color;
                    border-radius: 50px;
                    width: 90px;
                    height: 90px;
                    line-height: 90px;
                    -webkit-transition: ease-out .5s;
                    -moz-transition: ease-out .5s;
                    -o-transition: ease-out .5s;
                    transition: ease-out .5s;
                    /*transform: rotate(360deg);*/
                    transition: all .6s ease-in-out 0;  
                }
                .hi-icon {
                    color:#ffffff;
                    display: block;
                    position: relative;
                    text-align: center;
                    z-index: 1
                }
                .hi-icon::after {
                    border-radius: 50%;
                    box-sizing: content-box;
                    content: '';
                    height: 100%;
                    pointer-events: none;
                    position: absolute;
                    width: 100%
                }
                .categorie_item:hover .hi-icon-effect-8 .hi-icon {
                    background: #fff;
                    color: $color;
                    cursor: pointer
                }
                .hi-icon-effect-8 .hi-icon::after {
                    box-shadow: 0 0 0 2px rgba(255,255,255,0.1);
                    left: 0;
                    opacity: 0;
                    padding: 0;
                    top: 0;
                    transform: scale(0.9);
                    z-index: -1
                }
                .no-touch .hi-icon-effect-8 .hi-icon:hover {
                    background: rgba(255,255,255,0.05) none repeat scroll 0 0;
                    color: #fff;
                    transform: scale(0.93)
                }
                .categorie_item:hover .hi-icon-effect-8 .hi-icon::after {
                    animation: 1.3s ease-out 75ms normal none 1 running sonarEffect
                }
                @keyframes sonarEffect {
                 0% {
                opacity:.3
                }
                 40% {
                box-shadow:0 0 0 2px rgba(255,255,255,0.1), 0 0 7px 7px #9a9a9a, 0 0 0 7px rgba(255,255,255,0.1);
                opacity:.5
                }
                 100% {
                box-shadow:0 0 0 2px rgba(255,255,255,0.1), 0 0 7px 7px #9a9a9a, 0 0 0 7px rgba(255,255,255,0.1);
                opacity:0;
                transform:scale(1.5)
                }
                 0% {
                opacity:.3
                }
                 40% {
                box-shadow:0 0 0 2px rgba(255,255,255,0.1), 0 0 7px 7px #9a9a9a, 0 0 0 7px rgba(255,255,255,0.1);
                opacity:.5
                }
                 100% {
                box-shadow:0 0 0 2px rgba(255,255,255,0.1), 0 0 7px 7px #9a9a9a, 0 0 0 7px rgba(255,255,255,0.1);
                opacity:0;
                transform:scale(1.5)
                }
                }
                .bt_heading_3 .line_1 {
                    background-color: #6d6d6d;
                    display: inline-block;
                    height: 1px;
                    vertical-align: middle;
                    width: 60px;
                }
                .bt_heading_3 .icon {
                    color: #35385b;
                    display: inline-block;
                    font-size: 7px;
                    line-height: 4px;
                    margin: 0 3px;
                    vertical-align: middle;
                }
                .bt_heading_3 .line_2 {
                    background-color: #6d6d6d;
                    display: inline-block;
                    height: 1px;
                    vertical-align: middle;
                    width: 60px;
                }
                #search-categories-boxes, .search-categories-box {
                    padding-top: 50px;
                    display: inline-block;
                    width: 100%;
                }
                #search-categories-section #search-categories-boxes, #search-categories-section .search-categories-box {
                    padding-top: 50px;
                    display: inline-block;
                    width: 100%;
                }
                .all-categorie-list-title {
                    margin-bottom: 50px;
                }
                .all-categorie-list-title h1 {
                    font-family: 'Raleway', sans-serif;
                    margin: 0px;
                    color: #01273a;
                    text-transform: uppercase;
                    font-weight: 700;
                    font-size: 28px;
                }
                .all-categorie-list-title h1 span {
                    color: $color;
                }
                .search-categories-boxes {
                    width: 100%;
                    display: inline-block;
                }
                .search-categories-boxes h2 {
                    margin: 0px;
                    padding: 10px 15px;
                    background: $color;
                    font-size: 15px;
                    text-align: left !important;    
                    color: #01273a;
                    font-weight: 600;
                    text-transform: uppercase;
                    height: 42px;
                    line-height: 22px;
                }
                .search-categories-boxes h2 i {
                    margin-right: 5px;
                }
                #all-categorie-item-block {
                    background: #ffffff;
                    padding: 80px 0 60px 0;
                }
                .categories-list {
                    padding: 0px;
                    border: 1px solid #eeeeee;
                    border-top: none;   
                }
                .categorie-list-box {
                    box-shadow: 0 0px 15px rgba(0, 0, 0, 0.1);
                    margin-bottom: 30px;
                    border-radius: 4px;
                }
                .categories-list ul {
                    margin-bottom: 0px;
                }
                .categories-list ul li {
                    text-align: left !important;
                    list-style: none;
                    color: #636363;
                    font-size: 14px;
                    line-height: 35px;
                    padding: 2px 15px;
                    border-bottom: 1px solid #eeeeee;
                    text-transform: capitalize;
                    transition: all 0.5s ease 0s;
                    -webkit-transition: all 0.5s ease 0s;
                    -moz-transition: all 0.5s ease 0s;
                }
                .categories-list ul li:last-child {
                    border-bottom: 0px;
                }
                .categories-list ul li a {
                    font-family: 'Open Sans', sans-serif;
                    color: #696969;
                    font-size: 13px;
                    font-weight: 600;
                }
                .categories-list ul li:hover {
                    padding-left: 20px;
                    transition: all 0.3s ease 0s;
                    -webkit-transition: all 0.3s ease 0s;
                    -moz-transition: all 0.3s ease 0s;
                }
                .categories-list ul li:hover a {
                    color: $color;
                }
                .categories-list ul li a i {
                    margin-right: 5px;
                }
                .categories-list ul li span {
                    font-family: 'Open Sans', sans-serif;
                    color: #898989;
                    font-weight:600;
                    font-size:13px;
                    float: right;
                }
                #categorie-item-search {
                    padding-top: 30px;
                    display: inline-block;
                    width: 100%;
                }
                .categorie-item-search {
                    display: inline-block;
                    width: 100%;
                }
                .categorie-item-search h2 {
                    margin: 0px;
                    padding: 10px 15px;
                    background: $color;
                    font-size: 16px;
                    text-align: left !important;
                    border-top-left-radius: 4px;
                    border-top-right-radius: 4px;
                    color: #ffffff;
                    text-transform: capitalize;
                    height: 42px;
                }
                .categorie-item-search h2 img {
                    margin-right: 5px;
                }
                .categories-list1 {
                    padding: 15px;
                    border: 1px solid #e8e8e8;
                    border-top: none;
                    border-bottom-left-radius: 4px;
                    border-bottom-right-radius: 4px;
                }
                .categories-list1 ul {
                    margin-bottom: 0px;
                }
                .categories-list1 ul li {
                    text-align: left !important;
                    list-style: none;
                    color: #636363;
                    font-size: 14px;
                    line-height: 35px;
                    text-transform: capitalize;
                    transition: all 0.3s ease 0s;
                    -webkit-transition: all 0.3s ease 0s;
                    -moz-transition: all 0.3s ease 0s;
                }
                .categories-list1 ul li a {
                    color: #636363;
                }
                .categories-list1 ul li:hover {
                    padding-left: 3px;
                }
                .categories-list1 ul li:hover a {
                    color: $color;
                }
                .categories-list1 ul li::before {
                    content: '';
                    font-family: fontawesome;
                    font-size: 10px !important;
                    margin-right: 10px;
                    color: $color;
                }
                .categories-list1 ul li span {
                    float: right;
                }
                #search-categorie-item button {
                    background: -webkit-linear-gradient(left, #262626 50%, $color 50%) repeat scroll right bottom/207% 100% transparent;
                    background: linear-gradient(to right, #262626 50%, $color 50%) repeat scroll right bottom/207% 100% transparent;
                    border: none;
                    padding: 10px 30px;
                    border-radius: 4px;
                    color: #ffffff;
                    margin-top: 60px;
                    font-size: 16px;
                    -webkit-transition: all 0.3s ease 0s;
                    -moz-transition: all 0.3s ease 0s;
                    -o-transition: all 0.3s ease 0s;
                    transition: all 0.3s ease 0s;
                    width: 100%;
                    outline: 0 !important;
                }
                #search-categorie-item button:hover {
                    background-position: left bottom;
                }
                #search-categorie-item button i.fa {
                    margin-right: 5px;
                }
                /************************* feature listing ************************/
                .feature-item-listing-heading {
                    margin-bottom: 50px;
                }
                .feature-item-listing-heading h1 {
                    font-family: 'Raleway', sans-serif;
                    margin: 0px;
                    color: #01273a;
                    text-transform: uppercase;
                    font-weight: 700;
                    font-size: 28px;
                }
                .feature-item-listing-heading h1 span {
                    color: $color;
                }
                #feature-item_listing_block {
                    background: #ffffff;
                    padding: 80px 0px 60px 0;
                }
                #feature-item-listing-heading h1 {
                    margin: 0px;
                    color: #242424;
                    text-transform: uppercase;
                    font-weight: 700;
                    font-size: 28px;
                }
                #feature-item-listing-heading h1 span {
                    padding: 0px 30px;
                }
                #feature-item-listing-heading h1 span::after {
                    border-right: 3px solid $color;
                    content: '';
                    height: 30px;
                    margin-left: 20px;
                    width: 3px;
                    position: relative;
                    top: 5px;
                }
                #feature-item-listing-heading h1 span::before {
                    border-left: 3px solid $color;
                    bottom: 5px;
                    content: '';
                    height: 30px;
                    margin-right: 20px;
                    position: relative;
                    width: 3px;
                }
                .feature-box {
                    padding-top: 60px;
                    width: 100%;
                    position: relative;
                    display: inline-block;
                }
                #feature-box1, .feature-box1 {
                    padding-top: 50px;
                    width: 100%;
                    position: relative;
                    display: inline-block;
                }
                .feature-item-container-box {
                    border: 1px solid #efeeee;
                    -webkit-transition: all 0.3s ease 0s;
                    -moz-transition: all 0.3s ease 0s;
                    -o-transition: all 0.3s ease 0s;
                    transition: all 0.3s ease 0s;
                    -ms-transition: all 0.3s ease 0s;
                    width: 100%;
                    overflow: hidden;
                    position: relative;
                    margin-bottom: 30px;
                }
                .feature-item-container-box .feature-title-item h1 {
                    font-family: 'Open Sans', sans-serif;
                    background: rgba(1, 39, 58, 0.8);
                    color: $color;
                    font-size: 13px;
                    font-weight: 600;
                    text-transform: uppercase;
                    padding: 8px 15px;
                    position: absolute;
                    left: 0px;
                    top: 0px;
                    margin: 0;
                    border-radius:0 15px 15px 0px;
                    -webkit-transition: all 0.3s ease 0s;
                    -moz-transition: all 0.3s ease 0s;
                    -o-transition: all 0.3s ease 0s;
                    transition: all 0.3s ease 0s;
                    -ms-transition: all 0.3s ease 0s;
                }
                .feature-item-listing-item {
                    border: 1px solid #efeeee;
                    -webkit-transition: all 0.3s ease 0s;
                    -moz-transition: all 0.3s ease 0s;
                    -o-transition: all 0.3s ease 0s;
                    transition: all 0.3s ease 0s;
                    -ms-transition: all 0.3s ease 0s;
                    overflow: hidden;
                    position: relative;
                    margin-bottom: 0px;
                }
                .feature-item-listing-item .feature-title-item h1 {
                    background: rgba(1, 39, 58, 0.8);
                    color: $color;
                    font-size: 15px;
                    font-weight: 700;
                    text-transform: uppercase;
                    padding: 8px 15px;
                    position: absolute;
                    left: 1px;
                    top: 1px;
                    margin: 0;
                    -webkit-transition: all 0.3s ease 0s;
                    -moz-transition: all 0.3s ease 0s;
                    -o-transition: all 0.3s ease 0s;
                    transition: all 0.3s ease 0s;
                    -ms-transition: all 0.3s ease 0s;
                }
                .feature-title-item {
                    background: rgba(0, 0, 0, 0) linear-gradient(to right, rgba(0, 0, 0, 0.3) -10%, rgba(0, 0, 0, 0.5) 20%, rgba(0, 0, 0, 0.5) 40%, transparent 80%) repeat scroll 0 0
                }
                .feature-title-item img {
                    width: 100%;
                    height: 200px;
                }
                .feature-item-container-box:hover {
                    border: 1px solid $color;
                    box-shadow: 0 1px 15px rgba(0, 0, 0, 0.2);
                }
                .feature-item-container-box.active {
                    border: 1px solid $color;
                    box-shadow: 0 1px 15px rgba(0, 0, 0, 0.2);
                }
                .feature-item-container-box:hover .feature-title-item img {
                    transform: scale(1.2);
                    transition: all 0.4s ease 0s;
                }
                .feature-item-container-box.active .feature-box-text a h3 {
                    color: $color;
                }
                .feature-item-container-box .feature-box-text {
                    background: #fefefe;
                    padding:15px;
                    text-align: left;
                    position:relative;
                }
                .feature-item-container-box .feature-item-location {
                    background: #f4f4f4;
                    padding: 5px 15px;
                    float: left;
                    display: block;
                    width: 100%;
                    position: relative;
                }
                .feature-item-container-box .feature-item-location h2 {
                    font-family:'Open Sans',sans-serif;
                    font-size: 14px;
                    color: #4a4a4a;
                    font-weight: 600;
                    margin: 0px;
                    text-align: left;
                    line-height: 30px;
                    float: left;
                }
                .feature-item-container-box .feature-item-location h2 i {
                    color: #ffcc58;
                    font-size:14px;
                    margin-right: 3px;
                }
                .feature-item-container-box .feature-item-location span {
                    float: right;
                    font-size: 13px;
                    position: relative;
                    top: 7px;
                }
                .feature-item-container-box .feature-item-location span i.fa {
                    color: #ffcc58;
                }
                .feature-box-text i.fa-star-half-empty {
                    margin-right: 5px;
                }
                .feature-item-container-box .feature-box-text h3 {  
                    margin-top: 0;
                    line-height:18px;
                    margin-bottom:7px;
                }
                .feature-item-container-box .feature-box-text h3 a{
                    font-family: 'Open Sans', sans-serif;
                    color: #4a4a4a;
                    font-weight: 700;
                    font-size: 16px;
                    margin-top: 0;  
                }
                .feature-item-container-box .feature-box-text p {
                    color: #7d7d7d;
                    font-size: 13px;
                    line-height: 22px;
                    font-weight:500;
                    margin-top: 10px;
                    margin-bottom: 0;
                    letter-spacing:0.4px;   
                }
                .feature-item-container-box .feature-box-text a {
                    font-family:'Open Sans',sans-serif;
                    color: $color;
                    font-size: 13px;
                    font-weight: 600;
                    letter-spacing:0.2px;
                }
                .feature-item-container-box.active .feature-box-text a, .feature-item-container-box.active .feature-box-text a i {
                    color: #969595 !important;
                }
                .feature-item-container-box .feature-box-text a i.fa {
                    color: $color;
                    margin-right: 3px;
                }
                .feature-title-item {
                    position: relative;
                }
                .hover-overlay {
                    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
                    height: 48%;
                    left: 0px;
                    position: absolute;
                    right: 0px;
                    top: 0px;
                    width: auto;
                    bottom: 0px;
                }
                .feature-item-container-box:hover .hover-overlay {
                    background: rgba(0, 0, 0, 0.7) none repeat scroll 0 0;
                }
                .hover-overlay-inner {
                    height: 100%;
                    text-align: center;
                    vertical-align: middle;
                }
                .feature-item-container-box:hover .hover-overlay-inner::before, .feature-item-container-box:hover .hover-overlay-inner::after {
                    bottom: 10px;
                    content: '';
                    left: 10px;
                    opacity: 0;
                    position: absolute;
                    right: 10px;
                    top: 10px;
                    transition: opacity 0.35s ease 0s, transform 0.35s ease 0s;
                }
                .feature-item-container-box:hover .hover-overlay-inner::before {
                    border-bottom: 1px solid #ebc131;
                    border-top: 1px solid #ebc131;
                    transform: scale(0, 1);
                }
                .feature-item-container-box:hover .hover-overlay-inner::after {
                    border-left: 1px solid #ebc131;
                    border-right: 1px solid #ebc131;
                    transform: scale(1, 0);
                }
                .feature-item-container-box:hover .hover-overlay-inner::before, .feature-item-container-box:hover .hover-overlay-inner::after, .location-entry:hover .hover-overlay-inner::before, .location-entry:hover .hover-overlay-inner::after, .feature-item:hover .hover-overlay-inner::before, .feature-item:hover .hover-overlay-inner::after, .listing-item:hover .hover-overlay-inner::before, .listing-item:hover .hover-overlay-inner::after {
                    opacity: 1;
                    transform: scale(1);
                }
                .feature-item-container-box:hover .hover-overlay .hover-overlay-inner ul.listing-links {
                    display: block;
                    z-index: 999
                }
                .hover-overlay .hover-overlay-inner h3 a {
                    display: none;
                }
                .feature-item-container-box:hover .hover-overlay .hover-overlay-inner h3 {
                    display: list-item
                }
                .feature-item-container-box:hover .hover-overlay .hover-overlay-inner h3 a {
                    color: $color;
                    display: block;
                    font-size: 16px;
                    font-weight: 600;
                    margin-left: 20px;
                    text-align: left;
                    position: absolute;
                    z-index: 99;
                }
                .feature-item-container-box:hover .hover-overlay .hover-overlay-inner h3 a:hover {
                    color: #ffffff;
                    text-decoration: underline !important;
                }
                .hover-overlay .hover-overlay-inner ul.listing-links {
                    position: absolute;
                    top: 50%;
                    transform: translateY(-50%);
                    display: block;
                    height: auto;
                    margin: 0 auto;
                    text-align: center;
                    right: 0;
                    left: 0;
                    display: none;
                }
                .hover-overlay .hover-overlay-inner ul.listing-links li:first-child {
                    margin-left: 0;
                }
                .hover-overlay .hover-overlay-inner ul.listing-links li {
                    display: inline-block;
                    margin-left: 5px;
                }
                .hover-overlay .hover-overlay-inner ul.listing-links li button {
                    background: #ffffff;
                    border-radius: 50%;
                    font-size: 18px;
                    height: 44px;
                    line-height: 44px;
                    width: 44px;
                    float: left;
                    border: 0
                }

                .hover-overlay .hover-overlay-inner ul.listing-links li button:hover {
                    -webkit-transform: scale(1.1);
                    transform: scale(1.1);
                    -webkit-transition: ease-out .5s;
                    -moz-transition: ease-out .5s;
                    -o-transition: ease-out .5s;
                    transition: ease-out .5s;
                    transition: all .6s ease-in-out 0;
                    box-shadow: 0 3px 8px rgba(255, 255, 255, 0.3)
                }
                .boton {
                    background: transparent;
                    padding: 2px 5px;
                    margin-left: 8px;
                    border-radius: 5px;
                    border: 1px solid #ccc;
                }
                .boton:hover{
                    background: #fff;
                    -webkit-transform: scale(1.1);
                    transform: scale(1.1);
                    -webkit-transition: ease-out .5s;
                    -moz-transition: ease-out .5s;
                    -o-transition: ease-out .5s;
                    transition: ease-out .5s;
                    transition: all .6s ease-in-out 0;
                    box-shadow: 0 3px 8px rgba(255, 255, 255, 0.3)
                }
                .green-1 {
                    color: #ccdb38;
                }
                .blue-1 {
                    color: #08c2f3;
                }
                .yallow-1 {
                    color: #fecc17;
                }
                .feature-item-listing-item:hover .recent-listing-box-image img {
                    /*transform: scale(1.2);
                    transition: all 0.4s ease 0s;*/
                }
                .feature-item-listing-item:hover .hover-overlay {
                    background: rgba(0, 0, 0, 0.7) none repeat scroll 0 0;
                }
                .feature-item-listing-item .hover-overlay {
                    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
                    height: 100%;
                    left: 0px;
                    position: absolute;
                    right: 0px;
                    top: 0px;
                    width: auto;
                    bottom: 0px;
                }
                .feature-item-listing-item:hover .hover-overlay-inner::before, .feature-item-listing-item:hover .hover-overlay-inner::after {
                    bottom: 10px;
                    content: '';
                    left: 10px;
                    opacity: 0;
                    position: absolute;
                    right: 10px;
                    top: 10px;
                    transition: opacity 0.35s ease 0s, transform 0.35s ease 0s;
                }
                .feature-item-listing-item:hover .hover-overlay-inner::before {
                    border-bottom: 1px solid #ebc131;
                    border-top: 1px solid #ebc131;
                    transform: scale(0, 1);
                }
                .feature-item-listing-item:hover .hover-overlay-inner::after {
                    border-left: 1px solid #ebc131;
                    border-right: 1px solid #ebc131;
                    transform: scale(1, 0);
                }
                .feature-item-listing-item:hover .hover-overlay-inner::before, .feature-item-listing-item:hover .hover-overlay-inner::after, .location-entry:hover .hover-overlay-inner::before, .location-entry:hover .hover-overlay-inner::after, .feature-item:hover .hover-overlay-inner::before, .feature-item:hover .hover-overlay-inner::after, .listing-item:hover .hover-overlay-inner::before, .listing-item:hover .hover-overlay-inner::after {
                    opacity: 1;
                    transform: scale(1);
                }
                .feature-item-listing-item:hover .hover-overlay .hover-overlay-inner ul.listing-links {
                    display: block;
                    z-index: 999
                }
                .feature-item-listing-item:hover .hover-overlay .hover-overlay-inner h3 {
                    display: list-item
                }
                .feature-item-listing-item:hover .hover-overlay .hover-overlay-inner h3 a {
                    color: $color;
                    display: block;
                    font-size: 17px;
                    font-weight: 700;
                    margin-left: 20px;
                    text-align: left;
                    position: absolute;
                    z-index: 99;
                }
                .feature-item-listing-item:hover .hover-overlay .hover-overlay-inner h3 a:hover {
                    color: #ffffff;
                    text-decoration: underline !important;
                }
                /************************ recent listings ********************************/
                #recent-product-item-listing {
                    padding: 80px 0px 60px 0;
                    background: #ffffff;
                }
                .recent-item-listing-heading {
                    margin-bottom: 50px;
                }
                .recent-item-listing-heading h1 {
                    font-family: 'Raleway', sans-serif;
                    margin: 0px;
                    color: #01273a;
                    text-transform: uppercase;
                    font-weight: 700;
                    font-size: 28px;
                }
                .recent-item-listing-heading h1 span {
                    color: $color;
                }
                .listing-boxes {
                    padding-top: 50px;
                    display: inline-block;
                    width: 100%;
                }
                .listing-boxes1 {
                    padding-top: 30px;
                }
                .recent-listing-box-container-item {
                    display: block;
                    margin-bottom: 30px;
                    width: 100%;
                    border: 1px solid #efeeee;
                    -webkit-transition: all 0.3s ease 0s;
                    -moz-transition: all 0.3s ease 0s;
                    -o-transition: all 0.3s ease 0s;
                    transition: all 0.3s ease 0s;
                    -ms-transition: all 0.3s ease 0s;
                    overflow: hidden;
                    position: relative;
                }
                .recent-listing-box-container-item:hover {
                    border: 1px solid $color;
                    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
                }
                .recent-listing-box-container-item:hover h1 span {
                    margin-bottom: 0px;
                }
                .listings-boxes-container:hover .listing-boxes-text {
                    border: 1px solid transparent;
                    border-top: none;
                }
                .recent-listing-box-container-item:hover .recent-listing-box-image img {
                    /*transform: scale(1.2);
                    transition: all 0.4s ease 0s;*/
                }
                .recent-listing-box-container-item:hover .hover-overlay {
                    background: rgba(0, 0, 0, 0.7) none repeat scroll 0 0;
                }
                .recent-listing-box-container-item .hover-overlay {
                    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
                    height: 100%;
                    left: 0px;
                    position: absolute;
                    right: 0px;
                    top: 0px;
                    width: auto;
                    bottom: 0px;
                }
                .recent-listing-box-container-item:hover .hover-overlay-inner::before, .recent-listing-box-container-item:hover .hover-overlay-inner::after {
                    bottom: 10px;
                    content: '';
                    left: 10px;
                    opacity: 0;
                    position: absolute;
                    right: 10px;
                    top: 10px;
                    transition: opacity 0.35s ease 0s, transform 0.35s ease 0s;
                }
                .recent-listing-box-container-item:hover .hover-overlay-inner::before {
                    border-bottom: 1px solid #ebc131;
                    border-top: 1px solid #ebc131;
                    border-left:1px solid #ebc131;
                    border-right:1px solid #ebc131;
                }   
                .recent-listing-box-container-item:hover .hover-overlay-inner::after {
                    border-left: 1px solid #ebc131;
                    border-right: 1px solid #ebc131;
                    transform: scale(1, 0);
                }
                .recent-listing-box-container-item:hover .hover-overlay-inner::before, .recent-listing-box-container-item:hover .hover-overlay-inner::after, .location-entry:hover .hover-overlay-inner::before, .location-entry:hover .hover-overlay-inner::after, .feature-item:hover .hover-overlay-inner::before, .feature-item:hover .hover-overlay-inner::after, .listing-item:hover .hover-overlay-inner::before, .listing-item:hover .hover-overlay-inner::after {
                    opacity: 1;
                    -webkit-transition: ease-out 1.0s;
                    -moz-transition: ease-out 1.0s;
                    -o-transition: ease-out 1.0s;
                    transition: ease-out 1.0s;
                    transition: all 1.0s ease-in-out 0;
                }
                .recent-listing-box-container-item:hover .hover-overlay .hover-overlay-inner ul.listing-links {
                    display: block;
                    z-index: 999
                }
                .recent-listing-box-container-item:hover .hover-overlay .hover-overlay-inner h3 {
                    display: list-item
                }
                .recent-listing-box-container-item:hover .hover-overlay .hover-overlay-inner h3 a {
                    color: $color;
                    display: block;
                    font-size: 17px;
                    font-weight: 700;
                    margin-left: 20px;
                    text-align: left;
                    position: absolute;
                    z-index: 99;
                }
                .recent-listing-box-container-item:hover .listing-boxes-text a h3 {
                    color: #01273a;
                    text-decoration: none;
                }
                .recent-listing-box-image img {
                    height: 247px;
                    max-width: 50%;
                    width: 50%;
                    height:50%;
                }
                .recent-listing-box-image > h1 {
                    font-size: 14px;
                    position: relative;
                    text-transform: capitalize;
                    margin: 0px;
                    color: #636363;
                    -webkit-transition: all 0.3s ease 0s;
                    -moz-transition: all 0.3s ease 0s;
                    -o-transition: all 0.3s ease 0s;
                    transition: all 0.3s ease 0s;
                    -ms-transition: all 0.3s ease 0s;
                }
                .recent-listing-box-image h1 {
                    font-family: 'Open Sans', sans-serif;
                    background: rgba(1, 39, 58, 0.8) none repeat scroll 0 0;
                    color: #fff;
                    font-size: 13px;
                    font-weight: 600;
                    left: 0px;
                    margin: 0;
                    padding: 8px 15px;
                    border-radius:0 15px 15px 0px;
                    position: absolute;
                    text-transform: uppercase;
                    top: 0px;
                    transition: all 0.3s ease 0s;
                }
                .recent-listing-box-item {
                    background-color: #ffffff;
                    text-align: left;
                    position: relative;
                }
                .listing-boxes-text {
                    padding: 15px;
                    text-align: left;
                }
                .recent-listing-box-item .recent-feature-item-rating {
                    background: #f9f9f9;
                    display: block;
                    float: left;
                    padding: 5px 15px;
                    width: 100%;
                    position: relative;
                    left: 0;
                    right: 0;
                    bottom: 0px;
                }
                .recent-feature-item-rating h2 {
                    font-family: 'Open Sans', sans-serif;
                    color: #4a4a4a;
                    float: left;
                    font-size: 14px;
                    font-weight: 600;
                    line-height: 30px;
                    margin: 0;
                    text-align: left;
                }
                .recent-feature-item-rating span {
                    float: right;
                    font-size: 13px;
                    position: relative;
                    top: 7px;
                }
                .recent-feature-item-rating span i.fa {
                    color: #ffcc58;
                }
                .listing-boxes-text a h3 {
                    font-family: 'Open Sans', sans-serif;
                    color: #4a4a4a; 
                    font-size: 16px;
                    font-weight:700;
                    margin-top: 0;
                    margin-bottom:7px;
                }
                .recent-listing-box-item .recent-feature-item-rating h2 i {
                    color: #ffcc58;
                    font-size:14px;
                    margin-right: 3px;
                }
                .listing-boxes-text p {
                    color: #7d7d7d;
                    font-size: 13px;    
                    font-weight:500;
                    line-height: 22px;
                    margin-bottom: 0;
                    margin-top: 10px;
                    letter-spacing:0.3px;
                }
                .listing-boxes-text a {
                    font-family: 'Open Sans', sans-serif;   
                    color: $color;
                    font-size: 13px;
                    font-weight: 600;
                    letter-spacing:0.2px;
                }
                .listing-boxes-text a i.fa {
                    color: $color;
                    margin-right: 3px;
                }
                /*********************** vfx counter block *********************/
                .vfx-counter-block {
                    background: #fafafa url(assets/images/vfx_counter_bg.png) no-repeat center top;
                    background-position: cover;
                    background-attachment: fixed;
                    background-size: 100% 100%;
                    padding: 60px 0px 30px 0;
                }
                .vfx-item-countup {
                    background:rgba(255, 255, 255, 0.8);
                    width: 262px;
                    height: 262px;
                    border-radius: 50%;
                    text-align: center;
                    padding: 55px 0;
                    border: 5px solid $color;
                    box-shadow:0 12px 10px rgba(0, 0, 0, 0.25);
                    margin-bottom: 30px;
                }
                .vfx-item-counter-up .count_number {
                    font-family: 'Open Sans', sans-serif;
                    color: #4a4a4a;
                    font-size: 50px;
                    line-height: 60px;
                    font-weight: 800;
                    margin-top: 5px;
                }
                .vfx-item-counter-up .counter_text {
                    font-family: 'Raleway', sans-serif;
                    color: #696969;
                    font-size: 16px;
                    font-weight: 600;
                    text-transform: uppercase;
                }
                .vfx-item-black-top-arrow {
                    line-height: 45px;
                }
                .vfx-item-black-top-arrow i {
                    font-size: 46px;
                    line-height: 50px;
                    color: $color
                }
                /*********************** pricing plan **********************/
                #pricing-item-block {
                    background: #f2f2f2;
                    padding: 80px 0px;
                }
                #pricing-section {
                    padding-bottom: 60px;
                    background: #f7f7f7;
                    border-bottom: 2px solid $color;
                }
                .pricing-heading-title {
                    margin-bottom: 50px;
                }
                .pricing-heading-title h1 {
                    font-family: 'Raleway', sans-serif;
                    margin: 0px;
                    color: #01273a;
                    text-transform: uppercase;
                    font-weight: 700;
                    font-size: 28px;
                }
                .pricing-heading-title h1 span {
                    color: $color;
                }
                .price-table-feature-block {
                    padding: 35px 0px;
                    background: #ffffff;
                    border: 1px solid #ebebeb;
                    position: relative;
                }
                .price-table-feature-block.active {
                    box-shadow: -2px 5px 15px 7px #e2e2e2;
                    border-radius: 4px;
                    border:1px solid rgba(0, 0, 0, 0.15);   
                }
                .price-table-feature-block:hover {
                    transition: all 0.3s ease 0s;
                    box-shadow: -2px 5px 15px 7px #e2e2e2;
                    border-radius: 4px;
                    border:1px solid rgba(0, 0, 0, 0.15);   
                    -webkit-transform: scale(1.0);
                    transform: scale(1.0);
                    -webkit-transition: ease-out .5s;
                    -moz-transition: ease-out .5s;
                    -o-transition: ease-out .5s;
                    transition: ease-out .5s;
                    transition: all .5s ease-in-out 0;
                }
                .price-table-feature-block h1 {
                    font-family: 'Open Sans', sans-serif;
                    margin: 0px;
                    color: #4a4a4a;
                    font-size: 18px;
                    font-weight: 600;
                    text-transform: uppercase;
                }
                .price-table-feature-block > hr {
                    width: 90px;
                    margin: 10px auto 15px auto;
                    border-color: $color;
                }
                .price-table-feature-block p {
                    color: #999999;
                    font-size: 15px;
                    font-weight:500;
                    padding: 0px 40px;
                }
                .price-table-feature-block p span {
                    color: $color;
                }
                .vfx-price-list-item {
                    display: block;
                    width: auto;
                    background:#f8f8f8;
                    padding:25px 0;
                    border-bottom:1px solid #ebebeb;
                }
                .vfx-price-list-item:nth-child(even){
                    background:#ffffff;
                }
                .vfx-price-list-item h2 {
                    margin: 0px;
                    color: #01273a;
                    font-size: 16px;
                    font-weight: 500;
                }
                .vfx-price-list-item > h2:before {
                    content: '';
                    font-family: fontawesome;
                    color: $color;
                    margin-right: 10px;
                }
                .vfx-price-list-item p {
                    margin: 0px;
                    color: #999999;
                    font-size: 13px;
                    line-height: 22px;
                    font-weight: 500;
                    margin-top: 10px;
                    letter-spacing:0.2px
                }
                .vfx-pl-seperator {
                    background: #ebebeb none repeat scroll 0 0;
                    display: inline-block;
                    height: 1px;
                    margin-bottom: -6px;
                    margin-top: 15px;
                    position: relative;
                    width: 100%;
                }
                .vfx-pl-seperator > span {
                    background: none;
                    color: #d0d0d0;
                    display: inline-block;
                    font-family: 'FontAwesome';
                    font-size: 0;
                    height: 18px;
                    margin-left: -9px;
                    position: absolute;
                    top: -9px;
                    width: 11px;
                }
                .vfx-pl-seperator span i.fa-caret-down {
                    font-size: 24px;
                    margin-left: -1px;
                }
                .list hr {
                    width: 100% !important;
                }
                .vfx-price-btn {
                    margin-top: 35px;
                    display: inline-block;
                }
                .vfx-price-btn button.purchase-btn {
                    font-family: 'Open Sans', sans-serif;
                    background: -webkit-linear-gradient(left, #262626 50%, $color 50%) repeat scroll right bottom/207% 100% transparent;
                    background: linear-gradient(to right, #262626 50%, $color 50%) repeat scroll right bottom/207% 100% transparent;
                    color: #ffffff;
                    text-transform: uppercase;
                    border-radius: 30px;
                    padding: 15px 30px;
                    font-weight: 600;
                    -webkit-transition: background 350ms ease-in-out;
                    transition: background 350ms ease-in-out;
                    border: none;
                    outline: 0 !important;
                }
                .price-table-feature-block:hover button.purchase-btn {
                    background-position: left bottom;
                    box-shadow:0px 6px 6px -2px rgba(0, 0, 0, 0.4);
                }
                .vfx-price-btn button.purchase-btn i{
                    margin-right:3px;
                }
                /******************** listing product **********************/
                #vfx-product-inner-item {
                    background: #ffffff;
                    padding: 80px 0;
                }
                .news-search-lt {
                    margin-bottom: 30px;
                    width: 100%;
                    position: relative;
                }
                .news-search-lt input.form-control {
                    background-color: #fff;
                    border: 1px solid #ededed;
                    border-radius: 0;
                    color: #696969;
                    font-size: 14px;
                    font-weight:600;
                    letter-spacing:0.5px;
                    line-height: 28px;
                    padding: 10px;
                    width: 100%;
                    height: 50px;
                }
                .news-search-lt input.form-control {
                    box-shadow: none;
                }
                .news-search-lt span.input-search i {
                    bottom: 0;
                    color: $color;
                    cursor: pointer;
                    display: inline-table;
                    float: right;
                    position: absolute;
                    right: 15px;
                    top: 17px;
                    z-index: 0;
                }
                .list-group {
                    margin-bottom: 2rem;
                }
                .list-group-item:first-child, .list-group-item:last-child {
                    border-radius: 0;
                }
                a.list-group-item.active {
                    background: transparent linear-gradient(to right, $color 50%, #f5f5f5 50%) repeat scroll right bottom / 207% 100%;
                    border-color: $color;
                    color: #01273a !important;
                    z-index: 0;
                    background-position: left bottom;
                }
                a.list-group-item:hover {
                    background: transparent linear-gradient(to right, $color 50%, #f5f5f5 50%) repeat scroll right bottom / 207% 100%;
                    color: #01273a !important;
                    text-decoration: none;
                    background-position: left bottom;
                    border-color: #ddd !important
                }
                .list-group a.list-group-item span {
                    font-family: 'Open Sans', sans-serif;
                    background: $color;
                    border-radius: 30px;
                    color: #fff;
                    float: right;
                    font-weight:600;
                    font-size: 11px;
                    height: 28px;
                    line-height: 26px;
                    margin-top: 11px;
                    text-align: center;
                    vertical-align: middle;
                    width: 28px;    
                }
                a.list-group-item:hover i {
                    color: #01273a;
                }
                a.list-group-item:hover span {
                    background: #ffffff;
                    color: #01273a;
                }
                a.list-group-item:hovre i {
                 color:#ffffff;
                }
                a.list-group-item.active i {
                    color: #01273a;
                }
                a.list-group-item.active span {
                    background: #ffffff;
                    color: #01273a;
                }
                .left-slide-slt-block {
                    margin-bottom: 30px;
                    width: 100%;
                }
                .left-slide-slt-block h3:first-child {
                    margin-top: 0px;
                }
                .left-slide-slt-block h3 {
                    background: #f1f1f1;
                    border: 1px solid #ededed;
                    color: #6b6b6b;
                    font-size: 16px;
                    font-weight: 600;
                    padding: 15px;
                    text-align: left;
                    letter-spacing:0.4px;
                }
                .list-group-item {
                    background: transparent linear-gradient(to right, $color 50%, #ffffff 50%) repeat scroll right bottom / 207% 100%;
                    border: 1px solid #ddd;
                    display: block;
                    margin-bottom: -1px;
                    position: relative;
                    color: #696969;
                    font-size: 13px;    
                    line-height: 48px;
                    padding: 0 15px;
                    font-weight:600;
                    -webkit-transition: all .6s ease 0;
                    transition: all .6s ease 0;
                    transition: all 0.3s ease 0s;
                }
                #vfx-product-inner-item .list-group a{
                    color: #696969;
                }
                a.list-group-item, button.list-group-item {
                    text-align: inherit;
                    width: 100%;
                }
                .list-group-item i {
                    color: #35385b;
                    padding-right: 5px;
                }
                .archive-tag {
                    width: 100%;
                }
                .archive-tag ul {
                    display: inline-block;
                    margin-bottom: 15px;
                    padding: 0;
                }
                .archive-tag ul li {
                    float: left;
                    list-style: outside none none;
                    padding: 5px 0;
                }
                .archive-tag ul li a {
                    background: transparent linear-gradient(to right, $color 50%, #f1f1f1 50%) repeat scroll right bottom / 207% 100%;
                    color: #696969;
                    display: inline-block;
                    font-size: 13px;
                    font-weight: 600;
                    margin-right: 7px;
                    padding: 7px 13px;
                    border-radius: 4px;
                    text-align: center;
                    -webkit-transition: all .6s ease 0;
                    transition: all .6s ease 0;
                    transition: all 0.3s ease 0s;
                }
                .archive-tag ul li a:hover {
                    background: transparent linear-gradient(to right, $color 50%, #f1f1f1 50%) repeat scroll right bottom / 207% 100%;
                    color: #fff;
                    background-position: left bottom;
                }
                .archive-tag ul li a.active {
                    background: transparent linear-gradient(to right, #dadada 50%, $color 50%) repeat scroll right bottom / 207% 100%;
                    color: #ffffff;
                }
                .left-location-item {
                    width: 100%;
                }
                .left-location-item ul {
                    margin-bottom: 30px;
                    padding: 0;
                    width: auto;
                }
                .left-location-item .list-lt {
                    font-family: 'Open Sans', sans-serif;
                    background: #01273a;
                    border-radius: 30px;
                    color: #fff;
                    float: right;
                    font-size: 11px;    
                    margin-right: 8px;
                    padding: 6px 8px;
                    text-align: center;
                    width: 28px;
                    height: 28px;
                    line-height: 17px;
                    vertical-align: middle;
                }
                .left-location-item ul li {
                    list-style: outside none none;
                    padding: 7px 0 7px 10px;
                    line-height: 28px;
                    border-top: 1px solid rgba(241, 241, 241, 0.8)
                }
                .left-location-item ul li i{
                    margin-right:5px;
                }
                .left-location-item ul li:last-child {
                    border-bottom: 1px solid rgba(241, 241, 241, 0.8)
                }
                .left-location-item ul li a {
                    color: #696969;
                    font-size: 13px;
                    text-align: left;   
                    font-weight:600;
                    letter-spacing:0.5px;
                }
                .left-location-item ul li a:hover {
                    color: $color;
                    transition: all 0.2s linear 0s;
                }
                .left-archive-categor {
                    width: 100%;
                }
                .left-archive-categor ul {
                    margin-bottom: 30px;
                    padding: 0;
                    width: auto;
                }
                .left-archive-categor .list-lt {
                    font-family: 'Open Sans', sans-serif;
                    background: #01273a;
                    border-radius: 30px;
                    color: #fff;
                    float: right;
                    font-size: 11px;    
                    margin-right: 8px;
                    padding: 6px 8px;
                    text-align: center;
                    width: 30px;
                    height: 30px;
                    line-height: 17px;
                    vertical-align: middle;
                }
                .left-archive-categor ul li {
                    list-style: outside none none;
                    padding: 7px 0 7px 10px;
                    line-height: 30px;
                    border-top: 1px solid rgba(241, 241, 241, 0.8)
                }
                .left-archive-categor ul li:last-child {
                    border-bottom: 1px solid rgba(241, 241, 241, 0.8)
                }
                .left-archive-categor ul li a {
                    color: #696969;
                    font-size: 13px;
                    text-align: left;   
                    font-weight:600;
                    letter-spacing:0.5px
                }
                .left-archive-categor ul li a i{
                    margin-right:5px;
                }
                .left-archive-categor ul li a:hover {
                    color: $color;   
                    transition: all 0.2s linear 0s;
                }
                .working-hours .days {
                    border-bottom: 1px solid rgba(241, 241, 241, 0.8);
                    line-height: 44px;
                    color: #696969;
                    padding-left: 8px;
                    padding-right: 8px;
                    letter-spacing:0.5px;
                }
                .working-hours .days:first-child {
                    border-top: 1px solid rgba(241, 241, 241, 0.8);
                }
                .working-hours .name {
                    font-size: 13px;
                    font-weight: 600;
                }
                .working-hours .hours {
                    float: right;
                    font-size: 13px;
                    font-weight: 500;
                }
                /******************* footer block********************/
                #clients {
                    background: #ffffff;
                    padding: 40px 0px;
                    border-bottom: 2px solid $color;
                }
                #clients .bx-viewport {
                    background: none;
                    box-shadow: none;
                    border: none;
                }
                .site-footer {
                    color: #fff;
                    -webkit-background-size: cover;
                    background-size: cover;
                    background-position: 50% 50%;
                    background-repeat: no-repeat
                }
                .site-footer a {
                    font-family:'Raleway', sans-serif;
                    color: #cfcfcf;
                    font-size: 14px;
                    font-weight: 500;
                    line-height: 22px;
                    display: block;
                }
                p.about-lt {
                    font-family:'Raleway', sans-serif;
                    font-size: 14px;
                    line-height: 24px;
                    font-weight: 500;
                    color:#cfcfcf;
                    margin-bottom: 10px;
                    letter-spacing:0.1px;
                }
                a.more-detail {
                    color: #35385b;
                    float: left;
                    font-size: 13px;
                    font-weight: 500;
                    margin-bottom: 20px;
                    text-align: right;
                    text-transform: uppercase;
                    width: 100%;
                }
                .site-footer a:hover {
                    color: $color
                }
                .site-footer p .fa {
                    padding:0 .125rem
                }
                .site-footer ul {
                    list-style: none;
                    padding-left: 0;
                    margin-bottom: 0
                }
                .site-footer ul li {
                    padding:.09rem 0
                }
                .social-icons li {
                    display: inline-block;
                    margin-bottom: 0.125rem;
                }
                .social-icons a {
                    background: transparent linear-gradient(to right, $color 50%, #ffffff 50%) repeat scroll right bottom / 207% 100%;
                    border-radius: 30px;
                    color: #00283b;
                    display: inline-block;
                    font-size: 14px;
                    width: 30px;
                    height: 30px;
                    line-height: 30px;
                    margin-right: 0.5rem;
                    text-align: center;
                    transition: background-color 0.2s linear 0s;
                    -webkit-transition: all .6s ease 0;
                    transition: all .6s ease 0;
                    transition: all 0.3s ease 0s;
                }
                .social-icons a:hover {
                    background: transparent linear-gradient(to right, $color 50%, #ffffff 50%) repeat scroll right bottom / 207% 100%;
                    color: #00283b;
                    background-position: left bottom;
                }
                .site-footer.footer-map {
                    background-image: url(assets/images/bg-map.png);
                    background-color: #000;
                    -webkit-background-size: contain;
                    background-size: contain;
                    background-position: 50% -40px
                }
                ul.widget-news-simple li {
                    border-bottom: 1px solid rgba(255, 255, 255, 0.15);
                    padding-bottom: 15px;
                }
                .widget-news-simple li {
                    margin-bottom: 15px;
                }
                .widget-news-simple div {
                    color: #35385b;
                    font-size: 13px;
                    font-weight: 600;
                }
                .news-thum {
                    float: left;
                    height: 70px;
                    margin-right: 15px;
                    width: 70px;
                }
                .news-text-thum {
                    margin-top: -5px;
                    padding-left: 82px;
                }
                .widget-news-simple h6 {
                    font-size: 16px;
                    font-weight: 600;
                    line-height: 22px;
                    margin-top: 0;
                    margin-bottom: 5px;
                }
                .widget-news-simple h6 a {
                    font-family: 'Open Sans', sans-serif;
                    font-size: 15px;
                    font-weight: 600;
                }
                .widget-news-simple p {
                    font-family:'Raleway', sans-serif;
                    color: #cfcfcf;
                    font-size: 13px;
                    font-weight: 500;
                    line-height: 20px;
                    margin-bottom: 5px;
                    letter-spacing:0.3px;
                }
                .widget-news-simple div {
                    font-family: 'Open Sans', sans-serif;
                    color: #35385b;
                    font-size: 13px;
                    font-weight: 500;
                }
                ul.widget-news-simple .news-thum a img {
                    border-radius: 4px;
                }
                ul.use-slt-link li:first-child{
                    padding-top:0;
                }
                ul.use-slt-link li {
                    border-bottom: 1px solid rgba(255, 255, 255, 0.15);
                    padding: 8px 0;
                    transition: all 0.5s ease 0s;
                    -webkit-transition: all 0.5s ease 0s;
                    -moz-transition: all 0.5s ease 0s;
                }
                .site-footer .form-alt .form-group .form-control {
                    background-color: #fff;
                    color: #072d40;
                    border: 0 none;
                    border-radius: 6px;
                    font-size: 14px;
                    font-weight: 500;
                    line-height: 22px;
                    padding: 10px;
                }
                .btn-quote {
                    background: -webkit-linear-gradient(left, $color 50%, $color 50%) repeat scroll right bottom/207% 100% transparent;
                    background: linear-gradient(to right, #fff 50%, $color 50%) repeat scroll right bottom/207% 100% transparent;
                    border: 0 none;
                    border-radius: 6px;
                    color: #fff;
                    display: block;
                    font-size: 15px;
                    font-weight: 700;
                    letter-spacing: 0;
                    line-height: 24px;
                    margin: 0 auto;
                    padding: 8px 20px;
                    text-align: center;
                    -webkit-transition: background 350ms ease-in-out;
                    transition: background 350ms ease-in-out;
                    text-transform: uppercase;
                    transition: all 0.2s linear 0s;
                }
                .btn-quote:hover, .btn-quote:focus, .btn-quote:active, .btn-quote:active:focus {
                    background-color: #fff;
                    border-color: transparent;
                    background-position: left bottom;
                    box-shadow: none;
                    color: $color
                    ;
                    outline: medium none !important;
                }
                .site-footer .form-group input {
                    height: 40px;
                    color: $color;
                }
                .site-footer textarea.form-control {
                    box-shadow: 3px 4px 8px rgba(0, 0, 0, 0.14) inset;
                }
                .site-footer .form-group::-moz-placeholder {
                    color: #afafaf;
                }
                .site-footer .form-group::placeholder {
                    color: #999;
                    opacity: 1;
                }
                .site-footer .form-group::-moz-placeholder {
                    color: #999;
                    opacity: 1;
                }
                .footer-top {
                    background: rgba(30, 30, 30, 0.98);
                    padding: 80px 0 70px;
                }
                .footer-top h2 {
                    font-family:'Raleway', sans-serif;
                    font-size: 18px;
                    line-height: 24px;
                    color: #fff;
                    margin-bottom: 35px;
                    font-weight: 600;
                    margin-top: 0;
                    text-transform:uppercase;
                    letter-spacing:0.5px;
                }
                .site-footer .footer-top hr {
                    background: $color;
                    border: 0 none;
                    bottom: 0;
                    height: 2px;
                    left: 0;
                    margin: 10px 0;
                    position: relative;
                    right: 0;
                    text-align: left;
                    top: -25px;
                    width: 14%
                }
                .footer-top .social-icons {
                    margin-top: -5px
                }
                .footer-bottom {
                    background-color: #191919;
                    font-size: 0.875rem;
                    border-top: 1px solid #353535;
                    padding: 30px 0;
                    position: relative;
                }
                .footer-bottom p {
                    font-weight: 200;
                    line-height: 38px;
                    margin-bottom: 0;
                    letter-spacing:0.6px;
                    text-align: center;
                    font-size: 14px;
                }
                .scrollup {
                    background: rgba(0, 0, 0, 0) url('assets/images/top-move.png') no-repeat scroll 0 0;
                    bottom: 28px;
                    display: none;
                    height: 40px;
                    opacity: 0.9;
                    outline: medium none !important;
                    position: fixed;
                    right: 15px;
                    text-indent: -9999px;
                    width: 40px;
                }
                /******************* breadcrum ***********************/
                #breadcrum-inner-block {
                    padding: 85px 0px;
                    background: url(assets/images/listing-detail.jpg) center top no-repeat;
                    background-size: cover;
                    background-attachment: fixed;
                    background-size: 100% auto;
                }
                .breadcrum-inner-header {
                    text-align: left;
                    padding-left: 20px;
                }
                .breadcrum-inner-header::before {
                    background-color: #f9c841;
                    bottom: 2px;
                    content: '';
                    left: 15px;
                    position: absolute;
                    top: 2px;
                    width: 4px;
                }
                .breadcrum-inner-header h1 {
                    font-family:'Raleway', sans-serif;
                    color: #ffffff;
                    letter-spacing:0.6px;
                    margin: 0px;
                    font-size: 32px;
                    font-weight: 700;
                    text-transform: uppercase;
                    margin-bottom: 10px;
                }
                .breadcrum-inner-header a {
                    font-family: 'Open Sans', sans-serif;
                    color: #ffffff;
                    font-size: 14px;
                    font-weight: 500;
                    text-transform: uppercase;
                }
                .breadcrum-inner-header i.fa {
                    color: #ffffff;
                    margin: 0px 5px;
                    font-size: 6px;
                    position: relative;
                    bottom: 2px;
                }
                .breadcrum-inner-header a span {
                    color: $color;
                    font-size: 14px;
                    font-weight: 600;
                }
                @media(min-width:200px) and (max-width:1199px) {
                #breadcrum-inner-block {
                    background-size: 100% 100%;
                    background-attachment: scroll;
                }
                }
                /**************************** about company ********************************/
                #about-company {
                    background: #ffffff;
                    padding: 80px 0 0 0;
                }
                .about-heading-title {
                    margin-bottom: 35px;
                }
                .about-heading-title h1 {
                    font-family:'Raleway', sans-serif;
                    margin: 0px;
                    color: #01273a;
                    text-transform: uppercase;
                    font-weight: 700;
                    font-size: 28px;
                }
                .about-heading-title h1 span {
                    color: $color;
                }
                p.inner-secon-tl {
                    font-family: 'Raleway', sans-serif;
                    color: #7e7e7e;
                    font-size: 14px;
                    line-height: 27px;
                    font-weight: 500;
                    letter-spacing:0.5px;
                }
                .user-lt-above img {
                    transform: translateX(-5%);
                    vertical-align: bottom;
                }
                @media(min-width:979px) and (max-width:1199px) {
                .user-lt-above img {
                    transform: translateY(16%);
                    vertical-align: bottom;
                }
                #about-company {
                    padding-bottom: 30px;
                }
                }
                /******************************* featured service block **************************************/
                #featured-service-block {
                    background: #f2f2f2;
                    padding: 80px 0 60px 0;
                    border-top: 1px solid #e4e4e4;
                }
                .service-item-fearured {
                    background: rgba(255, 255, 255, 0.8);
                    box-shadow: 0 1px 14px 2px rgba(0, 0, 0, 0.05);
                    padding: 30px 30px 20px;
                    margin-bottom: 30px;
                    border:1px solid rgba(0, 0, 0, 0.07);
                }
                .service-item-fearured:hover {
                    background: #01273a;
                    border: 1px solid rgba(1, 39, 58, 0.2);
                    box-shadow: 0 3px 14px 3px rgba(0, 0, 0, 0.3);
                    -webkit-transform: scale(1.05);
                    transform: scale(1.05);
                    -webkit-transition: ease-out 1.0s;
                    -moz-transition: ease-out 1.0s;
                    -o-transition: ease-out 1.0s;
                    transition: ease-out 1.0s;
                    transition: all 1.0s ease-in-out 0;
                }
                .svt-spec-service-icon {
                    margin-bottom: 25px;
                }
                .svt-spec-service-icon i {
                    background: $color;
                    border-radius: 50%;
                    color: #fff;
                    display: block;
                    font-size: 40px;
                    height: 90px;
                    line-height: 92px;
                    margin: 0 auto;
                    text-align: center;
                    width: 90px;
                }
                .service-item-fearured h3 {
                    font-family: 'Raleway',sans-serif;
                    color: #4a4a4a;
                    font-size: 18px;
                    font-weight: 600;
                    margin-bottom: 20px;
                    margin-top: 10px;
                    text-align: center;
                    text-transform:uppercase;
                }
                .service-item-fearured p {
                    font-family: 'Raleway', sans-serif;
                    color:#999999;
                    font-size: 13px;
                    font-weight: 500;
                    line-height: 24px;
                    text-align: center;
                    letter-spacing:0.2px;
                }
                .service-item-fearured:hover h3, .service-item-fearured:hover p {
                    color: #ffffff;
                }
                .service-item-fearured:hover .hi-icon-effect-8 .hi-icon {
                    background: $color;
                    color: #ffffff; 
                    cursor: pointer;
                }
                .service-item-fearured:hover .hi-icon-effect-8 .hi-icon::after {
                    animation: 1.3s ease-out 75ms normal none 1 running sonarEffect
                }
                /**************************** Login Forms and Register Form Style ***************************/
                #m-info-window .info-window-hding {
                    margin-top: 0px;
                    font-size: 16px;
                }
                #m-info-window .info-window-desc {
                    margin-bottom: 0px;
                    line-height: 1.6em;
                }
                .modal-open .modal {
                    overflow-x: hidden;
                    overflow-y: auto;
                }
                .modal-dialog {
                    margin: 78px auto;
                    width: 600px;
                }
                .modal {
                    background: rgba(0, 0, 0, 0.7) none repeat scroll 0 0;
                    bottom: 0;
                    display: none;
                    left: 0;
                    outline: 0 none;
                    overflow: hidden;
                    position: fixed;
                    right: 0;
                    top: 0;
                    z-index: 1050;
                }
                .modal.in .modal-dialog {
                    transform: translate(0px, 0px);
                }
                .modal.fade .modal-dialog {
                    transform: translate(0px, 0%);
                    transition: transform 0.3s ease-out 0s;
                }
                .listing-modal-1.modal-dialog {
                    width: 395px;
                }
                .listing-modal-1 .modal-content {
                    background: #f7fbfc none repeat scroll 0 0;
                    border-radius: 0;
                    padding: 40px 30px;
                }
                .modal-content {
                    background-clip: padding-box;
                    background-color: #fff;
                    border: 1px solid rgba(0, 0, 0, 0.2);
                    border-radius: 6px;
                    box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
                    outline: 0 none;
                    position: relative;
                }
                .listing-modal-1 .modal-header {
                    border-bottom: medium none;
                    padding: 0;
                }
                .modal-header {
                    border-bottom: 1px solid #e5e5e5;
                    min-height: 16.43px;
                    padding: 15px;
                }
                .listing-modal-1 .modal-header .close {
                    color: #08c2f3;
                    font-size: 24px;
                    line-height: 1;
                    margin-top: 3px;
                    opacity: 1;
                }
                button.close {
                    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
                    border: 0 none;
                    cursor: pointer;
                    padding: 0;
                }
                .close {
                    color: #000;
                    float: right;
                    font-size: 21px;
                    font-weight: 700;
                    line-height: 1;
                    opacity: 0.2;
                    text-shadow: 0 1px 0 #fff;
                }
                .listing-modal-1 .modal-header .modal-title {
                    color: #08c2f3;
                    line-height: 1;
                    text-align: left;
                }
                .modal-title {
                    line-height: 1.42857;
                    margin: 0;
                }
                .listing-modal-1 .modal-body {
                    padding: 30px 0 0;
                }
                .listing-form-field {
                    position: relative;
                }
                .listing-form-field input.form-field {
                    border: 1px solid #eee;
                    box-shadow: none;
                    margin-bottom: 10px;
                    padding: 15px;
                }
                .listing-form-field input {
                    text-transform: capitalize;
                    width: 100%;
                }
                input[type='checkbox'], input[type='radio'] {
                    line-height: normal;
                    margin: 4px 0 0;
                }
                .regular-checkbox {
                    display: none;
                }
                .regular-checkbox + label {
                    border: 2px solid $color;
                    display: inline-block;
                    height: 20px;
                    line-height: 20px;
                    position: relative;
                    top: -4px;
                    width: 20px;
                    border-radius:30px;
                }
                label.checkbox-lable {
                    color: #999;
                    position: relative;
                    top: -8px;
                }
                .listing-register-form .listing-form-field a {
                    color: $color;
                    float: none;
                    top: -8px;
                }
                .listing-modal-1.modal-dialog {
                    width: 395px;
                }
                .listing-modal-1 .modal-content {
                    background: #f7fbfc;
                    border-radius: 10px;
                    padding: 35px 30px;
                }
                .listing-form-field label {
                    margin-bottom: -1px;
                    font-weight:500;
                }
                .listing-modal-1 .modal-header {
                    border-bottom: medium none;
                    padding: 0;
                }
                .listing-modal-1 .modal-header .modal-title {
                    font-family: 'Open Sans', sans-serif;
                    color: $color;
                    line-height: 1;
                    text-align: left;
                    font-weight: 600;
                    display:block;
                    float:left;
                    text-transform: uppercase
                }
                .listing-modal-1 .modal-header .close {
                    background: #eaeaea;
                    border-radius: 20px;
                    color: #01273a;
                    font-size: 25px;
                    height: 36px;
                    line-height: 34px;
                    margin-top: -9px;
                    opacity: 1;
                    width: 36px;
                    display: block;
                }
                .listing-modal-1 .modal-body {
                    padding: 40px 0 0;
                }
                .listing-form-field {
                    position: relative;
                }
                .listing-form-field i {
                    background: #ededed;
                    font-size: 20px;
                    border-left: 1px solid #eee;
                    height: 51px;
                    line-height: 50px;
                    position: absolute;
                    right: 0;
                    text-align: center;
                    top: 0;
                    color: #c1c1c1;
                    width: 51px;
                }
                .listing-form-field input {
                    text-transform: capitalize;
                    width: 100%;
                }
                .listing-form-field input.form-field {
                    border: 1px solid #eee;
                    box-shadow: none;
                    margin-bottom: 10px;
                    padding: 15px;
                }
                .listing-form-field a {
                    font-family: 'Open Sans', sans-serif;
                    display: inline-block;
                    float: right;
                    position: relative;
                    text-align: right;
                    top: -4px;
                    color: $color;
                }
                .listing-register-form .listing-form-field a {
                    color: $color;
                    float: none;
                    top: -8px;
                }
                .listing-form-field input.submit {
                    border: medium none;
                    border-radius: 4px;
                    color: #fff;
                    text-transform: uppercase;
                }
                .regular-checkbox:checked + label::after {
                    color: $color;
                    content: '✔';
                    font-size: 12px;
                    left: 0;
                    line-height: 20px;
                    position: absolute;
                    right: 0;
                    text-align: center;
                    top: -2px;
                }
                label.checkbox-lable {
                    font-family: 'Open Sans', sans-serif;
                    color: #999;
                    position: relative;
                    top: -8px;
                    margin-left: 5px;
                }
                .listing-register-form .listing-form-field a {
                    color: $color;
                    float: none;
                    top: -8px;
                }
                .listing-register-form .listing-form-field a:hover {
                    color: #999999;
                    text-decoration: underline !important;
                }
                .listing-form-field input {
                    text-transform: capitalize;
                    width: 100%;
                }
                .bottom-links p {
                    font-family: 'Open Sans', sans-serif;
                    text-align: left;
                    text-transform: capitalize;
                }
                .bottom-links p a {
                    color: $color;
                    display: inline-block;
                    margin-left: 10px;
                }
                .bottom-links p a:hover {
                    color: #999999;
                    text-decoration: underline !important;
                }
                .bgwhite {
                    background: #fff none repeat scroll 0 0;
                }
                .margin-top-20 {
                    margin-top: 20px;
                }
                .margin-bottom-20 {
                    margin-bottom: 20px;
                }
                .listing-form-field input.submit {
                    background: transparent linear-gradient(to right, #01273a 50%, $color 50%) repeat scroll right bottom / 207% 100%;
                    border: none;
                    border-radius: 4px;
                    font-weight: 600;
                    color: #01273a;
                    text-transform: uppercase;
                    -webkit-transition: all .6s ease 0;
                    transition: all .6s ease 0;
                    text-transform: uppercase;
                    transition: all 0.3s ease 0s;
                }
                .listing-form-field input.submit:hover {
                    background-position: left bottom;
                    color: #ffffff;
                }
                .listing-form-field input.form-field {
                    font-family:'Raleway', sans-serif;
                    box-shadow: none;
                    font-weight:600;
                    margin-bottom: 10px;
                    padding: 14px;
                }
                .listing-form-field input.form-field:focus{ 
                    box-shadow:0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px rgba(102, 175, 233, 0.6);
                    outline:0 none;
                }
                .listing-form-field input {
                    text-transform: capitalize;
                    width: 100%;
                }
                .listings-images {
                    margin-right: 3px;
                    overflow: hidden;
                    position: relative;
                }
                .listings-images img {
                    height: 450px;
                    transition: all 0.5s ease 0s;
                }
                .listings-images:hover img {
                    transform: scale(1.2);
                }
                .listings-images1 {
                    display: inline-block;
                    margin-bottom: 3px;
                    float: left;
                    margin-right: 3px;
                    overflow: hidden;
                    position: relative;
                }
                .listings-images1 img {
                    transition: all 0.5s ease 0s;
                }
                .listings-images1:hover img {
                    transform: scale(1.2);
                }
                .listing-detail {
                    position: relative;
                    width: 100%;
                    display: inline-block;
                    margin-top: 15px;
                }
                .listing-detail h1 {
                    color: #242424;
                    font-weight: 500;
                    font-size: 18px;
                    text-transform: uppercase;
                    margin: 0px;
                }
                .listing-detail-text {
                    position: relative;
                    display: inline-block;
                    width: 100%;
                    margin-bottom: 5px;
                    background: #ffffff;
                    border: 1px solid #e8e8e8;
                }
                .listing-detail-text h1 {
                    margin: 0px;
                    color: #636363;
                    text-transform: capitalize;
                    font-weight: normal;
                    padding: 10px 14px 10px 14px;
                    font-size: 14px;
                    line-height: 20px;
                }
                .listing-detail-text p {
                    margin: 0px;
                    color: #999999;
                    font-size: 14px;
                    padding: 10px 14px 10px 14px;
                    border-left: 1px solid #e8e8e8;
                    text-transform: capitalize;
                }
                .listing-detail-text p span i.fa {
                    color: $color;
                }
                .listing-detail-text p i.fa-map-marker, .listing-detail-text p a {
                    color: #999999;
                    margin-right: 5px;
                }
                #tags-share {
                    margin-top: 45px;
                    position: relative;
                    display: inline-block;
                    width: 100%;
                }
                #listings-tags p {
                    color: #636363;
                    margin: 0px;
                    font-size: 14px;
                    text-transform: capitalize;
                }
                #listings-tags p i.fa {
                    color: #636363;
                    margin-right: 10px;
                }
                #listings-tags p span {
                    margin-left: 30px;
                }
                #listings-tags p span a {
                    color: #999999;
                    display: inline-block;
                    font-size: 14px;
                    padding: 10px 12px;
                    background: #ffffff;
                    border-radius: 3px;
                    margin-bottom: 5px;
                }
                #listings-tags p span a:hover {
                    color: #ffffff;
                }
                #listings-share p {
                    color: #636363;
                    margin: 0px;
                    font-size: 14px;
                    text-transform: capitalize;
                    display: inline-block;
                }
                #listings-share p i.fa {
                    color: #636363;
                    margin-right: 10px;
                }
                #listings-share .social {
                    margin: 0px 30px 0px 30px;
                    display: inline-block;
                }
                #listings-share .social a {
                    background: #ffffff;
                    color: #cccccc;
                }
                #listings-share .social a:hover {
                    color: #ffffff;
                }
                /************************ reviews section *********************/
                #reviews-section {
                    background: #ffffff;
                    padding: 50px 0px;
                    border-bottom: 2px solid $color;
                }
                .reviews-section, .reviews-section-new {
                    position: relative;
                    display: inline-block;
                    width: 100%;
                    padding: 10px 0px;
                }
                .reviews-section-new {
                    padding: 30px 0px;
                }
                .reviews-section-text h1 {
                    margin: 0px !important;
                }
                .reviews-section-text h1 a {
                    color: #000000;
                    font-weight: 500;
                    margin: 0px;
                    font-size: 16px;
                    text-transform: capitalize;
                }
                .reviews-section-text h4 {
                    font-weight: normal;
                    color: #636363;
                    margin: 7px 0px;
                    text-transform: uppercase;
                    font-size: 12px;
                }
                .reviews-section-text p {
                    color: #636363;
                    font-size: 14px;
                    margin: 0px;
                    line-height: 25px;
                }
                .reviews-section-text p a {
                    margin-left: 10px;
                    color: #636363;
                }
                .reviews-section-text p a:hover, .reviews-section-text h1 a:hover {
                    color: $color;
                }
                #write-review h1, #reviews h1 {
                    color: #242424;
                    font-weight: 500;
                    text-transform: uppercase;
                    font-size: 18px;
                    margin: 0px;
                    border-left: 2px solid $color;
                    padding: 5px 15px;
                }
                #write-review hr, #reviews hr, .contact-heading hr {
                    border-color: #e8e8e8;
                }
                #review-form, #contact-form {
                    position: relative;
                    display: inline-block;
                    margin-top: 15px;
                    width: 100%;
                }
                .review-form .form-control, .contact-form .form-control {
                    height: 45px;
                    border: 1px solid #cccccc;
                    border-left-color: $color;
                    font-size: 14px;
                    transition: all 0.3s ease 0s;
                    -webkit-transition: all 0.3s ease 0s;
                    -moz-transition: all 0.3s ease 0s;
                    margin-bottom: 30px;
                    padding: 10px 12px;
                }
                .contact-form .form-control {
                    background: transparent;
                }
                .review-form .form-control:focus, .contact-form .form-control:focus {
                    border-color: $color;
                }
                .review-form textarea.form-control {
                    height: 170px !important;
                }
                .contact-form textarea.form-control {
                    height: 235px !important;
                }
                #review-button, #contact-button {
                    display: inline-block;
                    width: 100%;
                    margin-top: 15px;
                }
                #review-button button, #contact-button button {
                    background: -webkit-linear-gradient(left, #262626 50%, $color 50%) repeat scroll right bottom/207% 100% transparent;
                    background: linear-gradient(to right, #262626 50%, $color 50%) repeat scroll right bottom/207% 100% transparent;
                    color: #ffffff;
                    border-radius: 4px;
                    border: none;
                    outline: 0 !important;
                    font-weight: 500;
                    font-size: 14px;
                    padding: 10px 25px;
                    -webkit-transition: background 350ms ease-in-out;
                    transition: background 350ms ease-in-out;
                }
                #review-button button:hover, #contact-button button:hover {
                    background-position: left bottom;
                }
                /************************** contact section *********************/
                #contact-section {
                    padding: 60px 0px;
                    background: #f7f7f7;
                }
                .contact-heading {
                    position: relative;
                    width: 100%;
                    display: inline-block;
                }
                .contact-heading h1 {
                    margin: 0px;
                    text-transform: uppercase;
                    padding: 5px 15px;
                    border-left: 2px solid $color;
                    font-weight: 500;
                    font-size: 18px;
                    color: #242424;
                }
                #contact-section-info p {
                    margin: 0px 0px 10px;
                    color: #636363;
                    font-size: 14px;
                    margin-top: 12px;
                }
                .contact-text .social {
                    margin-top: 15px;
                }
                .contact-text .social a {
                    background: #ffffff;
                    color: #cccccc;
                    height: 30px;
                    width: 30px;
                    line-height: 30px;
                }
                .contact-text .social a:hover {
                    color: #ffffff;
                }
                .contact-icon i.fa {
                    font-size: 20px !important;
                }
                .contact-icon .fa.fa-share-alt {
                    font-size: 16px !important;
                }
                #contact-map {
                    border-bottom: 2px solid $color;
                }
                /******************** listing section ********************/
                #listing-section {
                    background: #f7f7f7;
                    padding-bottom: 55px;
                    border-bottom: 2px solid $color;
                }
                .sorts-by-results {
                    border: 1px solid #ededed;
                    background: #f1f1f1;
                    border-radius: 6px;
                    display: block;
                    float: left;
                    margin-bottom: 30px;
                    position: relative;
                    white-space: nowrap;
                    height: auto;
                    line-height: 42px;
                    padding: 12px;
                    width: 100%;
                }
                .sorts-by-results span.result-item-view {
                    font-family: 'Open Sans', sans-serif;
                    font-size: 14px;
                    font-weight:600;
                    color:#6b6b6b;
                }
                .sorts-by-results span.result-item-view span.yellow {
                    color: $color;
                    font-weight: 700;
                }
                .sorts-by-results .disp-f-right {
                    float: right;
                }
                .disp-f-right .disp-style {
                    float: left;
                    margin: 3px 5px 0 5px;
                }
                .disp-f-right .disp-style:last-child {
                    margin-right: 0px;
                }
                .sorts-by-results .disp-style a {
                    background: #fcfcfc;
                    border-radius: 5px;
                    border: 2px solid transparent;
                    float: right;
                    font-size: 14px;
                    line-height: 32px;
                    padding: 0px 9px;
                    color: #01273a;
                }
                .sorts-by-results .disp-style a:hover {
                    border: 2px solid rgba(255, 193, 7, 0.9);
                    color: $color;
                    box-shadow: 0 1px 6px rgba(0, 0, 0, 0.2);
                }
                .sorts-by-results .disp-style.active a {
                    border: 2px solid rgba(255, 193, 7, 0.9);
                    color: $color;
                    box-shadow: 0 1px 6px rgba(0, 0, 0, 0.2);
                }
                .list-view-item {
                    padding: 5px;
                }
                .list-view-item .listing-boxes-text p {
                    min-height: 90px;
                    height: 90px;
                }
                .list-view-item .listing-boxes-text p:before {
                    background: rgba(0, 0, 0, 0) linear-gradient(to bottom, rgba(255, 255, 255, 0), rgba(255, 255, 255, 1)) repeat scroll 0 0
                }
                .list-view-item:hover {
                    border: 1px solid $color;
                    box-shadow: 0 0px 15px rgba(0, 0, 0, 0.2);
                }
                .list-view-item.active {
                    border: 1px solid $color;
                    box-shadow: 0 0px 15px rgba(0, 0, 0, 0.2);
                }
                .list-view-item.active .recent-listing-box-item a h3 {
                    color: $color;
                }
                .list-view-item.active .recent-listing-box-item a, .list-view-item.active .recent-listing-box-item a i {
                    color: #969595;
                }
                .list-view-item:hover .recent-listing-box-item a h3 {
                    color: #4a4a4a;
                }
                .vfx-person-block {
                    margin: 0 auto;
                    text-align: center;
                    width: 100%;
                    float: left;
                }
                .vfx-pagination {
                    border-radius: 0.25rem;
                    display: inline-flex;
                    list-style-type: none;
                    margin: 15px 0;
                }
                ul.vfx-pagination a {
                    background-color: #35385b;
                    border: medium none;
                    border-radius: 30px;
                    color: #fff;
                    float: left;
                    padding: 10px;
                    display: inline-block;
                    font-size: 14px;
                    font-weight: 700;
                    height: 34px;
                    line-height: 12px;
                    transition: all 0.2s linear 0s;
                    width: 34px;
                }
                ul.vfx-pagination li {
                    margin: 0 4px;
                }
                ul.vfx-pagination li.active a, ul.vfx-pagination li:hover a {
                    background-color: #00283b;
                    border: 0 none;
                    color: #fff;
                    border-radius: 30px;
                }
                /************************** add listings ***********************/
                #add-listings {
                    background: #f7f7f7;
                    padding: 60px 0px;
                    border-bottom: 2px solid $color;
                }
                #user-option {
                    background: #ffffff;
                    padding: 50px 30px;
                    display: inline-block;
                    width: 100%;
                    height: 300px;
                }
                #user-option h1 {
                    margin: 0px;
                    font-size: 18px;
                    font-weight: 500;
                    text-transform: uppercase;
                    color: #242424;
                }
                #user-option hr {
                    border-color: #e8e8e8;
                }
                #user-option p {
                    color: #636363;
                    font-size: 16px;
                    margin: 0px;
                    padding-top: 10px;
                }
                #user-option p span {
                    text-transform: capitalize;
                    color: #242424;
                    cursor: pointer;
                    font-weight: normal;
                    transition: all 0.3s ease 0s;
                }
                #user-option p span.selected {
                    color: $color !important;
                }
                #user-signup, #user-signin {
                    margin-top: 30px;
                    display: inline-block;
                    width: 100%;
                    transition: all 0.3s ease 0s;
                }
                #user-signup .form-group, #user-signin .form-group, #title-form .form-group {
                    margin-bottom: 0px;
                }
                #user-signup .form-control, #user-signin .form-control, #title-form .form-control, #locations .form-control {
                    border-color: #cccccc;
                    background: transparent;
                    padding-left: 20px;
                    height: 45px;
                    line-height: 30px;
                }
                .hide-form {
                    display: none !important;
                    transition: all 0.3s ease 0s;
                }
                #enter-listings {
                    padding: 50px 30px 20px;
                    margin-top: 40px;
                    background: #ffffff;
                    display: inline-block;
                    width: 100%;
                }
                #enter-listings h1 {
                    margin: 0px;
                    font-size: 18px;
                    font-weight: 500;
                    text-transform: uppercase;
                    color: #242424;
                }
                #enter-listings hr {
                    border-color: #e8e8e8;
                }
                #title-form {
                    margin-top: 10px;
                    display: inline-block;
                    width: 100%;
                }
                #title-form input {
                    margin-bottom: 30px;
                }
                .detail-content h2 {
                    color: #313131;
                    font-size: 22px;
                    font-weight: 500;
                    line-height: 24px;
                    margin: 20px 0 30px;
                }
                .detail-content .detail-amenities {
                    list-style: outside none none;
                    margin-bottom: 20px;
                    margin-top:30px;
                    padding-left: 0;
                }
                .detail-content .detail-amenities li {
                    width: 31%;
                }
                .detail-content .detail-amenities li.yes::before {
                    background-color: $color;
                    border-color: $color;
                    color: #ffffff;
                    content: '';
                }
                .detail-content .detail-amenities li::before {
                    background-color: #01273a;
                    border: 2px solid #01273a;
                    border-radius: 3px;
                    color: #ffffff;
                    content: '';
                    display: inline-block;
                    font-family: fontawesome;
                    font-size: 10px;
                    height: 16px;
                    line-height: 1;
                    margin-right: 10px;
                    text-align: center;
                    vertical-align: 2px;
                    width: 16px;
                }
                .detail-content .detail-amenities li {
                    display: inline-block;
                    font-size: 14px;
                    line-height: 40px;
                    color: #696969;
                    font-weight: 500;
                    margin-right: 10px;
                }
                .dlt-title-item {
                    margin-bottom: 25px;
                }
                .dlt-title-item h2 {
                    color: #4a4a4a;
                    font-size: 22px;
                    font-weight: 600;
                    line-height: 30px;
                    margin-bottom: 5px;
                }
                .dlt-title-item div {
                    color: #696969;
                    display: inline-block;
                    font-size: 13px;
                    font-weight: 500;
                    letter-spacing: 0.5px;
                    line-height: 18px;
                    padding-bottom: 6px;
                    text-transform: uppercase;
                }
                .dlt-title-item div span {
                    font-family: 'Open Sans', sans-serif;
                    color: #ffbf02;
                }
                .dlt-title-item p {
                    margin-top: 25px;
                    color: #696969;
                    font-size: 14px;
                    font-weight: 500;
                    line-height: 28px;
                    letter-spacing:0.5px;
                }
                .dlt-title-item ul {
                    list-style: none;
                    margin-bottom: 30px;
                }
                .dlt-title-item ul li {
                    list-style-image: url(assets/images/ic_right.png);
                    list-style-position: inside;
                    color: #696969;
                    font-size: 14px;
                    font-weight: 500;
                    line-height: 30px;
                    letter-spacing:0.5px;
                }
                .dlt-spons-item {
                    display: inline-block;
                    margin-bottom: 30px;
                    width: 100%;
                }
                .dlt-spons-item a:first-child {
                    margin-left: 0;
                }
                .dlt-spons-item a {
                    background: transparent linear-gradient(to right, $color 50%, #f1f1f1 50%) repeat scroll right bottom / 207% 100%;
                    color:#696969;
                    display: inline-block;
                    font-size: 14px;
                    margin: 0 5px;
                    padding: 7px 15px;
                    font-weight: 500;
                    border-radius: 2px;
                    -webkit-transition: all .6s ease 0;
                    transition: all .6s ease 0;
                    transition: all 0.3s ease 0s;
                }
                .dlt-spons-item a:hover {
                    background: transparent linear-gradient(to right, $color 50%, #f1f1f1 50%) repeat scroll right bottom / 207% 100%;
                    color: #ffffff;
                    background-position: left bottom;
                }
                .dlt-spons-item a.active {
                    background: transparent linear-gradient(to right, #f1f1f1 50%, $color 50%) repeat scroll right bottom / 207% 100%;
                    color: #ffffff;
                }
                .dlt-com-lt-block {
                    background: #f8f8f8;
                    border: 1px solid #f5f5f5;
                    float: left;
                    padding: 30px;
                    width: 100%;
                }
                .dlt-com-lt-img img {
                    border: 2px solid #e1e1e1;
                    border-radius: 50%;
                    height: auto;
                    width: 150px;
                }
                .dlt-com-lt-img {
                    display: block;
                    float: left;
                    margin-right: 20px;
                }
                .dlt-com-lt-img .social-icons {
                    margin: 15px auto 0;
                    text-align: center;
                }
                .social-icons li {
                    display: inline-block;
                    margin-bottom: 0.125rem;
                }
                .dlt-com-lt-img .social-icons a {
                    background: transparent linear-gradient(to right, #ffffff 50%, $color 50%) repeat scroll right bottom / 207% 100%;
                    border: 1px solid $color;
                    border-radius: 100%;
                    color: #fff;
                    margin: 0 5px;
                    width: 36px;
                    height: 36px;
                    line-height: 34px;
                    font-size: 16px;
                    -webkit-transition: all .6s ease 0;
                    transition: all .6s ease 0;
                    transition: all 0.3s ease 0s;
                }
                .dlt-com-lt-img .social-icons a:hover {
                    background: transparent linear-gradient(to right, #ffffff 50%, $color 50%) repeat scroll right bottom / 207% 100%;
                    border: 1px solid $color;
                    border-radius: 100%;
                    background-position: left bottom;
                    color: $color;
                }
                .dlt-com-lt-text {
                    color: #969696;
                    font-size: 14px;
                    padding-left: 180px;
                    text-align: left;
                }
                .dlt-com-lt-title {
                    color: #4a4a4a;
                    float: left;
                    font-size: 24px;
                    font-weight: 600;
                    margin-bottom: 4px;
                    padding-left: 3px;
                    width: 100%;
                }
                .dlt-com-clt {
                    color: $color;
                    font-size: 13px;
                    font-weight:500;
                    margin-bottom: 15px;
                }
                .dlt-com-lt-block p {
                    color: #969595;
                    font-size: 14px;
                    line-height: 26px;
                    font-weight:500;
                    letter-spacing:0.5px
                }
                .dlt-com-lt-comment-user {
                    display: block;
                    float: left;
                }
                .dlt-com-lt-comment-user h2 {
                    color: #4a4a4a;
                    font-size: 22px;
                    font-weight: 600;
                    line-height: 30px;
                    margin: 20px 0 30px;
                }
                .comments-wrapper {
                    float: left;
                    margin-top: 20px;
                    width: 100%;
                }
                .comments-wrapper h2 {
                    color: #313131;
                    font-size: 24px;
                    font-weight: 400;
                    line-height: 24px;
                    margin: 20px 0 30px;
                }
                .comments-wrapper .media {
                    background-color: #fff;
                    border: 1px solid #eee;
                    margin-top: 40px;
                    overflow: visible;
                    position: relative;
                }
                .media {
                    display: flex;
                    margin-bottom: 1rem;
                }
                .comments-wrapper .media-body, .media-left, .media-right {
                    display: table-cell;
                    vertical-align: top;
                }
                .comments-wrapper .media-body, .media-left, .media-right {
                    display: table-cell;
                    vertical-align: top;
                }
                .comments-wrapper .media .media-left img {
                    background: #fff none repeat scroll 0 0;
                    border-color: -moz-use-text-color #eee #eee;
                    border-image: none;
                    border-style: none solid solid;
                    border-width: 0 1px 1px;
                    border-color:#eeeeee;
                    bottom: -13px;
                    height: 56px;
                    left: -1px;
                    padding: 0 8px 8px;
                    position: absolute;
                    width: 65px;
                }
                .comments-wrapper .media-body p {
                    font-size: 13px;
                    font-weight: 500;
                    line-height: 24px;
                    color: #969595;
                    margin: 0;
                    padding: 20px 25px 20px 15px;
                    text-align: justify;
                    letter-spacing:0.4px
                }
                .comment-meta {
                    background: #f9f9f9 none repeat scroll 0 0;
                    border-top: 1px solid #eee;
                    color: #969595;
                    font-size: 10px;
                    padding: 8px 15px 8px 65px;
                }
                .comment-meta a {
                    font-weight:600;
                    color: #01273a;
                }
                .comment-meta .author-name {
                    font-size: 14px;
                    margin-right: 5px;
                }
                .comment-meta .rating-box {
                    margin-left: 20px;
                    margin-bottom: 0;
                    vertical-align: middle;
                }
                .comment-meta .rating {
                    color: #f9a630;
                    vertical-align: middle;
                }
                .comment-meta .rating i {
                    font-size: 16px;
                }
                span.comment-lt-time {
                    color: #969595;
                    font-size: 12px;
                }
                .comment-meta .comment-reply-link {
                    background: transparent linear-gradient(to right, $color 50%, #ffffff 50%) repeat scroll right bottom / 207% 100%;
                    border: 1px solid #eee;
                    color: #969595;
                    padding: 5px 15px;
                    text-transform: uppercase;
                    -webkit-transition: all .6s ease 0;
                    transition: all .6s ease 0;
                    transition: all 0.3s ease 0s;
                }
                .comment-meta .comment-reply-link:hover {
                    background: transparent linear-gradient(to right, $color 50%, #ffffff 50%) repeat scroll right bottom / 207% 100%;
                    color: #00283b;
                    background-position: left bottom;
                }
                .comment-respond .form-group {
                    margin-bottom: 20px;
                }
                .comment-respond {
                    margin-top: 50px;
                }
                .comments-wrapper h2 {
                    color: #4a4a4a;
                    font-size: 22px;
                    font-weight: 600;
                    line-height: 30px;
                    margin: 20px 0 30px;
                }
                .comments-wrapper .form-control {
                    background-color: #f9f9f9;
                    border: 1px solid #f1f1f1;
                    border-radius: 0;
                    display: block;
                    font-size: 14px;
                    height: 46px;
                    line-height: 24px;
                    font-weight: 500;
                    padding: 15px 20px;
                    color: #969595;
                    transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
                    width: 100%;
                    box-shadow: none;
                }
                .comments-wrapper .form-control:focus {
                    border-color: $color;
                    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px rgba(102, 175, 233, 0.6);
                    outline: 0 none;
                }
                .comments-wrapper textarea.form-control {
                    height: auto;
                }
                .comments-wrapper .comment-respond .btn {
                    background: transparent linear-gradient(to right, $color 50%, $color 50%) repeat scroll right bottom / 207% 100%;
                    border-radius: 0;
                    color: #01273a;
                    font-size: 16px;
                    font-weight: 700;
                    height: 44px;
                    border-radius: 6px;
                    letter-spacing: 0.6px;
                    padding: 0 40px;
                    box-shadow: 0 3px 1px rgba(0, 0, 0, 0.25);
                    text-align: center;
                    text-transform: uppercase;
                    transition: all 0.2s linear 0s;
                    -webkit-transition: all .6s ease 0;
                    transition: all .6s ease 0;
                    transition: all 0.3s ease 0s;
                }
                .comments-wrapper .comment-respond .btn:hover {
                    background: transparent linear-gradient(to right, #01273a 50%, #dadada 50%) repeat scroll right bottom / 207% 100%;
                    color: #ffffff;
                    background-position: left bottom;
                    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.25)
                }
                .mce-tinymce iframe {
                    height: 220px !important;
                }
                #mceu_14-body, #mceu_28-body {
                    display: none !important;
                }
                .mce-btn {
                    background: #e8e8e8 !important;
                }
                div.mce-edit-area {
                    border: 1px solid #cccccc !important;
                    border-top: none !important;
                }
                .mce-panel {
                    background-color: #e8e8e8 !important;
                    border: 0 solid rgba(0, 0, 0, 0) !important;
                }
                .mce-container, .mce-container *, .mce-widget, .mce-widget *, .mce-reset {
                    color: #787878 !important;
                }
                #mceu_28 {
                    border-width: 0px !important;
                }
                .mce-toolbar-grp {
                    padding: 10px 0px !important;
                }
                .mce-btn-group:not(:first-child) {
                    border-left: none !important;
                }
                #mceu_22 > div {
                    display: none !important;
                }
                .mce-btn.mce-disabled button, .mce-btn.mce-disabled:hover button {
                    opacity: 1 !important;
                }
                /******************** tags *****************/
                .tagsinput {
                    min-height: auto !important;
                    margin-top: 30px !important;
                    height: 45px !important;
                    border-radius: 4px;
                    border: 1px solid #cccccc;
                }
                div.tagsinput input {
                    width: 100% !important;
                    margin-bottom: 0px !important;
                }
                div.tagsinput span.tag {
                    background: $color !important;
                    font-size: 12px;
                    color: #ffffff !important;
                    border: none !important;
                    border-radius: 4px;
                    margin: 3px 2px 0px 2px !important;
                }
                #tags_1_addTag > input {
                    color: #d0d0d0 !important;
                    font-size: 14px !important;
                }
                div.tagsinput span.tag a {
                    color: #ffffff !important;
                }
                div.tagsinput {
                    padding-left: 20px !important;
                }
                #select-category {
                    display: inline-block;
                    position: relative;
                    width: 100%;
                    margin-top: 30px;
                }
                #select-category select {
                    height: 45px;
                    color: #999999;
                    background: url(assets/images/slt_btn_cat.png) top 50% right 15px no-repeat !important;
                    margin-bottom: 25px;
                }
                #select-category select:disabled {
                    color: #d0d0d0 !important;
                    background: #e8e8e8 url(assets/images/slt_btn_cat.png) top 50% right 15px no-repeat !important;
                    border: none !important;
                }
                #location-detail {
                    padding: 50px 30px 50px;
                    margin-top: 40px;
                    background: #ffffff;
                    display: inline-block;
                    width: 100%;
                }
                #locations {
                    margin-top: 10px;
                    display: inline-block;
                    width: 100%;
                }
                .inner-addon i.fa {
                    bottom: 0;
                    color: #999999;
                    left: 3%;
                    position: absolute;
                    text-align: center;
                    top: 34%;
                }
                .inner-addon .form-control {
                    padding-left: 45px !important;
                    color: #c2c2c2;
                }
                #location-detail h1 {
                    margin: 0px;
                    font-size: 18px;
                    font-weight: 500;
                    text-transform: uppercase;
                    color: #242424;
                }
                #location-detail hr {
                    border-color: #e8e8e8;
                }
                #locations .form-group {
                    margin-bottom: 30px;
                }
                #locations .form-group .form-control {
                    color: #c2c2c2;
                }
                #gallery-images {
                    padding: 50px 30px 50px;
                    margin-top: 40px;
                    background: #ffffff;
                    display: inline-block;
                    width: 100%;
                }
                #gallery-images h1 {
                    margin: 0px;
                    font-size: 18px;
                    font-weight: 500;
                    text-transform: uppercase;
                    color: #242424;
                }
                #gallery-images hr {
                    border-color: #e8e8e8;
                }
                #gallery-images span {
                    display: inline-block;
                    color: #636363;
                    text-transform: capitalize;
                    font-size: 14px;
                    font-weight: 500;
                    margin-top: 20px;
                    cursor: pointer;
                }
                #add-images {
                    position: relative;
                    display: inline-block;
                    width: 100%;
                }
                .file-upload {
                    position: relative;
                    overflow: hidden;
                    width: 250px;
                    height: 250px;
                    background: #ffffff url(assets/images/add-image.png) top left no-repeat;
                    text-align: center;
                    margin-top: 20px;
                }
                .file-upload input.upload {
                    position: absolute;
                    top: 0;
                    right: 0;
                    margin: 0;
                    padding: 0;
                    font-size: 20px;
                    cursor: pointer;
                    opacity: 0;
                    filter: alpha(opacity=0);
                    height: 100%;
                    width: 100%;
                }
                #price-package {
                    padding: 50px 30px 50px;
                    margin-top: 40px;
                    background: #ffffff;
                    display: inline-block;
                    width: 100%;
                }
                #price-package h1 {
                    margin: 0px;
                    font-size: 18px;
                    font-weight: 500;
                    text-transform: uppercase;
                    color: #242424;
                }
                #price-package hr {
                    border-color: #e8e8e8;
                }
                #price-package p {
                    color: #636363;
                    font-size: 14px;
                    margin: 0px;
                    padding-top: 20px;
                }
                #packages {
                    margin: 30px 20px 0px;
                    color: #636363;
                    font-size: 14px;
                }
                input[type='checkbox'], input[type='radio'] {
                    margin-right: 10px;
                    margin-bottom: 15px;
                }
                input[type=radio]:checked {
                    color: $color !important;
                    background: $color !important;
                }
                #preview-add {
                    display: inline-block;
                    margin-top: 30px;
                }
                #preview-add button {
                    background: -webkit-linear-gradient(left, #262626 50%, $color 50%) repeat scroll right bottom/207% 100% transparent;
                    background: -o-linear-gradient(left, #262626 50%, $color 50%) repeat scroll right bottom/207% 100% transparent;
                    background: linear-gradient(to right, #262626 50%, $color 50%) repeat scroll right bottom/207% 100% transparent;
                    border: none;
                    color: #ffffff;
                    -webkit-transition: all 0.3s ease 0s;
                    -moz-transition: all 0.3s ease 0s;
                    -o-transition: all 0.3s ease 0s;
                    transition: all 0.3s ease 0s;
                    padding: 10px 20px;
                    font-weight: 500;
                    font-size: 14px;
                    text-transform: capitalize;
                    border-radius: 4px;
                    outline: 0 !important;
                }
                #preview-add button:hover {
                    background-position: left bottom;
                }
                /**************************** right side bar ***************************/
                #process, #sidebar-navigation {
                    padding: 40px 25px;
                    background: #ffffff;
                    display: inline-block;
                    width: 100%;
                }
                #scroll-element {
                    position: relative;
                }
                #sidebar-navigation {
                    margin-top: 30px;
                    display: none;
                }
                #process h1, #sidebar-navigation h1 {
                    margin: 0px;
                    font-size: 18px;
                    font-weight: 500;
                    text-transform: uppercase;
                    color: #242424;
                    padding-bottom: 30px;
                }
                #process a, #sidebar-navigation a {
                    color: #636363;
                    font-size: 14px;
                    text-transform: capitalize;
                    list-style: none;
                    padding: 0px;
                }
                #process-section a span {
                    /*color: $color; cambios_css*/
                    color: #e8eff6;
                    margin-right: 10px;
                }
                #process ul li a:hover, #process ul li a:focus, #process ul li a:active, #sidebar-navigation a:hover, .active a {
                    color: #fff;;
                    background-color: transparent;
                }
                #process hr, #sidebar-navigation hr {
                    border-color: #e8e8e8;
                }
                .navbar ul {
                    padding: 0;
                    list-style: none;
                }
                .navbar ul li {
                    display: inline-block;
                    position: relative;
                    line-height: 21px;
                    text-align: left;
                }
                .navbar ul li a {
                    display: block;
                    padding: 8px 25px;
                    color: #333;
                    text-decoration: none;
                }
                .navbar ul li a:hover {
                    color: #fff;
                    background: #939393;
                }
                ul.dropdown li a {
                    background: transparent linear-gradient(to right, $color 50%, #ffffff 50%) repeat scroll right bottom / 207% 100%;
                    text-transform: none !important;
                    width: 100%;
                    display: block;
                    transition: all .6s ease 0;
                    -webkit-transition: background 350ms ease-in-out;
                    transition: background 350ms ease-in-out;
                }
                ul.dropdown li a:hover {
                    background: transparent linear-gradient(to left, #ffffff 50%, $color 50%) repeat scroll left bottom / 207% 100% !important;
                    color: #262626 !important;
                    background-position: left bottom;
                }
                ul.dropdown i.fa {
                    color: #262626;
                    margin-right: 5px;
                }
                .navbar ul li ul.dropdown {
                    width: 230px; /* Set width of the dropdown */
                    background: #f2f2f2;
                    display: none;
                    position: absolute;
                    z-index: 999;
                    left: 0;
                    border: 5px solid rgba(0, 0, 0, 0.1);
                    line-height: 30px !important;
                }
                .navbar ul li ul.dropdown li a {
                    padding: 12px 10px !important;
                    width: 220px;
                    margin-bottom: 0 !important;
                }
                #nav_menu_list a i.fa {
                    margin-left: 5px;
                }
                .navbar ul li ul.dropdown li {
                    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
                }
                .navbar ul li ul.dropdown li:last-child {
                    border-bottom: 0px;
                    margin-bottom: 0px;
                }
                .navbar ul li:hover ul.dropdown {
                    display: block; /* Display the dropdown */
                }
                .navbar ul li ul.dropdown li {
                    display: block;
                    width: 220px;
                }
                .details-lt-block {
                    background: rgba(0, 0, 0, 0) url('assets/images/details-view.jpg') no-repeat;
                    background-attachment: fixed;
                    background-position: right center;
                    background-size: auto 100%;
                }
                .details-lt-block .slt_block_bg img {
                    height: auto;
                    width: 100%;
                }
                .slt_block_bg img {
                    position: relative;
                    z-index: -1;
                }
                .slt_block_bg {
                    background: rgba(0, 0, 0, 0) linear-gradient(to bottom, rgba(16, 14, 13, 0) 0%, rgba(16, 14, 13, 1) 100%) repeat scroll 0 0;
                    transition: all 0.3s ease 0s;
                }
                .header_slt_block {
                    position: relative;
                }
                .slt_item_head {
                    bottom: 30px;
                    position: absolute;
                    width: 100%;
                }
                .header_slt_block .user_logo_pic {
                    background: rgba(0, 0, 0, 0.15) linear-gradient(to bottom, rgba(16, 14, 13, 0.0) 0%, rgba(16, 14, 13, 0.8) 100%) repeat scroll 0 0;
                    border-radius: 10px;
                    height: 170px;
                    left: 0px;
                    padding: 10px;
                    position: relative;
                    text-align: center;
                    top: 0px;
                    width: 170px;
                    float: left;
                }
                .header_slt_block .user_logo_pic img {
                    border-radius: 10px;
                    height: auto;
                    margin: 0;
                    width: 100%;
                }
                .slt_item_contant {
                    float: left;
                    left: 175px;
                    margin-bottom: 10px;
                    margin-left: 25px;
                    position: absolute;
                }
                .slt_item_head h1 {
                    font-family: 'Open Sans', sans-serif;
                    color: #ffffff;
                    font-size: 38px;
                    margin-bottom: 10px;
                    margin-top: 0px;
                }
                .slt_item_head .location {
                    color: #fff;
                    margin-right: 15px;
                }
                .head-bookmark-bock {
                    float: left;
                    margin-top: 12px;
                    width: 100%;
                    line-height: 40px;
                    display: block;
                }
                .slt_item_head .detail-banner-btn {
                    display: inline-block;
                    margin-right: 15px;
                }
                .slt_item_head .detail-banner-btn a {
                    background: transparent linear-gradient(to right, #ffffff 50%, $color 50%) repeat scroll right bottom / 207% 100%;       
                    color: #01273a;
                    cursor: pointer;
                    padding: 9px 15px;
                    font-weight: 600;
                    font-size: 14px;
                    border-radius: 6px;
                    -webkit-transition: all .6s ease 0;
                    transition: all .6s ease 0;
                    transition: all 0.3s ease 0s;
                    text-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
                }
                .slt_item_head .detail-banner-btn a:hover {
                    background: transparent linear-gradient(to right, #ffffff 50%, $color 50%) repeat scroll right bottom / 207% 100%;
                    background-position: left bottom;   
                    color: #01273a;
                    -webkit-transition: all .6s ease 0;
                    transition: all .6s ease 0;
                    transition: all 0.3s ease 0s;
                }
                .slt_item_head .detail-banner-btn a:hover i {
                    color: #323232;
                }
                .rating-box, .venue-action {
                    color: #ffcc58;
                    margin-bottom: 5px;
                }
                .slt_item_head .detail-banner-btn {
                    color: #fff;
                    cursor: pointer;
                    font-family: 'Open Sans', sans-serif;
                    text-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
                }
                .slt_item_head .detail-banner-btn i {
                    font-size: 16px;
                    margin-right: 5px;
                    color: #01273a;
                }
                @media(min-width:980px) and (max-width:1199px) {
                .slt_item_head {
                    width: 100%;
                    left: 0;
                    padding: 0 10px;
                }
                .slt_item_head h1 {
                    font-size: 32px;
                }
                }
                @media(min-width:768px) and (max-width:979px) {
                .slt_item_head {
                    bottom: 15px;
                    width: 100%;
                    left: 0;
                    padding: 0 10px;
                }
                .slt_item_head h1 {
                    font-size: 26px;
                }
                }
                @media(max-width:640px) {
                .slt_item_head h1 {
                    color: #fff;
                    font-size: 24px;
                    margin-bottom: 10px;
                    margin-top: 10px;
                }
                .slt_item_head .location {
                    float: none;
                }
                }
                @media(max-width:767px) {
                .header_slt_block .user_logo_pic {
                    height: 130px;
                    left: 0px;
                    padding: 10px;
                    position: relative;
                    text-align: center;
                    top: 0;
                    float: none;
                    width: 130px;
                }
                .slt_item_contant {
                    float: none;
                    left: 0;
                    margin-bottom: 10px;
                    margin-left: 0px;
                    position: relative;
                }
                .slt_block_bg {
                    min-height: 400px;
                }
                .slt_item_head {
                    left: 0;
                    padding: 0 15px;
                    width: 100%;
                }
                .slt_item_head .detail-banner-btn {
                    margin-right: 10px;
                }
                }
                .sidebar-listing-search-wrap {
                    padding: 0px;
                    width: 100%;
                }
                .sidebar-listing-search-wrap form p {
                    font-size:14px;
                    font-weight: 600;
                    color: #7e7e7e;
                    margin-top: 15px;
                    text-align: left;
                }
                .sidebar-listing-search-wrap form select.sidebar-listing-search-select {
                    -moz-appearance: none;
                    border: medium none;
                    background: #f9f9f9 url('assets/images/form-icon-2.png') no-repeat scroll 100% 0px;
                    box-shadow: 0 0 0 1px #ececec;
                    color: #696969;
                    font-size: 14px;
                    height: 44px;
                    line-height: 56px;
                    margin-bottom: 8px;
                    margin-top: 8px;
                    padding: 0 0 0 10px;
                    font-weight:600;
                    text-overflow: '';
                    text-transform: capitalize;
                    width: 100%;
                }
                .sidebar-listing-search-wrap form select.sidebar-listing-search-select option {
                    background-color: #fff;
                    border-color: #f7f7f7 -moz-use-text-color -moz-use-text-color;
                    border-style: solid none none;
                    border-width: 1px medium medium;
                    font-size: 13px;
                    padding: 10px 15px;
                    font-weight:600;
                }
                .sidebar-listing-search-wrap form input.sidebar-listing-search-input {
                    background-color: #f9f9f9;
                    box-shadow: 0 0 1px 1px #ececec;
                    border: medium none;
                    margin-bottom: 8px;
                    margin-top: 8px;
                    padding: 10px 15px;
                    width: 100%;
                    font-weight:600;
                }
                .sidebar-listing-search-wrap form input.sidebar-listing-search-input::before {
                    -moz-appearance: none;
                    border: medium none;
                    background: #f9f9f9 url('assets/images/form-icon-2.png') no-repeat scroll 100% 0px;
                    box-shadow: 0 0 0 1px #ececec;
                    color: #696969;
                    font-size: 14px;
                    height: 44px;
                    line-height: 56px;
                    margin-bottom: 8px;
                    margin-top: 8px;
                    padding: 0 0 0 15px;
                    text-overflow: '';
                    text-transform: capitalize;
                    width: 100%;
                }
                .sidebar-listing-search-wrap form .listing-search-btn::before {
                    content: '';
                    font-family: FontAwesome;
                    left: 30%;
                    position: absolute;
                    text-align: center;
                    top: 50%;
                    color: #ffffff;
                    transform: translateY(-50%);
                }
                .sidebar-listing-search-wrap form .listing-search-btn {
                    margin-top: 15px;
                    margin-bottom: 25px;
                    position: relative;
                }
                .sidebar-listing-search-wrap form input.sidebar-listing-search-btn {
                    border: 2px solid #f4b703;
                    margin-top: 0;
                    padding: 10px;
                    width: 100%;
                    font-weight: 600;
                    background: transparent linear-gradient(to right, $color 50%, #01273a 50%) repeat scroll right bottom / 207% 100%;
                    color: #ffffff;
                    -webkit-transition: all .6s ease 0;
                    transition: all .6s ease 0;
                    transition: all 0.3s ease 0s;
                }
                .sidebar-listing-search-wrap form input.sidebar-listing-search-btn:hover {
                    border: 2px solid $color;
                    background: transparent linear-gradient(to right, $color 50%, #01273a 50%) repeat scroll right bottom / 207% 100%;
                    background-position: left bottom;
                    color: #ffffff;
                }
                .detail-content h2 {
                    color: #4a4a4a;
                    font-size: 22px;
                    font-weight: 600;
                    line-height: 30px;
                    margin-bottom: 5px;
                }
                .detail-content .detail-video {
                    margin: 25px 0;
                    max-width: 100%;
                    float:left;
                    display:block;
                }
                .contact-heading-title {
                    margin-bottom: 50px;
                }
                .contact-heading-title h1 {
                    margin: 0px;
                    color: #01273a;
                    text-transform: uppercase;
                    font-weight: 700;
                    font-size: 28px;
                }
                .contact-heading-title h1 span {
                    color: $color;
                }
                .clt-content {
                    font-family:'Raleway', sans-serif;
                    color: #696969;
                    display: inline-block;
                    font-size: 14px;
                    font-weight:500;
                    line-height: 28px;
                    margin-bottom: 60px;
                    padding: 0 15px;
                    text-align: left;
                }
                .from-list-lt input {
                    background: #f9f9f9;
                    border: 1px solid #f1f1f1;
                    border-radius: 4px;
                    box-shadow: none;
                    font-size: 14px;
                    font-weight: 500;
                    height: 44px;
                    padding-left: 60px;
                }
                .from-list-lt input:focus {
                    border-color: $color
                }
                .from-list-lt .from-input-ic {
                    border-right: 1px solid rgba(216, 216, 216, 0.6);
                    bottom: 0;
                    left: 15px;
                    padding-right: 15px;
                    position: absolute;
                    top: 0;
                    width: 44px;
                }
                .from-list-lt .from-input-ic i {
                    color: #d8d8d8;
                    font-size: 17px;
                    margin-left: 15px;
                    margin-top: 13px;
                }
                .form-float {
                    transform: translateY(0%);
                }
                .from-list-lt .form-control:focus {
                    background: #fff none repeat scroll 0 0;
                    opacity: 1;
                }
                .from-list-lt textarea {
                    background: #f9f9f9;
                    border: 1px solid #f1f1f1;
                    border-radius: 4px;
                    box-shadow: none;
                    font-size: 14px;
                    font-weight: 500;
                    padding-left: 60px;
                }
                .from-list-lt textarea:focus {
                    border-color: $color
                }
                textarea.form-control {
                    height: 110px;
                    line-height: 26px;
                }
                .from-list-lt .from-input-ic {
                    border-right: 1px solid rgba(216, 216, 216, 0.6);
                    bottom: 0;
                    left: 15px;
                    padding-right: 15px;
                    position: absolute;
                    top: 0;
                    width: 44px;
                }
                .from-list-lt .btn {
                    background: transparent linear-gradient(to right, $color 50%, $color 50%) repeat scroll right bottom / 207% 100%;
                    border-radius: 0;
                    color: #01273a;
                    font-size: 16px;
                    font-weight: 600;
                    height: 46px;
                    line-height:46px;
                    border-radius: 6px; 
                    padding: 0 30px;
                    box-shadow: 0 5px 8px rgba(0, 0, 0, 0.25);
                    text-align: center;
                    text-transform: uppercase;
                    transition: all 0.2s linear 0s;
                    -webkit-transition: all .6s ease 0;
                    transition: all .6s ease 0;
                    transition: all 0.3s ease 0s;
                }
                .from-list-lt .btn:hover {
                    background: transparent linear-gradient(to right, #01273a 50%, #dadada 50%) repeat scroll right bottom / 207% 100%;
                    color: #fff;
                    background-position: left bottom;
                    box-shadow: 0 3px 1px rgba(0, 0, 0, 0.25)
                }
                .verifi_code {
                    border: 1px solid #e5e5e5;
                    border-radius: 4px;
                    box-shadow: 0 0 3px #e5e5e5;
                    font-size: 14px;
                    font-weight: 500;
                    height: 44px;
                    padding-left: 20px !important;
                }
                #captcha {
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    box-shadow: 0 0 7px -4px rgba(0, 0, 0, 0.3);
                    margin-top: 0;
                }
                .buttons input, .captchareload {
                    background: $color;
                    border-color: $color;
                    border-radius: 5px;
                    border-style: solid;
                    border-width: 2px;
                    color: #fff;
                    padding: 2px 5px;
                    vertical-align: middle;
                }
                .captchareload {
                    margin-left: 15px;
                }
                .lt-co-icon {
                    display: block;
                    float: left;
                }
                .lt-co-blok-text {
                    padding-left: 55px;
                }
                .lt-co-title {
                    color: #343d46;
                    font-size: 18px;
                    font-weight: 600;
                }
                .lt-co-blok-text hr {
                    border: 0 none;
                    bottom: 0;
                    height: 2px;
                    left: 0;
                    margin: 10px 0;
                    position: relative;
                    right: 0;
                    text-align: left;
                    top: -3px;
                    width: 10%;
                }
                .lt-co-yellow-hr {
                    background: #494e53 none repeat scroll 0 0 !important;
                }
                .media-iconic .media-body p {
                    color: #343d46;
                    font-size: 14px;
                    font-weight: 500;
                    line-height: 26px;
                    padding-bottom: 10px;
                }
                .lt-bdr-one {
                    border-bottom: 2px solid #494e53;
                }
                .lt-co-blok-text hr {
                    border: 0 none;
                    bottom: 0;
                    height: 2px;
                    left: 0;
                    margin: 10px 0;
                    position: relative;
                    right: 0;
                    text-align: left;
                    top: -3px;
                    width: 10%;
                }
                .lt-co-green-hr {
                    background: #f5c026 none repeat scroll 0 0 !important;
                }
                .lt-bdr-two {
                    border-bottom: 2px solid #f5c026;
                }
                .media-iconic .media-body p b {
                    font-weight: 600;
                }
                .lt-co-blok-text hr {
                    border: 0 none;
                    bottom: 0;
                    height: 2px;
                    left: 0;
                    margin: 10px 0;
                    position: relative;
                    right: 0;
                    text-align: left;
                    top: -3px;
                    width: 10%;
                }
                .lt-bg-blue-hr {
                    background: $color none repeat scroll 0 0 !important;
                }
                .media-iconic .media-body p {
                    color: #7e7e7e;
                    font-size: 14px;
                    font-weight: 500;
                    line-height: 26px;
                    padding-bottom: 10px;
                }
                .lt-bdr-three {
                    border-bottom: 2px solid $color;
                }
                /************************************ dashboard page **************************************/
                #leftcol_item {
                    margin-bottom: 30px;
                }
                .user_dashboard_pic {
                    background: #f9f9f9;
                    border: 1px dashed #e9e9e9;
                    border-radius: 10px;
                    padding: 10px;
                    position: relative;
                    box-shadow: 0 1px 7px rgba(0, 0, 0, 0.1);
                }
                .user_dashboard_pic img {
                    height: auto;
                    width: 100%;
                    border: 1px dashed #e9e9e9;
                    border-radius: 10px;
                }
                .user-photo-action {
                    background: rgba(255, 255, 255, 0.85);
                    bottom: 10px;
                    color: #363636;
                    font-family: 'Open Sans', sans-serif;
                    left: 10px;
                    padding: 10px 0;
                    border-radius: 0 0 10px 10px;
                    position: absolute;
                    height: 44px;
                    line-height: 22px;
                    font-weight: 600;
                    right: 10px;
                    text-align: center;
                }
                .dashboard_nav_item {
                    margin-bottom: 25px;
                }
                .dashboard_nav_item ul {
                    background: #f9f9f9;
                    list-style-type: none;
                    border: 1px solid #e9e6e0;
                    margin-bottom: 0px;
                }
                .dashboard_nav_item ul li {
                    background: transparent linear-gradient(to right, $color 50%, #f9f9f9 50%) repeat scroll right bottom / 207% 100%;
                    width: 100%;
                    display: block;
                    -webkit-transition: background 350ms ease-in-out;
                    transition: background 350ms ease-in-out;
                    border-bottom: 1px solid #e9e6e0;
                }
                .dashboard_nav_item ul li:last-child {
                    border-bottom: 0px;
                }
                .dashboard_nav_item ul li a {
                    font-size: 14px;
                    font-weight: 600;
                    /*color: #4e4e4e;*/
                    height: 46px;
                    line-height: 26px;
                    padding: 10px 12px;
                    text-align: left;
                    display: block;
                    letter-spacing:0.3px;
                    vertical-align: middle;
                }
                .dashboard_nav_item ul li a i {
                    float: right;
                    font-size: 16px;
                    text-align: center !important;
                    padding-top: 5px;
                }
                .dashboard_nav_item ul li:hover {
                    background: transparent linear-gradient(to right, $color 50%, #f9f9f9 50%) repeat scroll right bottom / 207% 100%;
                    background-position: left bottom;
                    border-bottom: 1px solid #e9e6e0
                }
                .dashboard_nav_item ul li.active {
                    background: $color;
                    background-position: left bottom;
                    border-bottom: 1px solid #e9e6e0
                }
                .dashboard_nav_item ul li.active:last-child, .dashboard_nav_item ul li:hover:last-child {
                    border-bottom: 0px;
                }
                #dashboard_listing_blcok {
                    display: block;
                    margin-bottom: 30px;
                }
                #dashboard_listing_blcok .statusbox {
                    background: #fcfcfc;
                    padding: 0;
                    margin-bottom: 30px;
                    box-shadow: 0 1px 10px rgba(0, 0, 0, 0.1);
                    border-radius: 6px;
                    border: 1px solid #e9e6e0;
                }
                #dashboard_listing_blcok .statusbox h3 {
                    padding: 10px;
                    text-align: center;
                    font-size: 15px;
                    font-weight: 600;
                    color: rgba(54, 54, 54, 0.7);
                    text-transform: uppercase;
                    height: 50px;
                    vertical-align: middle;
                    line-height: 30px;
                    margin: 0;
                    border-bottom: 1px solid #e9e6e0;
                }
                #dashboard_listing_blcok .statusbox-content {
                    padding: 25px 0;
                    text-align: center;
                }
                #dashboard_listing_blcok .statusbox .statusbox-content .ic_status_item {
                    display: inline-block;
                    text-align: center;
                    margin: 0 auto 15px auto;
                }
                #dashboard_listing_blcok .statusbox .statusbox-content .ic_status_item i {
                    border-radius: 50px;
                    font-size: 30px;
                    height: 90px;
                    line-height: 90px;
                    text-align: center;
                    vertical-align: middle;
                    width: 90px;
                    box-shadow: 0 0px 7px rgba(0, 0, 0, 0.08);
                }
                #dashboard_listing_blcok .statusbox .statusbox-content .ic_col_one i {
                    background: #d5f6fd;
                    border: 2px solid $color;
                    color: $color
                    ;
                }
                #dashboard_listing_blcok .statusbox .statusbox-content .ic_col_two i {
                    background: #ffe2ec;
                    border: 2px solid #fd6b9c;
                    color: #fd6b9c;
                }
                #dashboard_listing_blcok .statusbox .statusbox-content .ic_col_three i {
                    background: #e3e0f3;
                    border: 2px solid #7264bc;
                    color: #7264bc;
                }
                #dashboard_listing_blcok .statusbox .statusbox-content .ic_col_four i {
                    background: #e7f4e0;
                    border: 2px solid #81c860;
                    color: #81c860;
                }
                #dashboard_listing_blcok .statusbox-content h2 {
                    font-family: 'Open Sans', sans-serif;
                    color:#6e6e6e;
                    display: block;
                    font-size: 26px;
                    font-weight: 600;
                    margin: 0;
                }
                #dashboard_listing_blcok .statusbox-content span {
                    color: rgba(54, 54, 54, 0.6);
                    display: block;
                    font-size: 14px;
                    font-weight: 500;
                    margin-top: 10px;
                }
                #submit_listing_box {
                    background: #f9f9f9;
                    padding: 20px;
                    border: 1px solid #e9e6e0;
                    border-radius: 4px;
                    margin-bottom: 25px;
                }
                #submit_listing_box h3 {
                    padding-bottom: 25px;
                    margin-top: 10px;
                    margin-bottom: 20px;
                    border-bottom: 1px solid #e9e6e0;
                    font-size: 18px;
                    font-weight: 600;
                    text-align: left;
                    color: #4a4a4a;
                }
                #submit_listing_box .form-alt label {
                    display: block;
                    text-align: left;
                    margin-bottom: 8px;
                    color: #696969;
                    font-size: 14px;
                    font-weight: 600;
                }
                #submit_listing_box .form-alt label span {
                    color: #ff0000;
                }
                #submit_listing_box .btn_change_pass {
                    margin: 10px auto;
                    text-align: center;
                    display: inline-block;
                }
                #submit_listing_box .form-alt input {
                    background-color: #fff;
                    border: 0 none;
                    border-radius: 4px;
                    color: #9d9795;
                    height: 44px;
                    border: 1px solid #e9e6e0;
                    font-size: 14px;
                    font-weight: 500;
                    line-height: 22px;
                    padding: 10px;
                    box-shadow: none;
                }

                #submit_listing_box .form-alt select {
                    background-color: #fff;
                    border: 0 none;
                    border-radius: 4px;
                    color: #9d9795;
                    height: 44px;
                    border: 1px solid #e9e6e0;
                    font-size: 14px;
                    font-weight: 500;
                    line-height: 22px;
                    padding: 10px;
                    box-shadow: none;
                }

                #submit_listing_box .form-alt .checkbox input {
                    background-color: #fff;
                    border: 0 none;
                    border-radius: 4px;
                    color: #9d9795;
                    border: 1px solid #e9e6e0;
                    font-size: 14px;
                    font-weight: 500;
                    line-height: 22px;
                    padding: 10px;
                    box-shadow: none;
                }

                #submit_listing_box .form-alt textarea {
                    background-color: #fff;
                    border: 0 none;
                    border-radius: 4px;
                    color: #535353;
                    border: 1px solid #e9e6e0;
                    font-size: 14px;
                    font-weight: 500;
                    height: auto;
                    padding: 10px;
                    box-shadow: none;
                }
                #submit_listing_box .form-group:last-child {
                    margin-bottom: 0;
                }
                #submit_listing_box .form-alt input:focus {
                    border-color: $color;
                    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px rgba(102, 175, 233, 0.6);
                    outline: 0 none;
                }
                #submit_listing_box .form-alt textarea:focus {
                    border-color: $color;
                    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px rgba(102, 175, 233, 0.6);
                    outline: 0 none;
                }
                #submit_listing_box select.selectcategory {
                    background: #ffffff url('assets/images/slt_btn_cat.png') no-repeat scroll right 15px top 50% !important;
                    color: #999999;
                    height: 44px;
                    border: 1px solid #e9e6e0;
                    box-shadow: none;
                    font-size: 14px;
                    font-weight: 500;
                }
                #submit_listing_box select.selectcategory option {
                    padding: 8px 15px;
                    border-bottom: 1px solid #e9e6e0;
                    font-size: 14px;
                    font-weight: 600;
                }
                #location-map {
                    display: block;
                    margin-top: 10px;
                }
                #location-map .map_view_location {
                    cursor: pointer;
                    min-height: 300px;
                    width: 100%;
                }
                .fileupload_block {
                    border: 1px solid #c8d1d3;
                    border-radius: 2px;
                    float: left;
                    margin-bottom: 15px;
                    padding: 10px;
                    width: 100%;
                }
                .fileupload_block #fileupload {
                    float: left;
                    margin-top: 6%;
                }
                .fileupload_img {
                    display: inline-block;
                    float: left;
                    margin-top: 0;
                }
                .fileupload_img img {
                    display: inline-block;
                    height: 120px;
                    width: 120px;
                    border-radius: 6px;
                }
                #submit_listing_box .amenities_block {
                    display: block;
                }
                #submit_listing_box ul.detail-amenities {
                    list-style-type: none;
                }
                .amenities_block .detail-amenities li {
                    display: inline-block;
                    font-size: 14px;
                    line-height: 2.4;
                    margin-right: 15px;
                    width: 30%;
                    text-align: left;
                    float: left;
                }
                .checkbox {
                    padding-left: 25px;
                    margin-top: 5px;
                    margin-bottom: 5px;
                }
                .checkbox label {
                    font-weight:600;
                    color:#696969;
                    display: inline-block;
                    line-height: 20px;
                    padding-left: 10px;
                    position: relative;
                    vertical-align: middle;
                }
                input[type='checkbox'] {
                    line-height: normal;
                    margin: 12px 0 0;
                }
                .checkbox label::before {
                    background-color: #ffffff;
                    border: 1px solid #e0dcd1;
                    border-radius: 3px;
                    content: '';
                    display: inline-block;
                    height: 20px;
                    left: 0;
                    margin-left: -23px;
                    position: absolute;
                    transition: border 0.15s ease-in-out 0s, color 0.15s ease-in-out 0s;
                    width: 20px;
                }
                .checkbox label::after {
                    color: #555;
                    display: inline-block;
                    font-size: 11px;
                    height: 20px;
                    left: 0;
                    margin-left: -23px;
                    margin-top: 0;
                    padding-left: 5px;
                    padding-top: 0;
                    position: absolute;
                    top: 0;
                    width: 20px;
                }
                .checkbox input[type='checkbox'], .checkbox input[type='radio'] {
                    cursor: pointer;
                    opacity: 0;
                    z-index: 1;
                }
                .checkbox input[type='checkbox']:focus + label::before, .checkbox input[type='radio']:focus + label::before {
                    outline: thin dotted;
                    outline-offset: -2px;
                }
                .checkbox input[type='checkbox']:checked + label::after, .checkbox input[type='radio']:checked + label::after {
                    content: '';
                    font-family: 'FontAwesome';
                }
                .checkbox input[type='checkbox']:disabled + label, .checkbox input[type='radio']:disabled + label {
                    opacity: 0.65;
                }
                .checkbox input[type='checkbox']:disabled + label::before, .checkbox input[type='radio']:disabled + label::before {
                    background-color: #eee;
                    cursor: not-allowed;
                }
                .checkbox.checkbox-circle label::before {
                    border-radius: 50%;
                }
                .checkbox.checkbox-inline {
                    margin-top: 0;
                }
                .checkbox-success input[type='checkbox']:checked + label::before, .checkbox-success input[type='radio']:checked + label::before {
                    background-color: #01273a;
                    border-color: #01273a;
                }
                .checkbox-success input[type='checkbox']:checked + label::after, .checkbox-success input[type='radio']:checked + label::after {
                    color: #fff;
                }
                .tg-listing {
                    float: left;
                    padding: 0;
                    width: 100%;
                    text-align:left;
                }
                .tg-listing-head {
                    background:#01273a;
                    color: #fff;
                    float: left;
                    padding:0px 10px;
                    text-transform: uppercase;
                    width: 100%;
                }
                .tg-listing-head .tg-titlebox {
                    border-right: 1px solid rgba(255, 255, 255, 0.3);
                    float: left;
                    padding: 20px 10px;
                    width: 38.33%;
                }
                .tg-listing-head .tg-titlebox:last-child{
                    border-right:0px;
                }
                .tg-listing-head .tg-titlebox h3 {
                    color: #fff;
                    font-size: 18px;
                    line-height: 18px;
                    margin: 0;
                    font-weight:600;
                }
                .tg-list .tg-listbox + .tg-listbox, .tg-listing-head .tg-titlebox + .tg-titlebox {
                    width: 22%;
                }
                .tg-pluck {
                    float: left;
                    width: 100%;
                    margin-bottom:20px;
                }
                .tg-list:nth-child(2n+1) {
                    background: #f3f3f3;
                }
                .tg-list {
                    float: left;
                    padding:10px;
                    width: 100%;
                    background:#ebebeb;
                }
                .tg-listbox .tg-listdata {
                    overflow: hidden;
                    padding-top:3px;
                }
                .tg-listbox .tg-listdata h4 {
                    font-size: 16px;
                    line-height: 16px;
                    margin: 0 0 10px;
                    text-transform: uppercase;
                }
                .tg-list .tg-listbox {
                    float: left;
                    padding:6px 10px;
                    width: 38.33%;
                }
                .tg-list .tg-listbox + .tg-listbox, .tg-listing-head .tg-titlebox + .tg-titlebox {
                    width: 22%;
                }
                .tg-list .tg-listbox:last-child, .tg-listing .tg-titlebox:last-child{
                    width: 14.5%;
                }
                .tg-listbox span {
                    font-family: 'Open Sans', sans-serif;
                    font-size:14px;
                    display: block;
                }
                .list_user_thu{
                    border:1px solid #c7c5d2;
                    float: left;
                    margin: 0 15px 0 0;
                    border-radius:50px;
                    padding:4px;
                }
                .list_user_thu img{
                    width:75px;
                    height:75px;
                    border-radius:50px;
                }
                .tg-btn-list {
                    background:#01273a;
                    color: #fff;
                    float: left;
                    box-shadow:0 1px 7px rgba(0, 0, 0, 0.1);
                    line-height: 40px;
                    text-align: center;
                    width: 40px;
                    border-radius:6px;
                }
                a.tg-btn-list:hover, a.tg-btn-list:focus{
                    background:$color;
                    box-shadow:0 4px 5px rgba(0, 0, 0, 0.3);
                    color:#373542;
                }
                .tg-listbox .tg-btn-list + .tg-btn-list {
                    margin: 0 0 0 10px;
                }
                .tg-listdata h4 a{
                    font-family: 'Open Sans', sans-serif;
                    color:#4e4e4e;
                    font-weight:700;
                    font-size:16px;
                    text-transform:uppercase;
                }
                .tg-listdata h4 a:hover{
                    color:$color;
                }
                .tg-listbox .tg-listdata span, .tg-listbox .tg-listdata time{
                    font-family: 'Open Sans', sans-serif;
                    font-size:14px;
                    color:#6f6f6f;
                }
                @media(min-width:768px) and (max-width:1199px){
                .tg-list .tg-listbox::after {
                    background:#01273a;
                    color: #fff;
                    content: attr(data-title);
                    font-family: 'Montserrat',Arial,Helvetica,sans-serif;
                    font-size: 18px;
                    height: 100%;
                    left: 0;
                    line-height: 102px;
                    padding: 0 15px;
                    position: absolute;
                    text-transform: uppercase;
                    top: 0;
                    width: 46%;
                }
                .tg-list .tg-listbox:nth-child(2)::after {
                    content: attr(data-viewed);
                    line-height: 50px;
                }
                .tg-list .tg-listbox:nth-child(3)::after {
                    content: attr(data-favorites);
                    line-height: 40px;
                }
                .tg-list .tg-listbox:nth-child(4)::after {
                    content: attr(data-action);
                    line-height: 40px;
                }
                .tg-listing-head {
                    display:none;
                }
                .tg-list .tg-listbox + .tg-listbox, .tg-list .tg-listbox {
                    padding: 15px 15px 15px 50%;
                    position: relative;
                    width: 100% !important;
                }
                .tg-listing-head {
                    background: #373542 none repeat scroll 0 0;
                    color: #fff;
                    float: left;
                    padding: 15px;
                    text-transform: uppercase;
                    width: 100%;
                }
                }
                @media (max-width:767px){
                .tg-list .tg-listbox::after {
                    background: #01273a;
                    color: #fff;
                    content: attr(data-title);
                    font-family: 'Montserrat',Arial,Helvetica,sans-serif;
                    font-size: 18px;
                    height: 100%;
                    left: 0;
                    line-height: 102px;
                    padding: 0 15px;
                    position: absolute;
                    text-transform: uppercase;
                    top: 0;
                    width: 46%;
                }
                .tg-list .tg-listbox:nth-child(2)::after {
                    content: attr(data-viewed);
                    line-height: 50px;
                }
                .tg-list .tg-listbox:nth-child(3)::after {
                    content: attr(data-favorites);
                    line-height: 40px;
                }
                .tg-list .tg-listbox:nth-child(4)::after {
                    content: attr(data-action);
                    line-height: 40px;
                }
                .tg-listing-head {
                    display:none;
                }
                .tg-list .tg-listbox + .tg-listbox, .tg-list .tg-listbox {
                    padding: 15px 15px 15px 50%;
                    position: relative;
                    width: 100% !important;
                }
                .tg-listing-head {
                    background: #373542 none repeat scroll 0 0;
                    color: #fff;
                    float: left;
                    padding: 15px;
                    text-transform: uppercase;
                    width: 100%;
                }
                }
                @media (max-width:480px){
                .tg-list .tg-listbox::after {
                    font-size: 14px;
                    height: 100%;
                    padding: 0 7px;
                    width: 34%;
                }
                .tg-list .tg-listbox + .tg-listbox, .tg-list .tg-listbox {
                    padding: 15px 15px 15px 36%;
                    position: relative;
                    width: 100% !important;
                }
                .tg-listbox span {
                    display: inline-block;
                    float: none;
                    margin: 0 auto 15px 0;
                    text-align: center;
                }
                }
                /************************************ error page **************************************/
                div.error-page-alt {
                    background-color: #fff;
                    background-position: 50% 50%;
                    background-repeat: no-repeat;
                    background-size: cover;
                    padding: 7rem 0;
                    position: relative;
                    z-index: 0;
                }
                .f-title-error span {
                    color: #01273a;
                    font-size: 13.0769em;
                    line-height: 0.76471;
                }
                .b-title-error span, .b-title-error strong {
                    display: block;
                    text-align: center;
                }
                .f-title-error strong {
                    color: #35385b;
                    font-size: 44px;
                    font-weight: 400;
                    margin-top: 10px;
                }
                .f-error-description span, .f-error-description strong {
                    color: #6d7a83;
                }
                .f-error-description strong {
                    font-size: 22px;
                    font-weight: 600;
                    line-height: 1.2;
                    margin-bottom: 10px;
                }
                .f-title-error .f-primary-eb {
                    font-family: 'Open Sans', sans-serif;
                    font-weight: 800;
                }
                .f-error-description span, .f-error-description strong {
                    color: #6d7a83;
                }
                .f-error-description span {
                    font-size: 14px;
                    line-height: 1.2;
                }
                .b-error-search .b-input-search {
                    padding-right: 40px;
                }
                .b-form-row, .b-form-row--big {
                    margin-bottom: 10px;
                }
                .b-error-description {
                    margin: 20px 0 0;
                }
                .b-error-description span, .b-error-description strong {
                    display: block;
                    text-align: center;
                }
                .b-error-search .form-control {
                    background-color: #fff;
                    background-image: none;
                    border: 1px solid #d3dadc;
                    border-radius: 4px;
                    color: #666;
                    box-shadow: 3px 4px 8px rgba(0, 0, 0, 0.14);
                    display: block;
                    font-size: 14px;
                    height: 42px;
                    line-height: 42px;
                    padding: 6px 12px;
                    width: 100%;
                }
                .b-error-search {
                    margin: 40px auto 0;
                    max-width: 375px;
                }
                .b-error-search .b-btn-search {
                    height: 42px;
                    width: 44px;
                }
                .b-error-search .f-btn-search {
                    font-size: 18px;
                    line-height: 26px;
                }
                .b-form-row .b-btn {
                    background: #01273a none repeat scroll 0 0;
                    cursor: pointer;
                    display: inline-block;
                    padding: 8px 14px;
                }
                .b-input-search {
                    padding-right: 47px;
                    position: relative;
                }
                .b-btn-search {
                    color: #35385b;
                    font-size: 1.07692em;
                    line-height: 2.42857;
                    text-align: center;
                    border-radius: 2px 4px 4px 2px;
                    position: absolute;
                    right: 0;
                    top: 0;
                    width: 34px;
                }
                @media(min-width:481px) and (max-width:767px){
                  .recent-listing-box-image img{
                    width:50% !important;
                    height:50% !important;
                  }
                }

                @media(min-width:979px) and (max-width:1200px){
                  .recent-listing-box-image img{
                    width:50% !important;
                    height:50% !important;
                  }
                }

        ";

        $response = response($contents);
        $response->header('Content-Type','text/css');
        return $response;
    }


    
}
