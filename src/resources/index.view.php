<?php includeComponent("header.php") ?>

  <h1>Index page</h1>

  <h3><?= $description ?></h3>

  <div x-data="{ count: 0 }">
    <button @click="count++">Increment</button>
    <span x-text="count"></span>
    <button @click="count--">Decrement</button>
  </div>

<?php includeComponent("footer.php") ?>
