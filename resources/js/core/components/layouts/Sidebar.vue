<template>
  <nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div
      class="
        text-center
        navbar-brand-wrapper
        d-flex
        align-items-center
        justify-content-center
      "
    >
      <a class="navbar-brand brand-logo" :href="logoUrl">
        <img :src="logoSrc" alt="logo" />
      </a>
      <a class="navbar-brand brand-logo-mini" :href="logoUrl">
        <img :src="logoIconSrc" alt="logo" />
      </a>
    </div>

    <ul class="nav nav-scrolling">
      <li class="nav-item" v-if="is_admin == 1">
        <a class="nav-link" href="/admin/dashboard">
          <span class="icon-wrapper">
            <app-icon name="pie-chart" class="menu-icon" />
          </span>
          <span class="menu-title">Dashboard</span>
          <!-- <i class="menu-arrow"/> -->
        </a>
      </li>

      <!-- <li class="nav-item" v-if="is_admin == 1">
        <a class="nav-link" href="/admin/reports">
          <span class="icon-wrapper">
            <app-icon name="pie-chart" class="menu-icon" />
          </span>
          <span class="menu-title">Reports</span>
          
        </a>
      </li> -->

      <li class="nav-item" v-for="(item, index) in data" :key="index" >
      
        <a
          class="nav-link"
          :data-target="'#'+item.id"
          :data-toggle="item.id ? 'collapse' : false"
        >
          <span class="icon-wrapper">
            <app-icon :name="item.icon" class="menu-icon" />
          </span>
          <span class="menu-title">{{ item.name }}</span>
          <i v-if="item.subMenu" class="menu-arrow" />
        </a>

        <div class="collapse" v-if="item.subMenu" :id="item.id">
          <ul class="nav flex-column ">
            <li
              class="nav-item"
              v-for="(submenuItem, index) in item.subMenu"
              :key="item.id+'sub'+submenuItem.id"
              v-if="item.multiple==1">
              <a
                class="nav-link"
                :data-target="'#'+item.id+'sub'+submenuItem.id"
                :data-toggle="submenuItem.id ? 'collapse' : false"                
              >
                <span class="icon-wrapper">
                  <app-icon :name="submenuItem.icon" class="menu-icon" />
                </span>
                <span class="menu-title">{{ submenuItem.name }}</span>
                <i v-if="submenuItem.subMenu" class="menu-arrow" />
              </a>
              <div
                class="collapse"
                v-if="submenuItem.subMenu"
                :id="item.id+'sub'+submenuItem.id"
                
              >
                <ul class="nav flex-column sub-menu">
                  <li
                    class="nav-item "
                    v-for="(undersubmenuItem, index) in submenuItem.subMenu"
                    :key="index"
                  >
                    <a class="nav-link" :href="undersubmenuItem.url " :id="'link'+undersubmenuItem.name+'sub'+submenuItem.id"
>
                      {{ undersubmenuItem.name }}
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <li
              class="nav-item"
              v-for="(submenuItem, index) in item.subMenu"
              :key="index"
              v-if="item.multiple==2"
            >
              <a class="nav-link" :href="submenuItem.url">
                {{ submenuItem.name }}
              </a>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </nav>
  <!-- <nav class="sidebar sidebar-offcanvas" id="sidebar"> 
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
      <a class="navbar-brand brand-logo" :href="logoUrl">
        <img :src="logoSrc" alt="logo"/>
      </a>
      <a class="navbar-brand brand-logo-mini" :href="logoUrl">
        <img :src="logoIconSrc" alt="logo"/>
      </a>
    </div>

    <ul class="nav nav-scrolling">

      <li class="nav-item" v-for="(item, index) in data" :key="index" v-if="item.permission">
        <a class="nav-link"
           :href="item.id ? '#'+item.id : item.url"
           :data-toggle="item.id ? 'collapse' : false"
           :aria-expanded="item.id ? 'false' : false"
           :aria-controls="item.id ? item.id : false">
                    <span class="icon-wrapper">
                        <app-icon :name="item.icon" class="menu-icon"/>
                    </span>
          <span class="menu-title">{{ item.name }}</span>
          <i v-if="item.subMenu" class="menu-arrow"/>
        </a>

        <div class="collapse" v-if="item.subMenu" :id="item.id">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"
                v-for="(submenuItem, index) in item.subMenu"
                :key="index"
                v-if="submenuItem.permission === true || submenuItem.permission === ''">
              <a class="nav-link" :href="submenuItem.url">
                {{ submenuItem.name }}
              </a>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </nav>  -->
