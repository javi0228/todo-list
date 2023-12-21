<script setup>
import Navigation from "./Navigation.vue";

</script>

<template>
  <div>
    <!-- navigation  -->
    <Navigation />
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
      <!-- Page Heading -->
      <header class="bg-white dark:bg-gray-800 shadow" v-if="$slots.header">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <slot name="header" />
        </div>
      </header>

      <!-- Page Content -->
      <main>
        <div class="py-12">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
              class="bg-white dark:bg-gray-800 overflow-y-visible shadow-sm sm:rounded-lg p-6"
            >
              <slot />
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>
