<template>
  <div class="gird my-2 grid-cols-4 text-gray-200">
    <div class="">
      <select name="" id="" class="w-full border-none bg-neutral-800 px-2">
        <option value="">Mới cập nhật</option>
      </select>
    </div>
    <div class="">
      <fieldset class="space-y-1 text-gray-100">
        <legend class="hidden">Search</legend>
        <div class="relative">
          <input
            value=""
            type="search"
            placeholder="Từ Khóa..."
            class="w-full rounded-md border-none bg-zinc-800 pl-4 text-sm text-gray-100 focus:bg-zinc-800 focus:outline-none sm:h-9 sm:w-64"
          />
        </div>
      </fieldset>
    </div>
    <div class="mb-5 w-full border-b border-gray-500 pb-2 pt-1 text-center">
      <button
        type="button"
        class="mb-2 translate-y-1 rounded-full bg-[#A3765D] px-5 py-2 text-sm font-medium text-gray-300 hover:opacity-90"
      >
        Tìm Kiếm
      </button>
    </div>
  </div>
</template>