</template>

<script>
import AppFunction from "../../helpers/app/AppFunction";

export default {
  name: "Sidebar",
  
  props: {
    data: {
      // type: Array,
      required: true,
    },
    logoSrc: {
      type: String,
      default: AppFunction.getAppUrl("images/core.png"),
    },
    logoIconSrc: {
      type: String,
      default: AppFunction.getAppUrl("images/core.png"),
    },
    logoUrl: {
      type: String,
      default: "/",
    },
    is_admin: "",
  },
  mounted() {
    
    this.$nextTick(function () {
      let body = $("body"),
        current = location.pathname,
        sidebar = $(".sidebar"),
        sidebarType = localStorage.getItem("sidebar");
        
      $(function () {
        
        // Add active class to nav-link based on url dynamically
        function addActiveClass(element) {
          console.log(element);
          if (element.attr("href").indexOf(current) !== -1) {
            console.log('attribte href');
            element.parents(".nav-item").last().addClass("active");
            if (sidebarType === "floating") {
              if (element.parents(".sub-menu").length) {
                console.log("sub menu")
                element.closest(".collapse").removeClass("show");
                element.addClass("active");
              }
              if (element.parents(".submenu-item").length) {
                console.log('sub item')
                element.addClass("active");
              }
            } else {
              if (element.parents(".sub-menu").length) {
                console.log('not floating submenu');
                element.closest(".collapse").addClass("show");
                element.addClass("active");
              }
              if (element.parents(".submenu-item").length) {
                console.log('not floating submenu item');
                element.addClass("active");
              }
            }
          }
        }

        $(".nav li a", sidebar).each(function () {
          let $this = $(this);
          addActiveClass($this);
        });

        $(".horizontal-menu .nav li a").each(function () {
          let $this = $(this);
          addActiveClass($this);
        });

        // Close other submenu in sidebar on opening any
        sidebar.on("show.bs.collapse", ".collapse", function () {
          sidebar.find(".collapse.show").collapse("hide");
        });

        // Change sidebar and content-wrapper height
        applyStyles();

        function applyStyles() {
          //Applying perfect scrollbar
          if (!body.hasClass("rtl")) {
            if (body.hasClass("sidebar-fixed")) {
              let fixedSidebarScroll = new PerfectScrollbar("#sidebar .nav");
            }
          }
        }
      });

      // Sidebar collapse menu on hover
      $(document).on(
        "mouseenter mouseleave click",
        ".sidebar .nav-item",
        function (ev) {
          let body = $("body");
          let sidebarIconOnly = body.hasClass("sidebar-icon-only");
          let sidebarFixed = body.hasClass("sidebar-fixed");
          if (sidebarIconOnly) {
            if (sidebarFixed) {
              if (ev.type === "mouseenter") {
                body.removeClass("sidebar-icon-only");
              }
            } else {
              let $menuItem = $(this);
              if (ev.type === "mouseenter") {
                $menuItem.addClass("hover-open");
              } else if (ev.type === "click") {
                $menuItem.addClass("hover-open");
              } else {
                $menuItem.removeClass("hover-open");
              }
            }
          }
        }
      );

      // Close collapse menu when mouse leave from sidebar hover only
      $(document).on(
        "mouseenter mouseleave",
        ".sidebar-hover-only .sidebar",
        function (ev) {
          if (ev.type === "mouseleave") {
            $(".sidebar").find(".collapse.show").collapse("hide");
          } else {
          }
        }
      );
    });
  },
};
</script>
