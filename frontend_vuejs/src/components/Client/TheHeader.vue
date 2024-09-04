<template>
  <header
    class="fixed top-0 z-50 flex h-12 w-full items-center justify-between border-b border-b-gray-500 bg-[#111111E6] p-4 text-white"
  >
    <div class="top-bar-left flex items-center gap-2">
      <button class="button-menu py-2 pr-2">
        <i class="fa-solid fa-bars-staggered"></i>
      </button>
      <router-link :to="{ name: 'index' }" class="logo h-full">
        <img
          class="h-[20px] object-contain"
          src="https://cdn.imgbin.com/5/1/12/imgbin-graphics-logo-netflix-television-macbeth-2015-netflix-kPXbSVnavRXtmVvYLe7VMZHPk.jpg"
          alt=""
        />
      </router-link>
      <nav class="nav-left fixed left-0 top-0 h-full w-full bg-[#000000aa]">
        <div
          class="nav__wrap flex h-full w-3/4 flex-col gap-2 bg-black px-5 py-2"
        >
          <div class="nav__header flex justify-end">
            <button class="py-2 pl-2">
              <i class="fa-solid fa-xmark fa-xl"></i>
            </button>
          </div>
          <div class="nav__body">
            <ul class="logged border-b border-b-gray-800 py-5">
              <li class="flex gap-3 font-medium">
                <span>
                  <i class="fa-solid fa-circle-user fa-xl"></i>
                </span>
                <span>Đăng nhập</span>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
    <div class="top-bar-right">
      <button class="button-search px-3">
        <i class="fa-solid fa-magnifying-glass"></i>
      </button>
      <button class="button-user pl-3">
        <i class="fa-solid fa-user"></i>
      </button>
    </div>
  </header>
</template>
