<template>
  <div class="relative overflow-visible">
    <input
      :id="id"
      v-model="filter"
      @focus="showSugestions = true"
      placeholder="Search..."
      type="text"
      autocomplete="off"
      class="bg-white dark:text-gray-500 dark:bg-gray-900 p-2 rounded-md flex w-full"
    />

    <button
      @click="toogleSugestion()"
      class="border-l border-gray-400 absolute right-0 top-0 p-2 text-gray-500"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
        class="w-6 h-6"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M19.5 8.25l-7.5 7.5-7.5-7.5"
        />
      </svg>
    </button>

    <!-- Sugestions container -->
    <div
      v-show="showSugestions"
      class="dark:bg-gray-700 border-2 dark:border-gray-800 z-10 absolute w-full rounded-md transition-all duration-300 max-h-52 overflow-y-auto"
    >
      <ul class="w-full text-gray-400">
        <li
          @click="selectItem(item)"
          v-for="(item, index) in items"
          class="hover:bg-gray-600 p-2 cursor-pointer transition duration-300 ease-in border-b hover:rounded-b-md last:border-none border-gray-800"
        >
          {{ item.name }}
        </li>
      </ul>
    </div>
  </div>
</template>
<script setup>
import { onMounted, ref, watch } from "vue";

const props = defineProps({
  data: { type: Object, required: true },
  modelValue: {
    type: Number,
    required: false,
  },
  id: "",
});

const emit = defineEmits(["update:modelValue"]);

// All shown items in sugestions
const items = ref([]);

// User filter to search in
const filter = ref("");

const showSugestions = ref(false);

// Close/open sugestions container
const toogleSugestion = () => {
  showSugestions.value = !showSugestions.value;
};

// When user selects an item from sugestions
const selectItem = (item) => {
  filter.value = item.name;
  showSugestions.value = false;

  emit("update:modelValue", item.id);
};

// Watching filter to find items
watch(filter, function (newFilter, oldFilter) {
  items.value = props.data.filter(
    (item) => item.name.toUpperCase().indexOf(newFilter.toUpperCase()) > -1
  );
});

onMounted(() => {
  items.value = props.data;
  if (props.modelValue) {
    filter.value = props.data.find((item) => item.id == props.modelValue).name;
  }
});
</script>
