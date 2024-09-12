<template>
  <footer class="bg-black">
    <div
      class="flex flex-col justify-between gap-10 space-y-8 px-6 py-10 lg:flex-row lg:space-y-0"
    >
      <div class="lg:w-1/3">
        <a href="/" class="flex justify-center space-x-3 lg:justify-start"
          ><div class="flex items-center justify-center pb-2">
            <img
              src="/src/assets/images/netflix-logo.png"
              onerror="this.setAttribute('data-error', 1)"
              width="150"
              height="35"
              alt="Linhphim"
              loading="lazy"
              data-nuxt-img=""
            /></div
        ></a>
        <div class="pt-2">
          <p class="text-sm text-gray-300">
            <a class="text-red-400 hover:opacity-90" href="/"
              ><strong>Linhphim</strong></a
            >
            - Trang web xem phim trực tuyến miễn phí chất lượng cao với giao
            diện trực quan, tốc độ tải trang nhanh, cùng kho phim với hơn
            10.000+ phim mới, phim hay, luôn cập nhật phim nhanh, hứa hẹn sẽ đem
            lại phút giây thư giãn cho bạn.
          </p>
        </div>
      </div>
      <div
        class="grid grid-cols-2 gap-x-3 gap-y-8 text-base md:grid-cols-3 lg:w-2/3"
      >
        <div class="space-y-3">
          <span class="uppercase tracking-wide text-gray-50">Danh Mục</span>
          <ul class="space-y-1">
            <li>
              <a
                class="text-sm text-gray-400 hover:text-blue-600"
                title="Phim Mới"
                href="/phim-moi"
                >Phim Mới</a
              >
            </li>
            <li>
              <a
                class="text-sm text-gray-400 hover:text-blue-600"
                title="Phim Chiếu Rạp"
                href="/phim-chieu-rap"
                >Phim Chiếu Rạp</a
              >
            </li>
            <li>
              <a
                class="text-sm text-gray-400 hover:text-blue-600"
                title="Phim Bộ"
                href="/phim-bo"
                >Phim Bộ</a
              >
            </li>
            <li>
              <a
                class="text-sm text-gray-400 hover:text-blue-600"
                title="Phim Lẻ"
                href="/phim-le"
                >Phim Lẻ</a
              >
            </li>
          </ul>
        </div>
        <div class="space-y-3">
          <span class="uppercase text-gray-50">Thể Loại</span>
          <ul class="space-y-1">
            <li>
              <a
                class="text-sm text-gray-400 hover:text-blue-600"
                title="Phim Cổ Trang"
                href="/the-loai/co-trang"
                >Phim Cổ Trang</a
              >
            </li>
            <li>
              <a
                class="text-sm text-gray-400 hover:text-blue-600"
                title="Phim Đam Mỹ"
                href="/the-loai/phim-bl"
                >Phim Đam Mỹ</a
              >
            </li>
            <li>
              <a
                class="text-sm text-gray-400 hover:text-blue-600"
                title="Phim Bách Hợp"
                href="/the-loai/bach-hop"
                >Phim Bách Hợp</a
              >
            </li>
            <li>
              <a
                class="text-sm text-gray-400 hover:text-blue-600"
                title="Phim Viễn Tưởng"
                href="/the-loai/vien-tuong"
                >Phim Viễn Tưởng</a
              >
            </li>
          </ul>
        </div>
        <div class="space-y-3">
          <span class="uppercase tracking-wide text-gray-50">Thành viên</span>
          <ul class="space-y-1">
            <li>
              <a
                class="text-sm text-gray-400 hover:text-blue-600"
                title="Nguyễn Văn Linh"
                href="https://www.facebook.com/profile.php?id=100010431287202"
                >Nguyễn Văn Linh</a
              >
            </li>
            <li>
              <a
                class="text-sm text-gray-400 hover:text-blue-600"
                title="Nguyễn Thanh Thủy"
                href="https://www.facebook.com/profile.php?id=100037167123537"
                >Nguyễn Thanh Thủy</a
              >
            </li>
            <li>
              <a
                class="text-sm text-gray-400 hover:text-blue-600"
                title="Tô Văn Quân "
                href="https://www.facebook.com/tovan.quan.9847"
                >Tô Văn Quân </a
              >
            </li>
            <li>
              <a
                class="text-sm text-gray-400 hover:text-blue-600"
                title="Vũ Thế Sơn"
                href="https://www.facebook.com/son.the.714"
                >Vũ Thế Sơn</a
              >
            </li>
            <li>
              <a
                class="text-sm text-gray-400 hover:text-blue-600"
                title="Nguyễn Đăng Thành"
                href="https://www.facebook.com/profile.php?id=100065308574071"
                >Nguyễn Đăng Thành</a
              >
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
</template>
