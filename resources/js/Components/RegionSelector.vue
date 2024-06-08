<script setup>
import { ref } from 'vue';

const props = defineProps({
  regionList: {
    type: Array,
    required: true,
    default: () => [],
  },
  selectedRegion: {
    type: String,
    required: true,
    default: '',
  },
  onRegionChange: {
    type: Function,
    required: true,
  },
});

const selectedRegionValue = ref(props.selectedRegion);

const handleChange = () => {
  props.onRegionChange(selectedRegionValue.value);
};
</script>

<template>
  <div>
    <!-- <label for="region">Select Region:</label> -->
    <select class="rounded-lg cursor-pointer" v-model="selectedRegionValue" id="region" @change="handleChange">
      <option v-for="(region, index) in props.regionList" :key="index">{{ region }}</option>
    </select>
  </div>
</template>
