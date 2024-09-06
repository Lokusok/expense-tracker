<?php includeComponent("header.php") ?>

<div
  class="p-6"
  x-data="{
    basicData: {
      username: '<?= $user['full_name'] ?>',
      email: '<?= $user['email'] ?>',
      avatarUrl: '<?= $user['avatar_url'] ?>'
    },
    editData: {
      username: '<?= $user['full_name'] ?>',
      email: '<?= $user['email'] ?>',
      avatarUrl: '<?= $user['avatar_url'] ?>'
    },
    handleAvatarUpload(event) {
      const file = event.target.files.item(0);
      const avatarUrl = URL.createObjectURL(file);

      this.editData.avatarUrl = avatarUrl;
    },

    get isSubmitDisabled() {
      let result = true;

      for (const key in this.editData) {
        if (this.basicData[key] !== this.editData[key].trim()) {
          result = false;
        }
      }

      console.log({ result })

      return result;
    }
  }"
>
  <form action="/profile/update?id=<?= $user['id'] ?>" method="POST">
    <input type="hidden" name="_method" value="patch">

    <div class="space-y-12">
      <div class="border-b border-gray-900/10 pb-12">
        <h2 class="text-base font-semibold leading-7 text-gray-900">
          Профиль пользователя <?= $user['full_name'] ?>
        </h2>
        <p class="mt-1 text-sm leading-6 text-gray-600">
          Данная информация видна только вам.
        </p>

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
          <div class="sm:col-span-4">
            <label for="username" class="block text-sm font-medium leading-6 text-gray-900">
              Имя пользователя
            </label>
            <div class="mt-2">
              <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                <input
                  x-model="editData.username"
                  value="<?= $user['full_name'] ?>"
                  type="text"
                  name="username"
                  id="username"
                  autocomplete="username"
                  class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                  placeholder="Ваше имя"
                >
              </div>
            </div>
          </div>

          <div class="sm:col-span-4">
            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">
              Почта
            </label>
            <div class="mt-2">
              <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                <input
                  x-model="editData.email"
                  value="<?= $user['email'] ?>"
                  type="text"
                  name="email"
                  id="email"
                  autocomplete="email"
                  class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                  placeholder="Ваша почта"
                >
              </div>
            </div>
          </div>

          <div class="col-span-full">
            <label for="photo" class="block text-sm font-medium leading-6 text-gray-900">
              Аватар
            </label>
            <div class="mt-2 flex items-center gap-x-3">
              <img
                :src="editData.avatarUrl"
                :alt="basicData.username"
                class="w-[60px] h-[60px] rounded-[50%] object-cover"
              > 
              <button
                type="button"
                class="relative rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 cursor-pointer"
              >
                <input
                  type="file"
                  class="opacity-0 absolute left-0 top-0 w-[100%] h-[100%] cursor-pointer"
                  @change="handleAvatarUpload"
                >
                Изменить
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-5">
      <button
        :disabled="isSubmitDisabled"
        type="submit"
        class="rounded-md bg-blue-800 text-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-blue-500 active:opacity-50 disabled:pointer-events-none disabled:bg-gray-500 disabled:opacity-50"
      >
        Применить изменения
      </button>
    </div>
  </form>
</div>

<?php includeComponent("footer.php") ?>